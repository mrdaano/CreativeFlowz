<?php
	$user = new Users();
	
	if ($user->isMedewerker($_GET['id'])) {
		$user->deleteMedewerker($_GET['id']);
		echo "<p>Medewerker is verwijderd.</p>";
	} else {
		echo "<p>Medewerker kan niet worden verwijderd.</p>";
	}
?>
<a href="index.php?page=cms&module=users">Ga terug</a>