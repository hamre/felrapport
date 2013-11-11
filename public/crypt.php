<?php 
include("../sys/core/init.inc.php");
$ad = new user;
$ad->admin_protect();
include("inc/overall/header_overall.php"); 
?>
<h1>Crypt passwords</h1>
<br />
Denna sida är endast till för om lägg till användare inte kan hasha lösenordet ordentligt.<br />
Bör ej behöva användas.
<form action="" method="post">
	<input type="password" name="pass"><br />
	<input type="submit" name="submit" value="crypt">
</form>

<?php 
if(isset($_POST['submit'])){
	$pass = $_POST['pass'];
        $crypt = new user;

	print('Ditt hashade lösenord är: '.$crypt->crypt_password($pass));
}
include("inc/overall/footer_overall.php");
?>