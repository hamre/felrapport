<?php 
include("../sys/core/init.inc.php");
$pass = new user;
$pass->protect_page();
$pass->admin_protect();
include("inc/overall/header_overall.php");

$id = $_GET['id'];
$user = $pass->user_data($id, 'username');

if($pass->check_user($id) === false) 
{
    $errors[] = 'Användaren finns inte i våran databas';
}

if(empty($errors) === true)
{
?>
<h1>Här kan du byta lösenord för en användare</h1><br />
Du kommer byta lösenord för användare: <strong><?php print($user['username']); ?></strong><br />
<br />
<form action ="#" method="post">
    Lösenord<br /><input type="password" name="pass1"><br />
    Lösenord igen<br /><input type="password" name="pass2"><br />
    <input type="submit" name="submit" value="Byt lösenord">
</form>    
<?php
}
else
{
    print($pass->output_errors($errors));
}

if(isset($_POST['submit']))
{
    
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if(empty($pass1) || empty($pass2))
    {
        $errors[] = 'Du måste fylla i alla fält';
    }
    
    if($pass1 != $pass2)
    {
        $errors[] = 'Lösenorden matchar inte varandra';
    }
    
    if(empty($errors) === true)
    {
        $pass3 = $pass->crypt_password($pass1);
        $pass->change_password($pass3, $id);
        print('Lösenordet har ändrats');
    }
    else
    {
        print($pass->output_errors($errors));
    }
}
include("inc/overall/footer_overall.php"); ?>