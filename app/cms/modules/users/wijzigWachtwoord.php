<?php
$users = new Users();

if (isset($_POST['id'])) {
	if ($users->updateMedewerker()) {
		echo "<script> window.location = 'index.php?page=cms&module=users';</script>";
	}
}

if ($users->isMedewerker($_GET['id'])) {
	foreach($users->getErrors() as $error) {
		echo "<p>{$error}</p>";
	}
?>
<h3>Wijzig wachtwoord</h3>
<form action="index.php?page=cms&module=users&action=wijzigWachtwoord&id=<?php echo $_GET['id']; ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
	<ul>
		<li>Nieuw wachtwoord</li>
		<li><input type="password" name="password" class="login"></li>
		<li>Nieuw wachtwoord opnieuw</li>
		<li><input type="password" name="password_again" class="login"></li>
		<li><input type="submit" value="Update"></li>
	</ul>
</form>
	
<?php } ?>