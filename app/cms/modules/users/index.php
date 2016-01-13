<?php
$users = new Users();

if (isset($_GET['success'])) {
	echo "<p>Account aangemaakt.</p>";
}

?>
<a href="index.php?page=cms&module=users&action=medewerkerToevoegen" class="btn">Medewerker toevoegen</a>
<table class="cms page media_table">
	<thead>
		<tr>
			<th>Naam</th>
			<th>Rol</th>
			<th>Acties</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($users->getUsers() as $key => $user) { ?>
			<tr>
				<td><?php echo $user->firstname;?> <?php echo $user->lastname;?></td>
				<td><?php echo ($users->isMedewerker($user->id)) ? 'Medewerker' : 'Klant' ?></td>
				<td>
					<?php
						if ($users->isMedewerker($user->id)) { ?>
					<a href="index.php?page=cms&module=users&action=deleteMedewerker&id=<?php echo $user->id; ?>" class="btn">Delete</a>
					<?php } else {?>
					<a href="index.php?page=cms&module=users&action=bekijk&id=<?php echo $user->id; ?>" class="btn">Bekijk gegevens</a>
					<?php } ?>
				</td>
			</tr>	
		<?php	}
		?>
	</tbody>
</table>