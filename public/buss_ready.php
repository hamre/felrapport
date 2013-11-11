<?php 
include("../sys/core/init.inc.php");
$o = new user;
$o->protect_page();
$o->admin_protect();
include("inc/overall/header_overall.php");
$felet = $o->get_fel_by_id($_POST['regnr'], $_POST['id']);

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['namn'];
    $besk = $_POST['description'];
    $matar = $_POST['matar'];
    
    if(empty($name) || empty($besk)) {
      print('Alla fält måste fyllas i');
    } else {
        $update = $o->db->prepare('UPDATE fel SET klar_namn = :namn, klar_besk = :besk, klar_datum = NOW(), klar_matar = :matar, aktiv = 0 WHERE id = :id');
        $update->execute(array("namn" => $name, "besk" => $besk, "id" => $id, "matar" => $matar));
        header("Location: aktiva_fel.php");
        //print($id.' '.$name.' '.$besk);
    }
}
?>


<form action="" method="post">
	<fieldset>
		<legend>Klarmarkera</legend>
			Vem fixade fordonet:<br /><input type="text" name="namn"><br />
			Vad fixades på fordonet:<br /><textarea cols="30" rows="10" name="description"></textarea><br />
                        Mätarställning:<br /><input type="text" name="matar"><br />
			<input type="hidden" name="id" value="<?php print($_POST['id']); ?>">
			<input type="submit" name="submit" value="Klar"> - <a href="aktiva_fel.php">Avbryt</a>
	
	</fieldset>
</form>
<br />
<strong>Detta var felet:</strong><br />
<?php foreach($felet AS $fel){ print($fel['beskrivning']);} ?>

<?php
include("inc/overall/footer_overall.php"); 
?>