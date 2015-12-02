<?php
include_once 'app/classes/Product.php';
include_once 'app/classes/Database.php';


//Product toevoegen
if (isset($_GET['n'])) { ?>
	<form action="" method="post">
		Naam: <input type="text" name="name"><br>
		Code: <input type="text" name="code"><br>
		Tweede hands: <select name="secondhand">
			<option value="0">Nee</option>
			<option value="1">Ja</option>
		</select><br>
		Beschrijving: <textarea name="description"></textarea><br>
		Leverancier: <select name="supplier">
			PHPPPPPP
		</select><br>
		Prijs: <input type="text" name="price"><br>
		PHPPPPP
		<input type="submit">
	</form>
<?php
}




?>
