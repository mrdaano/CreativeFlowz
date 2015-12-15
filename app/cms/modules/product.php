<?php
$db = new Database();
$allProducts = new Product($db);
$product = new Product($db);
$location = 'index.php?page=cms&module=product';

//Product verwijderen
if ((isset($_GET['r']))) {
	$removeProduct = new Product($db);
	$removeProduct->setId($_GET['r']);
	$removeProduct->removeProduct();
	header('location: ' . $location);
}

//Voeg product toe 
elseif (isset($_POST['newName'])) {
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
	$newProduct->controle();  
	if ($newProduct->getError()) {
		echo $newProduct->getError(); ?>
		<form action="<?php echo $location; ?>" method="post">
			Naam: <input type="text" name="newName" value="<?php echo $newProduct->getName(); ?>"><br>
			Code: <input type="text" name="newCode" value="<?php echo $newProduct->getCode(); ?>"><br>
			Tweede hands: <select name="newSecondhand">
				<?php if($newProduct->getSecondhand() == 0) { ?>
					<option value="0">Nee</option>
					<option value="1">Ja</option>
				<?php } else { ?>
					<option value="1">Ja</option>
					<option value="0">Nee</option>
				<?php } ?>
			</select><br>
			Beschrijving: <textarea name="newDescription"><?php echo $newProduct->getDescription(); ?></textarea><br>
			Leverancier: <select name="newSupplier">
			<option value="<?php echo $newProduct->getSupplierId(); ?>"><?php echo $newProduct->getSupplierName(); ?></option>
			<?php foreach ($newProduct->getAllSupplier(array(array('id', '!=', $newProduct->getSupplierId()))) as $suppl) { ?>
				<option value="<?php echo $suppl[0]; ?>"><?php echo $suppl[1]; ?></option>
			<?php } ?>
		</select><br>
			Prijs: <input type="text" name="newPrice" value="<?php echo $newProduct->getPrice(); ?>"><br>
			<?php	
			$Category = new Category($db);
			foreach ($Category->getAll() as $category) {
				echo '<input type="checkbox" name="product_category[]" value="' . $category->getId() . '"';
				if (array_search($category->getId(), $_POST['product_category']) > -1) {
					echo "checked";
				}
				echo '>' . $category->getName() . "<br>";
			}
			?>
			<input type="submit">
			<a href="<?php echo $location; ?>">Terug</a>
		</form>
	<?php } else {
		$newProduct->newProduct();	
		$newProduct->setIdFromDatabase();
		$newProduct->linkCategory($_POST['product_category']);
		header('location: '. $location);
	}
}

//Update product 
elseif (isset($_POST['updateName'])) {
	$updateProduct = new Product($db);
	$updateProduct->setId($_GET['id']);     
	$updateProduct->setName($_POST['updateName']);
	$updateProduct->setCode($_POST['updateCode']);
	$updateProduct->setSecondhand($_POST['updateSecondhand']);
	$updateProduct->setDescription($_POST['updateDescription']);
	$updateProduct->setSupplierId($_POST['updateSupplier']);
	$updateProduct->setPrice($_POST['updatePrice']);  
	$updateProduct->controle();   
	if ($updateProduct->getError()) {
		echo $updateProduct->getError(); ?>
		<form action="<?php $location . '&id=' . $updateProduct->getId(); ?>" method="post">
			Naam: <input type="text" name="updateName" value="<?php echo $updateProduct->getName(); ?>"><br>
			Code: <input type="text" name="updateCode" value="<?php echo $updateProduct->getCode(); ?>"><br>
			Tweede hands: <select name="updateSecondhand">
				<?php if($updateProduct->getSecondhand() == 0) { ?>
					<option value="0">Nee</option>
					<option value="1">Ja</option>
				<?php } else { ?>
					<option value="1">Ja</option>
					<option value="0">Nee</option>
				<?php } ?>
			</select><br>
			Beschrijving: <textarea name="updateDescription"><?php echo $updateProduct->getDescription(); ?></textarea><br>
			Leverancier: <select name="updateSupplier">
			<option value="<?php echo $updateProduct->getSupplierId(); ?>"><?php echo $updateProduct->getSupplierName(); ?></option>
			<?php foreach ($updateProduct->getAllSupplier(array(array('id', '!=', $updateProduct->getSupplierId()))) as $suppl) { ?>
				<option value="<?php echo $suppl[0]; ?>"><?php echo $suppl[1]; ?></option>
			<?php } ?>
		</select><br>
			Prijs: <input type="text" name="updatePrice" value="<?php echo $updateProduct->getPrice(); ?>"><br>
			<?php	
			foreach ($updateProduct->getLinkedCategory() as $category) {
				echo '<input type="checkbox" name="product_category[]" value="' . $category[0] . '"';
				foreach ($_POST['product_category'] as $checked) {
					if ($category[0] == $checked) {
						echo "checked";
					}
				}
				
				echo '>' . $category[1] . "<br>";
			}
			?>
			<input type="submit">
			<a href="<?php echo $location; ?>">Terug</a>
		</form>
	<?php } else {
		$updateProduct->updateProduct();
		$updateProduct->linkCategory($_POST['product_category']);
		header('location: '. $location);
	}
}

//Product toevoegen input
elseif (isset($_GET['n'])) { ?>
	<form action="<?php echo $location; ?>" method="post">
		Naam: <input type="text" name="newName"><br>
		Code: <input type="text" name="newCode"><br>
		Tweede hands: <select name="newSecondhand">
			<option value="0">Nee</option>
			<option value="1">Ja</option>
		</select><br>
		Beschrijving: <textarea name="newDescription"></textarea><br>
		Leverancier: <select name="newSupplier">
			<?php foreach ($allProducts->getAllSupplier() as $suppl) { ?>
				<option value="<?php echo $suppl[0]; ?>"><?php echo $suppl[1]; ?></option>
			<?php } ?>
		</select><br>
		Prijs: <input type="text" name="newPrice"><br>
		<?php
		$Category = new Category($db);	
		foreach ($Category->getAll() as $category) {
			echo '<input type="checkbox" name="product_category[]" value="' . $category->getId() . '">' . $category->getName() . '<br>';
		}
		?>
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
				<option value="new">Voeg een leverancier toe</option>
		</select><br>
		Prijs: <input type="text" name="updatePrice" value="<?php echo $pro->getPrice() ?>"><br>
		<?php	
			foreach ($pro->getLinkedCategory() as $category) {
				echo '<input type="checkbox" name="product_category[]" value="' . $category[0] . '"';
				if ($category[2]) {
					echo "checked";
				}
				echo '>' . $category[1] . "<br>";
			}
		?>
		<input type="submit">
	</form>
	<a href="<?php echo $location .'&r=' . $pro->getId(); ?> ">Verwijder dit product</a>

<?php //Producten weergeven
} else { 
	foreach ($allProducts->getAll() as $pro) {
		echo '<a href="' . $location . '&e=' . $pro->getId() . '">';
			echo $pro->getName();
		echo "</a><br>";
	}
	echo '<br><a href="' . $location . '&n">Product toevoegen</a>';
}

?>
