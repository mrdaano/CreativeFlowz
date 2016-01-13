<?php
$users = new Users();

if (!$users->isMedewerker($_GET['id'])) {
	$users->setActive($_GET['id']);
	echo "<p>Status is gewijzigd.</p>";
} else {
	echo "<p>Er is iets mis gegaan.</p>";
}
?>
<a href="index.php?page=cms&module=users">Ga terug</a>