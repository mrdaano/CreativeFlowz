<?php
$db = new Database();
$allProducts = new Product($db);
$product = new Product($db);
$location = 'index.php?page=cms&module=product';




//Voegt product toe 
if (isset($_POST['newName'])) {
	filter_input(INPUT_POST, 'newSecondhand', FILTER_VALIDATE_INT);
	filter_input(INPUT_POST, 'newPrice', FILTER_VALIDATE_INT);
	filter_input(INPUT_POST, 'newSupplier', FILTER_VALIDATE_INT);
	$newProduct = new Product($db);   
	if (condition) {
	  	# code...
	  }  
	$newProduct->setName($_POST['newName']);
	$newProduct->setCode($_POST['newCode']);
	$newProduct->setSecondhand($_POST['newSecondhand']);
	$newProduct->setDescription($_POST['newDescription']);
	$newProduct->setSupplierId($_POST['newSupplier']);
	$newProduct->setPrice($_POST['newPrice']);     
	$newProduct->newProduct();
	header('location:' . $location);
}

if (isset($_POST['updateName'])) {
	$updateProduct = new Product($db);
	$updateProduct->setId($_GET['id']);     
	$updateProduct->setName($_POST['updateName']);
	$updateProduct->setCode($_POST['updateCode']);
	$updateProduct->setSecondhand($_POST['updateSecondhand']);
	$updateProduct->setDescription($_POST['updateDescription']);
	$updateProduct->setSupplierId($_POST['updateSupplier']);
	$updateProduct->setPrice($_POST['updatePrice']);     
	header('location:' . $location . $updateProduct->updateProduct());
}

//Product toevoegen input
if (isset($_GET['n'])) { ?>
	<form action="<?php echo $location; ?>" method="post">
		Naam: <input type="text" name="newName"><br>
		Code: <input type="text" name="newCode"><br>
		Tweede hands: <select name="newSecondhand">
			<option value="0">Nee</option>
			<option value="1">Ja</option>
		</select><br>
		Beschrijving: <textarea name="newDescription"></textarea><br>
		Leverancier: <select name="newSupplier">
			<option value="1">Test</option>
		</select><br>
		Prijs: <input type="text" name="newPrice"><br>
		<input type="submit">
	</form>


<?php //Product bewerken
} elseif (isset($_GET['e'])) {
	$pro = $allProducts->getAll(array(array('id', '=', $_GET['e'])));
	$pro = $pro[0]; ?>
		<form action="<?php echo $location . '&id=' . $pro->getId(); ?>" method="post">
		Naam: <input type="text" name="updateName" value="<?php echo $pro->getName() ?>"><br>
		Code: <input type="text" name="updateCode" value="<?php echo $pro->getCode() ?>"><br>
		Tweede hands: <select name="updateSecondhand">
			<?php if ($pro->getSecondhand() == 0) { ?>
				<option value="0">Nee</option>
				<option value="1">Ja</option>
			<?php } else { ?>
				<option value="1">Ja</option>
				<option value="0">Nee</option>
			<?php } ?>
		</select><br>
		Beschrijving: <textarea name="updateDescription"><?php echo $pro->getDescription() ?></textarea><br>
		Leverancier: <select name="updateSupplier">
			<option value="<?php echo $pro->getSupplierId(); ?>"><?php echo $pro->getSupplierName(); ?></option>
			<?php foreach ($allProducts->getAllSupplier(array(array('id', '!=', $pro->getSupplierId()))) as $suppl) { ?>
				<option value="<?php echo $suppl[0]; ?>"><?php echo $suppl[1]; ?></option>
			<?php } ?>
		</select><br>
		Prijs: <input type="text" name="updatePrice" value="<?php echo $pro->getPrice() ?>"><br>
		<input type="submit">
	</form>

<?php } else { //Producten weergeven
	foreach ($allProducts->getAll() as $pro) {
		echo '<a href="' . $location . '&e=' . $pro->getId() . '">';
			echo $pro->getName();
		echo "</a><br>";
	}
	echo '<br><a href="' . $location . '&n">Product toevoegen</a>';
}

