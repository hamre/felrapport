<?php 
include("../sys/core/init.inc.php");
include("inc/overall/header_overall.php"); 
?>
<h1>Bussar som kan felanmälas!</h1>
<br />
<?php
$buss = new user;

$bussar = $buss->return_busses(1);
if(!$buss->logged_in()) {
    print('Du måste logga in för att kunna felanmäla ett fordon');
}
else {
   print('<table><tr><th>Regnr</th><th>Typ</th></tr>');
	foreach($bussar AS $res) {
            print('<tr><td><a href="fel.php?regnr='.$res['regnr'].'">'.$res[regnr].'</a></td><td>'.$res['typ'].'</td></tr>');			
	}
	print('</table>');
}
?>
<?php include("inc/overall/footer_overall.php"); ?>