<?php 
include("../sys/core/init.inc.php");
$add = new user;
$add->protect_page();
$add->admin_protect();
include("inc/overall/header_overall.php"); 

if(isset($_POST['submit'])) {
    $user = $_POST['user'];
    $pass = $add->crypt_password($_POST['pass']);
    $admin = $_POST['admin'];
    
    if(empty($user)) {
        $errors[] = 'Du måste ange ett användarnamn';
    }
    
    if(empty($pass)) {
        $errors[] = 'Du måste ange ett lösenord';
    }
    
    if(empty($errors) === true) {
        $add->add_user($user, $pass, $admin);
    } else {
        print($add->output_errors($errors));
    }
}
?>
<p>På denna sida kan du lägga till eller ta bort användare!</p>
<br />
<form action="#" method="post">
    Användarnamn:<br /> <input type="text" name="user"><br />
    Lösenord:<br /> <input type="password" name="pass"><br />
    Admin:<br /> <select name="admin"><option value="0">Nej</option><option value="1">Ja</option></select><br /><br />
    <input type="submit" name="submit" value="Lägg till">&nbsp;<input type="reset" value="Ångra">
</form>
<br /><br />
<p><strong>Dessa användare finns redan</strong></p>
<br />
<?php //foreach($add->get_users() AS $users) { print($users['username'].' - <a href="?remove='.$users['user_id'].'">Ta bort användare</a><br />'); } 
foreach($add->get_users() AS $users) {
    print($users['username']. ' - <a href="change_password.php?id='.$users['user_id'].'">Byt lösenord</a> - ');
    $users['admin'] == 1 ? print(' - Denna användare går ej att ta bort här<br />') : print(' - <a href="?remove='.$users['user_id'].'">Ta bort användare</a><br />');
}

if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    
    if($add->check_user($id) === false) {
        $errors[] = 'Denna användare finns inte i våran databas';
    }
    
    if(!is_numeric($id)) {
        $error[] = 'Du angav inte ett numeriskt värde';
    }
    
    if(empty($errors) === true) {
        print('<br /><a href="?remove='.$id.'&sure=yes">Är du säker? Tryck då här!</a>');
        if($_GET['sure'] == 'yes') {            
            $add->remove_user($_GET['remove']);
            header("Location: add_user.php");
            exit();
        }       
    }
    else {
        print($add->output_errors($errors));
    }
}
?>
<?php include("inc/overall/footer_overall.php"); ?>