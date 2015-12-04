<?php
$db = new Database();
$allProducts = new Product($db);
$product = new Product($db);

//Voegt product toe 
if (isset($_POST['newName'])) {
	filter_input(INPUT_POST, 'newSecondhand', FILTER_VALIDATE_INT);
	filter_input(INPUT_POST, 'newPrice', FILTER_VALIDATE_INT);
	filter_input(INPUT_POST, 'newSupplier', FILTER_VALIDATE_INT); 
	$newProduct = new Product($db);     
	$newProduct->setName($_POST['newName']);
	$newProduct->setCode($_POST['newCode']);
	$newProduct->setSecondhand($_POST['newSecondhand']);
	$newProduct->setDescription($_POST['newDescription']);
	$newProduct->setSupplierId($_POST['newSupplier']);
	$newProduct->setPrice($_POST['newPrice']);     
	header('location: index.php?cmspage&module=product' . $newProduct->newProduct()); 
}

//Product toevoegen input
if (isset($_GET['n'])) { ?>
	<form action="index.php?cmspage&module=product" method="post">
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


<?php
} elseif (isset($_GET['e'])) {
	$pro = $allProducts->getAll(array(array('id', '=', $_GET['e'])));
	$pro = $pro[0]; ?>
		<form action="index.php?cmspage&module=product" method="post">
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

<?php } else {
	foreach ($allProducts->getAll() as $pro) {
		echo '<a href="index.php?cmspage&module=product&e=' . $pro->getId() . '">';
			echo $pro->getName();
		echo "</a><br>";
	}
	echo '<br><a href="index.php?cmspage&module=product&n">Product toevoegen</a>';
}

