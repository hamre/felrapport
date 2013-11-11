<?php
include("../sys/core/init.inc.php");
$ser = new user;
$ser->protect_page();
$ser->admin_protect();
include("inc/overall/header_overall.php");

$bussar = $ser->return_busses(1);
?>
<form action="#" method="post">
    Sök historik för: <select name="regnr">
			<?php foreach($bussar AS $buss) print('<option name="'.$buss['regnr'].'">'.$buss['regnr'].'</option>'); ?>
	</select><br /><br />
    Mellan datum: (Om datum ej anges visas all felhistorik för fordonet)<br />
    Från datum: <input type="text" id="datepicker" name="date1"><div id="datepicker"></div> Till datum: &nbsp;&nbsp;<input type="text" id="datepicker2" name="date2"><div id="datepicker2"></div><br />
    <input type="submit" name="submit" value="Sök">
</form>
<br />

<?php
    if(isset($_POST['submit'])) {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $regnr = $_POST['regnr'];
        
        $history = $ser->get_history($regnr, $date1, $date2);
		
		if(empty($history)) {
			$errors[] = 'Inga lagade fel för detta fordon';
		}
		if(empty($errors) === true) {
?>
<table colspan="2">
    <tr>
        <th>Datum fixad</th>
        <th>Felorsak</th>
		<th>Läs mera</th>
    </tr>
<?php    
        foreach($history AS $hist) {
            print('<tr><td>'. $hist['klar_datum'].'</td><td>'.substr($hist['beskrivning'],0,50).'</td><td align="center"><a href="search_read.php?id='.$hist['id'].'">Läs</a></td>');
        }
?>
</table>
<?php
 } else if(empty($errors) === false) {
	print($ser->output_errors($errors));
   }
}	
?>

<?php include("inc/overall/footer_overall.php"); ?>