<?php 
include("../sys/core/init.inc.php");
$res = new user;
$res->protect_page();
$res->admin_protect();
include("inc/overall/header_overall.php"); 

$id = $_GET['id'];
$fel = $res->get_klara_fel_by_id($id);
if(!is_numeric($id)) {
	$errors[] = 'ID är ej ett nummer';
}

if(empty($fel)) {
	$errors[] = 'Kunde ej hitta något fel för detta id';
}
if(empty($errors) === true) {
?>
<table colspan="2" cellspacing="5">
	<tr>
		<th>Fordon</th>
		<td><?php print($fel['regnr']); ?></td>
	</tr>
	
	<tr>
		<th>Felet inlagt</th>
		<td><?php print($fel['datum']); ?></td>
	
	<tr>
		<th valign="top">Felbeskrivning</th>
		<td><?php print($fel['beskrivning']); ?></td>
	</tr>
	
	<tr>
		<th>Felet lagat</th>
		<td><?php print($fel['klar_datum']); ?></td>
	</tr>
	
	<tr>
		<th valign="top">Klarbeskrivning</th>
		<td><?php print($fel['klar_besk']); ?></td>
	</tr>
	
	<tr>
		<th>Lagat av</th>
		<td><?php print($fel['klar_namn']); ?></td>
	</tr>
	
	<tr>
		<th>Mätarställning</th>
		<td><?php print($fel['klar_matar']); ?></td>
	</tr>
</table>
<br />
<br />
<a href="search_fel.php">Tillbaka</a><br />
<?php 
}else if(empty($errors) === false) {
	print($res->output_errors($errors));
}
include("inc/overall/footer_overall.php"); 
?>