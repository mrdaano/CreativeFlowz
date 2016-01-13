<?php
$users = new Users();

if ($users->isMedewerker($_GET['id'])) {
	echo "<script> window.location = 'index.php?page=cms&module=users';</script>";
}

$user = $users->getKlant($_GET['id']);
?>
<h3><b>Algemene info</b></h3>
<p><b>Voornaam:</b> <?php echo $user->firstname; ?></p>
<p><b>Achternaam:</b> <?php echo $user->lastname; ?></p>
<p><b>E-mail:</b> <a href="<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
<p><b>Adres:</b> <?php echo $user->street; ?> <?php echo $user->housenumber; ?><?php echo $user->addition; ?></p>
<p><b>Postcode:</b> <?php echo $user->zip; ?> <?php echo $user->cityname; ?></p>
<p><b>Land:</b> <?php echo $user->country; ?></p>

<?php

if ($user->company_name) { ?>
<br>
<h3><b>Bedrijfs info</b></h3>
<p><b>Naam:</b> <?php echo $user->company_name; ?></p>
<p><b>BTW nummer:</b> <?php echo $user->company_taxnumber; ?></p>
<?php } ?>