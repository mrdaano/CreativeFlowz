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
			<th>Klant?</th>
			<th>Acties</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($users->getUsers() as $key => $user) { ?>
			<tr>
				<td><?php echo $user->firstname;?> <?php echo $user->lastname;?></td>
				<td></td>
				<td><a href="#" class="btn">Bewerken</a></td>
			</tr>	
		<?php	}
		?>
	</tbody>
</table>