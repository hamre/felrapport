<?php 
include("../sys/core/init.inc.php");
include("inc/overall/header_overall.php"); 
$l = new user;
$l->protect_page();
?>
	<h1>Felanmälan</h1>
<?php
	$regnr = $_GET['regnr'];

	if(empty($regnr) || $l->buss_exist($regnr) === false) {
		print('Den bussen finns inte i våran databas');
	} else {

	if(empty($_POST) === false) {
	  if(empty($errors) === true) {
	    if(empty($_POST['desc']) === true) {
	      $errors[] = 'Beskrivningen får inte vara tom';
	    } 
             if(empty($_POST['submitter']) === true) {
                 $errors[] = 'Du måste ange vem du är.';
             }
	  }
	}
	if(isset($_GET['success']) === true && empty($_GET['success']) === true) {
	  print('Din felrapport har blivit inlagd');
	} else {
	    if(empty($_POST) === false && empty($errors) === true) {
	      $register_data = array(
	        'allvar' => $_POST['allvarlighet'],
	        'desc'   => $_POST['desc'],
	        'vem'    => $_POST['submitter'],
	        'regnr'  => $regnr);
	 
	        $l->add_fel($register_data);
	        header("Location: fel.php?regnr=".$regnr."&success");
	        exit();
	    } else if(empty($errors) === false) {
	        print($l->output_errors($errors));
	      }
?>
<form action="" method="post">
	<fieldset>
		<legend>Felanmälan <?php print($regnr); ?></legend>
			Allvarlighetsgrad <br />
			<select name="allvarlighet">
				<option value="0">Låg (Kan vänta)</option>
				<option value="1" selected>Normal</option>
				<option value="2">Kritisk (Bör ej gå i trafik)</option>
			</select>
			<br />
			Beskriv felet så utförligt som möjligt <br />
			<textarea rows="10" cols="50" name="desc"></textarea><br />
			Vem är du?<br />
			<input type="text" name="submitter"> <br />
			<input type="submit" value="Lägg till">
	</fieldset>
</form>
<p><h2>Ej lagade fel för fordon <?php print($regnr); ?></h2></p>
<?php $fel = $l->get_fel($regnr); ?>
        <h3>Beskrivning</h3>        
<?php
if(empty($fel)) {
    print('Inga aktiva fel funna');
} else{
?>
<table colspan="2">
		<?php
      $i = 1;      
      foreach ($fel AS $f) {
        print('<tr><td>'.$i.': '.$f['beskrivning'].'</td></tr>');
        $i++;
      }    
}
    ?>
</table><br />
<p><h2>Lagade fel den senaste månaden för fordon <?php print($regnr); ?></h2></p>
<?php
$klara_fel = $l->get_klara_fel($regnr);
?>
        <h3>Beskrivning</h3>
        <table colspan="2">
            <?php
            $s = 1;
            if(empty($klara_fel)) {
                print('Inga lagade fel under den senaste månaden funna');
            } else {
            foreach($klara_fel AS $k) {
                print('<tr><td>'.$s.': '.$k['beskrivning'].'</td></tr>');
                $s++;
            }
            }
            ?>
        </table>
<?php
}
}
 include("inc/overall/footer_overall.php"); 
?>