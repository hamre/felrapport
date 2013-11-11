<?php 
include("../sys/core/init.inc.php");
$rem = new user;
$rem->admin_protect();
$rem->protect_page();
include("inc/overall/header_overall.php");

if(isset($_GET['success']) === true) {
	print('Fordonet togs bort med lyckat resultat och relaterade felrapporter markerades som klara.');
}

if($_GET['sure'] == 'ja') {
	$buss = $_GET['removes'];

	if($rem->buss_exist($buss) === false) {
		$errors[] = 'Denna buss finns inte';
	}

	if(empty($errors) === false) {
		print($rem->output_errors($errors));
	} else {
		$rem->remove_buss($buss);
		header("Location: remove.php?success");
		exit();
	}
}

	$bussar = $rem->return_busses(1);

	print('<table colspan="2" cellspacing="2"><tr><th>Regnr</th></tr>');
		foreach($bussar AS $buss) {
			print('<tr><td>'.$buss['regnr'].'</td>');
			switch(isset($_GET)) {
				case $_GET['removes'] == $buss['regnr']:
					print('<td><a href="remove.php?removes='.$buss['regnr'].'&sure=ja">Är du säker?</a></td></tr>');
					break;
				default:
					print('<td><a href="remove.php?removes='.$buss['regnr'].'">Ta bort</a></td></tr>');
					break;
			}
		}
	print('</table>');
?>    
   
<?php include("inc/overall/footer_overall.php"); ?>