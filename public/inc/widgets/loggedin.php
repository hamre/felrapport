<div class="widget">
		<h2>Hallå, <?php print($user_data['username']); ?></h2>
			<div class="inner">            
        <ul>
<?php
$check = new user;
  if($check->is_admin($user_data['user_id']) == 1) {		
?>
          <li><a href="aktiva_fel.php">Aktiva felrapporter</a></li>
          <li><a href="search_fel.php">Sök fel historik</a></li>
          <li><a href="delete_history.php">Ta bort historik</a></li>
          <li><a href="add.php">Lägg till buss/bil</a></li>
          <li><a href="remove.php">Ta bort buss/bil</a></li>
          <li><a href="add_user.php">Lägg till användare</a></li>
          <li><a href="crypt.php">Hasha lösenord</a></li>
<?php
	}
?>
          <li><a href="logout.php">Logga ut</a></li>
        </ul>
			</div>
</div>