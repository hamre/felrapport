<?php 
include("../sys/core/init.inc.php");
$r = new user;
$r->protect_page();
$r->admin_protect();
include("inc/overall/header_overall.php"); 
?>
<h1>Ta bort felhistorik!</h1>
<br />
På denna sida kan du ta bort historik för att hålla databasen ren.<br />
Du bör ej ta bort historik som är mindre än 1 år gammal.<br />
<br />
<form action="" method="post">
    Datum<br /><input type="text" id="datepicker" name="datum"><div id="datepicker"></div><br />
    <input type="submit" name="submit" value="Ta bort">
</form>
<?php
if(isset($_POST['submit'])) {
    $datum = $_POST['datum'];
    
    if(empty($datum)) {
        print('<br />Du måste ange ett datum');
    }
    
    if(!empty($datum)) {
        $result = $r->delete_history(1, $datum);        
        print('<br />Du kommer ta bort '.$result[0].' rader före '.$datum);
        print('<br /><br /><a href="?sure=yes&datum='.$datum.'">Är du säker tryck då här!</a>');
    }
}

if(isset($_GET['sure'])) {
    $datum = $_GET['datum'];
    
    if(!empty($datum)) {
        $r->delete_history(2, $datum);
        print('<br /><br />Raderna togs bort');
    }
}
include("inc/overall/footer_overall.php"); 
?>