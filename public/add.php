<?php 
include("../sys/core/init.inc.php");
$buss = new user;
$buss->admin_protect();
$buss->protect_page();
include("inc/overall/header_overall.php"); 
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#regnr").keyup(function() {
		var name = $('#regnr').val();
		if(name=="")
		{
			$("#disp").html("");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "reg_check.php",
				data: "regnr="+ name ,
				success: function(html){		
					$("#disp").html(html);
				}
		});
		return false;
		}
	});
	});
</script>
<?php
	if(empty($_POST) === false) {
	  if(empty($errors) === true) {
	    if(empty($_POST['regnr']) === true && empty($_POST['marke']) === true && empty($_POST['ar']) === true) {
	      $errors[] = 'Inget fält får vara tomt';
	    }
	    if($buss->buss_exist($_POST['regnr']) === true) {
	    	$errors[] = 'Fordonet finns redan i databasen';
	    }
	  }
	}
	if(isset($_GET['success']) === true && empty($_GET['success']) === true) {
	  print('Det nya fordonet har blivit inlagt');
	} else {
	    if(empty($_POST) === false && empty($errors) === true) {
	      $regnr = strtoupper($_POST['regnr']);
	      $register_data = array(
	        'marke' => $_POST['marke'],
	        'ar' 	=> $_POST['ar'],
	        'typ'	=> $_POST['typ'],
	        'regnr' => $regnr);
	 
	        $buss->add_buss($register_data);
	        header("Location: add.php?success");
	        exit();
	    } else if(empty($errors) === false) {
	        print($buss->output_errors($errors));
	      }
?>
<form action="" method="post">
	<fieldset>
		<legend>Lägg till ny buss</legend>
			Regnr <br /> <input type="text" name="regnr" id="regnr"><div id="disp"></div><br />
			Märke <br /> <input type="text" name="marke"><br />
			Typ <br /> <select name="typ">
							<option value="buss">Buss</option>
							<option value="bil">Bil</option>
                                                        <option value="övrigt">Övrigt</option>
						</select> <br />
			Årsmodell <br /> <input type="text" name="ar"><br />
			<input type="submit" value="Lägg till">
	</fieldset>
</form>
<?php
}
 include("inc/overall/footer_overall.php"); 
?>