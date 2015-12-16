<div class="page">
<?php
$db = new Database();
$product = new Product($db);

$allProducts = new Product($db);
$location = 'index.php?page=cms&module=product';
$showForm = false;

//Product verwijderen
if ((isset($_GET['r']))) {
	$removeProduct = new Product($db);
	$removeProduct->setId($_GET['r']);
	$removeProduct->removeProduct();
	header('location: ' . $location);
}

//Update of Voegt toe 
if (isset($_POST['name'])) {
	if (isset($_GET['id'])) {
		$product->setId($_GET['id']);
	}

	$product->setName($_POST['name']);
	$product->setCode($_POST['code']);
	$product->setSecondhand($_POST['secondhand']);
	$product->setDescription($_POST['description']);
	$product->setSupplierId($_POST['supplier']);
	$product->setPrice($_POST['price']);

	$product->controle();
	if ($product->getError()) {
		echo '<h2>';
			echo $product->getError();
		echo '</h2>';
		$showForm = true;

	} else {
		if (isset($_GET['id'])) {
			$product->updateProduct();
		} else {
			//echo 'geen update';
			$product->newProduct();	
			$product->setIdFromDatabase();
		}

		if (isset($_POST['product_category'])) {
			$product->linkCategory($_POST['product_category']);
		}		
		header('location: '. $location);
	}
} elseif(isset($_GET['e'])) {
	$product = $product->getAll(array(array('id', '=', $_GET['e'])));
	$product = $product[0];
	$showForm = true;
} elseif(isset($_GET['n'])) {

	$product->setName(null);
	$product->setCode(null);
	$product->setSecondhand(null);
	$product->setDescription(null);
	$product->setSupplierId(null);
	$product->setPrice(null);
	$showForm = true;
}

if ($showForm) { ?>
	<form action="<?php if(isset($_GET['e']) || isset($_GET['id'])) { 
			echo $location . '&id=' . $product->getId(); 
		} else { 
			echo $location; }?>" method="post">
		<table class='cms page product'>
			<tr>
				<td>Naam:</td>
				<td><input type="text" name="name" value="<?php echo $product->getName(); ?>"></td>
			</tr>
			<tr>
				<td>Code:</td>
				<td><input type="text" name="code" value="<?php echo $product->getCode(); ?>"></td>
			</tr>
			<tr>
				<td>Tweede hands:</td>
				<td>
					<select name="secondhand">
						<?php if($product->getSecondhand() == 0 || isset($_GET['n'])) { ?>
							<option value="0">Nee</option>
							<option value="1">Ja</option>
						<?php } else { ?>
							<option value="1">Ja</option>
							<option value="0">Nee</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Beschrijving:</td>
				<td>
					<textarea name="description">
						<?php echo $product->getDescription(); ?>
					</textarea>
				</td>
			</tr>
			<tr>
				<td>Leverancier:</td>
				<td>
					<select name="supplier">
						<?php if (isset($_GET['n'])) {
							foreach ($product->getAllSupplier() as $suppl) { ?>
								<option value="<?php echo $suppl[0]; ?>">
									<?php echo $suppl[1]; ?>
								</option>
							<?php }

						} else { ?>
							<option value="<?php echo $product->getSupplierId(); ?>">
								<?php echo $product->getSupplierName(); ?>
							</option>
							<?php foreach ($product->getAllSupplier(array(array('id', '!=', $product->getSupplierId()))) as $suppl) { ?>
								<option value="<?php echo $suppl[0]; ?>">
									<?php echo $suppl[1]; ?>
								</option>
							<?php } 
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Prijs:</td>
				<td><input type="text" name="price" value="<?php echo $product->getPrice(); ?>"></td>
			</tr>
			<tr>
				<td colspan="2">
					<h2>Categoriën:</h2>
				</td>
			</tr>
			<?php 
			$Category = new Category($db);
			if (isset($_POST['product_category'])) {
				foreach ($Category->getAll() as $category) {
					echo "<tr><td>";
					echo '<input type="checkbox" name="product_category[]" value="' . $category->getId() . '"';
					if (array_search($category->getId(), $_POST['product_category']) > -1) {
						echo "checked";
					}
					echo '></td><td>' . $category->getName() . '</td></tr>';
				}
			} elseif (isset($_GET['e'])) {
				foreach ($product->getLinkedCategory() as $category) {
					echo "<tr><td>";
					echo '<input type="checkbox" name="product_category[]" value="' . $category[0] . '"';
					if ($category[2]) {
						echo 'checked';
					}
					echo '></td><td>' . $category[1] . '</td></tr>';

				}
			} else {
				foreach ($Category->getAll() as $category) {
					echo "<tr><td>";
					echo '<input type="checkbox" name="product_category[]" value="' . $category->getId() . '">';
					echo '</td><td>' . $category->getName() . '</td></tr>';

				}
			} ?>
			<tr>
				<td><input type="submit" value="Opslaan"></td>
				<td>
					<a href="<?php echo $location; ?>">
						Terug
					</a>
				</td>
			</tr>
		</table>
		</form>
<?php }

//Producten weergeven
else { ?>
	<table class='cms page product'>
		<tr>
			<td><b>Productnaam</b></td>
			<td><b>Beschrijving</b></td>
			<td><b>Leverancier</b></td>
			<td><b>Prijs</b></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($product->getAll() as $pro) { ?>
		<tr>
			<td><?= $pro->getName() ?></td>
			<td><?= $pro->getDescription() ?></td>
			<td><?= $pro->getSupplierName() ?></td>
			<td><?= $pro->getPrice() ?> euro</td>
			<td>
				<a href="<?= $location ?>&e=<?= $pro->getId() ?>">Bewerk</a>
			</td>
			<td>
				<a href="<?= $location ?>&r=<?= $pro->getId() ?>">Verwijder</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php echo '<br><a href="' . $location . '&n"><button>Product toevoegen</button></a>';
}

?>
</div>