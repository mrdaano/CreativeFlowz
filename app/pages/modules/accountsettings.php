<div class="neworders page">
	<?php 
	$showForm = false;
	$url = '?page=customer&module=accountsettings';

	if (isset($_GET['edit'])) {
		$showForm = true;
	} elseif (isset($_POST['firstname'])) {
		$Updateuser = new User($User->db);
		$Updateuser->update($_POST, $User);
		if ($Updateuser->error()) {
			$showForm = true;
			$User = $Updateuser;
		}
	}

	if ($showForm) { ?>
		<h1>Bewerk uw gegevens:</h1>
		<?php 
		if ($User->error()) { ?>
			<h2><?= $User->error() ?></h2>
		<?php } else { ?>
			<h2><br></h2>
		<?php } ?>
		<form method="post" action="<?= $url ?>">
			Voornaam <br><input type="text" name="firstname" value="<?= $User->firstname() ?>"><br>
			Achternaam <br><input type="text" name="lastname" value="<?= $User->lastname() ?>"><br>
			Email <br><input type="text" name="email" value="<?= $User->email() ?>"><br><br>
			Postcode <br><input type="text" name="zip" value="<?= $User->zip() ?>"><br>
			Straat <br><input type="text" name="street" value="<?= $User->street() ?>"><br>
			Huisnummer <br><input type="text" name="housenumber" value="<?= $User->housenumber() ?>"><br>
			Toevoeging <br><input type="text" name="addition" value="<?= $User->addition() ?>"><br>
			Plaats <br><input type="text" name="city" value="<?= $User->city() ?>"><br>
			Land <br><input type="text" name="country" value="Nog niet"><br>
			Telefoonnummer <br><input type="text" name="phone_number" value="<?= $User->phone_number() ?>"><br><br>
			Bedrijfsnaam <br><input type="text" name="company_name" value="<?= $User->company_name() ?>"><br>
			BTW-nummer <br><input type="text" name="tax" value="<?= $User->tax() ?>"><br>
			<button>Opslaan</button>
			<a href="<?= $url ?>"><button type="button">Terug</button></a>
		</form>
	<?php } else { ?>
		<a href="<?= $url ?>&edit" class="btn">Bewerk uw gegevens</a>
		<h1>Uw gegevens:</h1><br>
		<?= $User->firstname() ?>
		<?= $User->lastname() ?><br>
		<?= $User->email() ?><br>
		<?= $User->phone_number() ?><br><br>
		<h2>Uw adres:</h2>
		<?= $User->street() ?> 
		<?= $User->housenumber() ?> 
		<?= $User->addition() ?><br>
		<?= $User->zip() ?><br> 
		<?= $User->city() ?><br>
		<?php
		if ($User->company()) { ?>
			<br><b>Bedrijfnaam: </b><?= $User->company_name() ?><br>
			<b>BTW-nummer: </b> <?= $User->tax() ?><br>
		<?php } 
	} ?>
</div>