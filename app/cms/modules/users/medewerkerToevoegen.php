<p>Voeg nieuwe medewerker toe.</p>
<br>
<?php
	$users = new Users();
	if (isset($_POST['vnaam'])) {
		if ($users->medewerkerToevoegen()) {
			echo "<script> window.location = 'index.php?page=cms&module=users&success';</script>";
		}
	}
	
	foreach($users->getErrors() as $error) {
		echo "<p>{$error}</p>";
	}	
?>
<form action="index.php?page=cms&module=users&action=medewerkerToevoegen" method="post" accept-charset="utf-8">
	<ul>
		<li>Voornaam</li>
		<li><input id="" type="text" name="vnaam" value="<?php echo $users->oldInput('vnaam'); ?>" class="login"></li>
		<Li>Achternaam</Li>
		<li><input id="" type="text" name="naam" value="<?php echo $users->oldInput('naam'); ?>" class="login"></li>
		<li>E-mail</li>
		<li><input id="" type="email" name="email" value="<?php echo $users->oldInput('email'); ?>" class="login"></li>
		<li>Wachtwoord</li>
		<li><input id="" type="password" name="password" value="" class="login"></li>
		<li>Wachtwoord opnieuw</li>
		<li><input id="" type="password" name="password_again" value="" class="login"></li>
	</ul>
	<input type="submit" class="btn" value="Opslaan">
</form>