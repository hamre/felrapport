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

class DB_Connect {
    /**
     * Stores a database object
     * 
     * @var object A database object
     */
    public $db;
    
    /**
     * Checks for DB object or creates one if isn't found
     * 
     * @param object $dbo A database object
     */
    public function __construct($dbo=NULL) {
        if(is_object($db)) {
            $this->db = $db;
        }
        else {
            //Constants are defined in /sys/config/db-cred.inc.php
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            try {             
                $this->db = new PDO($dsn, DB_USER, DB_PASS);
                $c = $this->db->prepare("SET NAMES 'utf8'");
                $c->execute();
        } catch (Exception $e) {
            //If the DB connection fails, output the error
            die($e->getMessage());
        }
        }
    }
}
?>