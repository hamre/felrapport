<?php
/**
 * 
 * PHP version 5
 * 
 * LICENSE: This source file is subject to the MIT License, available
 * at http://www.opensource.org/licenses/mit-license.html
 * 
 * @author      Björn Ax <bjorn.ax@gmail.com>
 * @copyright   2013 Björn Ax
 * @license     http://www.opensource.org/licenses/mit-license.html
 */

class user extends DB_Connect {
    
    /*
     * Check if user is logged in
     */
    public function logged_in() {
        return (isset($_SESSION['user_id'])) ? true : false;
    }
    
    /*
     * Protects pages that only logged in user can access
     */
    public function protect_page() {
        if($this->logged_in() === false)
        {
            header("Location: protected.php");
            exit();
        }
    }
    
    /*
     * Encrypts password with salt and SHA-512
     */
    public function crypt_password($password) {
        $salt = '';
        $passwordcrypt = crypt($password, $salt);

        return $passwordcrypt;
    }
    
    /*
     * Get user_id from email adress
     */
    public function user_id_from_email($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email";
        
        try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        } catch(Exception $e) {
            die($e->getMessage());
          }
            return $result;
    }
    
    /*
     * Get user_id from username
     */
    public function user_id_from_username($username) {
        $sql = "SELECT user_id FROM users WHERE username = :user";
        
        try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":user", $username);
            $stmt->execute();
            $result = $stmt->fetch();
            $stmt->closeCursor();
        } catch(Exception $e) {
            die($e->getMessage());
          }
        return $result;
    }
    
    /*
     * Get the users data
     */
    public function user_data($user_id) {
        $data = array();
        $user_id = (int)$user_id;
  
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
  
        if($func_num_args > 1) {            
            unset($func_get_args[0]);                    
        }
        
        $fields = implode(", ", $func_get_args);
        $sql = "SELECT $fields FROM users WHERE user_id = :user_id";
        
        try{
            $data = $this->db->prepare($sql);
            $data->bindParam(":user_id", $user_id);
            $data->execute();
            $result = $data->fetch();
            $data->closeCursor();
        } catch(Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }
    
    /*
     * Login the user
     */
    public function login($username, $password) {
        $user_id = $this->user_id_from_username($username);        
        $password = $this->crypt_password($password);

        try {
            $query = $this->db->prepare("SELECT COUNT(user_id) AS id FROM users WHERE username = :user AND password = :pass");
            $query->execute(array("user" => $username, "pass" => $password));
            $r = $query->fetch();
        } catch(Exception $e) {
            die($e-getMessage());
        }

        return ($r['id'] == 1) ? $user_id : false;
    }
    
    /*
     * Creates the HTML syntax for outputting errors
     */
    public function output_errors($errors) {
        $output = array();
        foreach($errors as $error) {
            $output[] = '<li>'.$error.'</li>';
        }
        
        return '<ul>'.implode('', $output).'</ul>';
    }
    
    /*
     * Check if user is admin
     */
    public function is_admin($user_id) {
        $user_id = (int)$user_id;
        
        $sql = "SELECT admin FROM users WHERE user_id = :id";
        
        try {
            $query = $this->db->prepare($sql);
            $query->bindParam(":id", $user_id);
            $query->execute();
            $r = $query->fetch();
            $query->closeCursor();
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
        
        return $r['admin'];
    }
    
    /*
     * Check if user is logged in and redirect from pages that logged
     * in user can't access
     */
    public function logged_in_redirect() {
	if($this->logged_in() === true) {
            header("Location: index.php");
            exit();		
	}
    }
    
    /*
     * Fetches all vehicles
     * Allows an int to be passed to sort out active and non active vehicles
     * 
     * 0 = Not active
     * 1 = Active
     */
    public function return_busses($data) {
        $data = (int)$data;
        
        $sql = "SELECT * FROM bussar WHERE aktiv = :aktiv ORDER BY typ DESC, regnr ASC";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":aktiv", $data);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return $r;
    }
    
    /*
     * Protect pages that only an admin is allowed to see
     */
    public function admin_protect() {
        global $user_data;    
  
        if($this->is_admin($user_data['user_id']) == 0) {
            header("Location: index.php");
            exit();
        }
    }
    
    /*
     * Adds a vehicle to the database
     */
    public function add_buss($register_data) {
        $sql = "INSERT INTO bussar (marke, ar, typ, regdatum, regnr) VALUES (:marke, :ar, :typ, NOW(), :regnr)";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":marke", $register_data['marke']);
            $stmt->bindParam(":ar", $register_data['ar']);
            $stmt->bindParam(":typ", $register_data['typ']);            
            $stmt->bindParam(":regnr", $register_data['regnr']);
            $stmt->execute();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * Adds the fault to the database
     */
    public function add_fel($register_data) {
        $sql = "INSERT INTO fel (regnr, allvar, beskrivning, datum, vem) VALUES (:regnr, :allvar, :besk, NOW(), :vem)";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $register_data['regnr']);
            $stmt->bindParam(":allvar", $register_data['allvar']);
            $stmt->bindParam(":besk", $register_data['desc']);
            $stmt->bindParam(":vem", $register_data['vem']);            
            $stmt->execute();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * Check if the vehicle already exists in the database
     */
    public function buss_exist($regnr) {
        $sql = "SELECT COUNT(id) AS id FROM bussar WHERE regnr = :regnr AND aktiv = 1";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $regnr);
            $stmt->execute();
            $r = $stmt->fetch();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return ($r['id'] == 1) ? true : false;
    }
    
    /*
     * Fetch every active faults for a vehicle
     */
    public function get_fel($regnr){
        $sql = "SELECT * FROM fel WHERE regnr = :regnr AND aktiv = 1 ORDER BY allvar DESC, datum DESC";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $regnr);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return $r;
    }
    
    /*
     * Returns faults with a specified id
     */
    public function get_klara_fel_by_id($id){
        $sql = "SELECT * FROM fel WHERE aktiv = 0 && id = :id";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $r = $stmt->fetch();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return $r;
    }            
    
    /*
     * Fetch every non active faults for a vehicle within 1 month
     */
    public function get_klara_fel($regnr) {
        $sql = "SELECT * FROM fel WHERE regnr = :regnr && aktiv = 0 && klar_datum >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $regnr);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage);
        }
        return $r;
    }
    
    /*
     * fetch a specifik fault using an id
     */
    public function get_fel_by_id($regnr, $id) {
        $sql = "SELECT * FROM fel WHERE regnr = :regnr AND aktiv = 1 AND id = :id";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $regnr);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return $r;
    }
    
    /*
     * Adds a user to the site
     */
    public function add_user($user, $pass, $admin) {        
        $sql = "INSERT INTO users (username, password, admin) VALUES (:user,:pass,:admin)";

        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":user", $user);
            $stmt->bindParam(":pass", $pass);
            $stmt->bindParam(":admin", $admin);
            $stmt->execute();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * Gets a list of every users on the site
     */
    public function get_users() {
        $sql = "SELECT * FROM users";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return $r;
    }
    
    /*
     * Check if a user exists
     */
    public function check_user($id) {
        $sql = "SELECT COUNT(user_id) AS id FROM users WHERE user_id = :id";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $r = $stmt->fetch();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        return ($r['id'] == 1) ? true : false;
    }
    
    /*
     * removes a user from the database
     */
    public function remove_user($id) {
        $sql = "DELETE FROM users WHERE user_id = :id";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * Sets a buss as inactive and sets all corresponding faults as finsihed
     */
    public function remove_buss($regnr) {
        $sql = "UPDATE bussar SET aktiv = 0 WHERE regnr = :regnr";
        $sql2 = "UPDATE fel SET aktiv = 0, klar_besk = 'Bussen borttagen', klar_datum = NOW() WHERE regnr = :regnr";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":regnr", $regnr);
            $stmt->execute();
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bindParam(":regnr", $regnr);
            $stmt2->execute();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * returns faults within a specified date intervall
     */
    public function get_history($regnr, $date1, $date2) {
        $sql = "SELECT * FROM fel WHERE regnr = :all AND aktiv = 0";
        $sql1 = "SELECT * FROM fel WHERE regnr = :regnr AND aktiv = 0 AND klar_datum BETWEEN :date1 AND :date2";
        
        if($date1 == '' && $date2 == '')
        {
            try
            {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":all", $regnr);
                $stmt->execute();
                $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
            return $r;
        }
        else
        {
            try
            {
                $stmt = $this->db->prepare($sql1);
                $stmt->bindParam(":regnr", $regnr);
                $stmt->bindParam(":date1", $date1);
                $stmt->bindParam(":date2", $date2);
                $stmt->execute();
                $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
            return $r;
        }
    }
    
    /*
     * Changes password for users
     */
    public function change_password($password, $id) {
        $sql = "UPDATE users SET password = :pass WHERE user_id = :id";
        
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":pass", $password);
            $stmt->bindParam(":id", $id);
            $stmt->execute();       
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    /*
     * Deletes history from the database
     * 
     * Allows for an int to be passed if you want to check or
     * delete.
     * 
     * 1 = Check how many rows will be deleted
     * 2 = Deletes the rows
     */
    public function delete_history($data, $datum) {
        if($data == 1) {
            $sql = "SELECT COUNT(id) FROM fel WHERE klar_datum <= :datum && aktiv = 0";
            
            try {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":datum", $datum);
                $stmt->execute();
                $r = $stmt->fetch();
                
                return $r;
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
        }
        
        if($data == 2) {
            $sql = "DELETE FROM fel WHERE klar_datum <= :datum && aktiv = 0";
            
            try {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":datum", $datum);
                $stmt->execute();
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
        }
    }
}
?>