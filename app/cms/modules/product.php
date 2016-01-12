<div class="neworders product page">
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
		$product->setPrice($_POST['price']);
		$product->setSupplierId($_POST['supplier']);
		if (isset($_POST['img']) && $_POST['img'] != 'null') {
			$product->setImg($_POST['img']);
		} else {
			$product->setImg(null);
		}

		$product->controle();
		if ($product->getError()) {
			$showForm = true;
		} else {
			if (isset($_GET['id'])) {
				$product->updateProduct();
			} else {
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
		$product->setImg(null);
		$showForm = true;
	}

	if ($showForm) { ?>
		<h1>
			<?php if (isset($_GET['n'])) {
				echo "Product toevoegen";
			} else {
				echo "Product bewerken";
			} ?>
		</h1>
		<?php echo '<h2>';
			if ($product->getError()) {
				echo $product->getError();
			} else {
				echo '<br>';
			}
		echo '</h2>'; ?>
		<form action="<?php if(isset($_GET['e']) || isset($_GET['id'])) {
					echo $location . '&id=' . $product->getId();
				} else {
					echo $location; } ?>" method="post">
			<div class="edit">
				Naam:<br>
				<input type="text" name="name" value="<?php echo $product->getName(); ?>"><br>
				Code:<br>
				<input type="text" name="code" value="<?php echo $product->getCode(); ?>"><br>
				Tweede hands:<br>
				<select name="secondhand">
					<?php if($product->getSecondhand() == 0 || isset($_GET['n'])) { ?>
						<option value="0">Nee</option>
						<option value="1">Ja</option>
					<?php } else { ?>
						<option value="1">Ja</option>
						<option value="0">Nee</option>
					<?php } ?>
				</select><br>
				Beschrijving:<br>
				<textarea name="description"><?php echo $product->getDescription(); ?></textarea><br>
				Leverancier:<br>
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
				</select><br>
				Prijs:<br>
				<input type="text" name="price" value="<?php echo $product->getPrice(); ?>"><br>
			</div>
			<div class="mid">
				Productafbeelding:<br>
				<input type="radio" <?php if($product->getImg() == null) { echo 'checked'; } ?> value="null" name="img"> Geen afbeelding<br>
				<?php
				$media = new Media();
				foreach ($media->getMedia() as $photo) {
					if ($media->getType($photo->name) == 'Afbeelding') { ?>
						<label  class="radioimg">
							<img src="<?php echo $photo->path . '/' . $photo->name; ?>">
							<input type="radio" name="img" value="<?= $photo->id ?>" <?php if($photo->id == $product->getImg()) { echo 'checked'; } ?>>
						</label>
					<?php } ?>
				<?php }
				?>
				<br>
				<input type="submit" value="Opslaan" class="btn"><br>
				<a href="<?php echo $location; ?>"><button  type="button">Ga terug</button></a>
				<?php if(isset($_GET['e']) || isset($_GET['id'])) { ?>
					<a href="<?php echo $location; ?>&r=<?=$product->getId()?>"><button  type="button">Verwijder dit product</button></a>
				<?php } ?>
			</div>


			<div class="category">
				<h2>Gelinkte categoriën</h2>
					<?php $Category = new Category($db);
					$checked = array();

					if (isset($_GET['e'])) {
						foreach ($product->getLinkedCategory() as $category) {
							if ($category[2]) {
								array_push($checked, $category[0]);
							}
						}
					} elseif (isset($_POST['product_category'])) {
						$checked = $_POST['product_category'];
					}
					?>

					<ul>
						<?php foreach ($Category->getAll(array(array('parent', 'IS', 'NULL'))) as $categoryParent) { ?>
							<li>
								<input type="checkbox" name="product_category[]" value="<?=$categoryParent->getId()?>"
								<?php if (array_search($categoryParent->getId(), $checked) > -1) {
									echo "checked";
								} ?>>
								<?=$categoryParent->getName();?>
							<ul>
								<?php foreach ($Category->getAll(array(array('parent', '=', $categoryParent->getId()))) as $categoryChild) { ?>
									<li>
										<input type="checkbox" name="product_category[]" value="<?=$categoryChild->getId()?>"
										<?php if (array_search($categoryChild->getId(), $checked) > -1) {
											echo "checked";
										}
										echo "> ";
										echo $categoryChild->getName(); ?>
									</li>
								<?php } ?>
							</ul>
							</li>
						<?php } ?>
					</ul>
				</div>
			</table>
	<?php }

	elseif (isset($_GET['supplier'])) {
		if (isset($_GET['supplrem'])) {
			$product->setSupplierId($_GET['supplrem']);
			if (!$product->removeSupplier() == 0) {
				$error = $product->removeSupplier();
			} else {
				header('location: ' . $location . '&supplier');
			}
		}
		if (isset($_POST['suppUpdate'])) {
			$product->setSupplierId($_GET['suppledit']);
			if (!$product->updateSupplier($_POST['levName'], $_POST['levSite']) == 0) {
				$error = $product->updateSupplier($_POST['levName'], $_POST['levSite']);
			} else {
				header('location: ' . $location . '&supplier');
			}
		}
		if (isset($_POST['suppNew'])) {
			if (!$product->newSupplier($_POST['levName'], $_POST['levSite']) == 0) {
				$error = $product->updateSupplier($_POST['levName'], $_POST['levSite']);
			} else {
				header('location: ' . $location . '&supplier');
			}
		}

		?>
		<div class="supplier">
			<h1>
				Leverancierbeheer
			</h1>
			<br>
			<div class="add">
				<?php if (!isset($_GET['suppledit'])){ ?>
					<h2>Leverancier toevoegen</h2>
				<?php } else { ?>
					<h2>Leverancier bewerken</h2>
				<?php }

				if (isset($error)) {
					echo "<h3>" . $error . "</h3>";
				} else {
					echo "<h3><br></h3>";
				} ?>
				<form action="<?=$location?>&supplier" method="post">
					Naam van de leverancier:<br>
					<input type="text" name="levName"
						<?php if (isset($_GET['suppledit'])) {
							echo 'value="';
							$product->setSupplierId($_GET['suppledit']);
							echo $product->getSupplierName();
							echo '"';
						} ?>><br>
					Website van de leverancier:<br>
					<input type="text" name="levSite"<?php if (isset($_GET['suppledit'])) {
							echo 'value="';
							echo $product->getSupplierWebsite();
							echo '"';
						} ?>><br>
					<input type="submit" class="btn" value="Leverancier opslaan"
					<?php if (isset($_GET['suppledit'])) {
						echo 'name="suppUpdate"';
					} else {
						echo 'name="suppNew"';

					} ?> >
				</form>
			</div>
			<table class="cms page product show">
				<h2>Alle leveranciers</h2>
				<tr>
					<td>Naam</td>
					<td>Website</td>
					<td></td>
					<td></td>
				</tr>
				<?php foreach ($product->getAllSupplier() as $supplier) { ?>
					</tr>
					<tr>
						<td><?=$supplier[1]?></td>
						<td><?=$supplier[2]?></td>
						<td><a href="<?=$location?>&supplier&suppledit=<?=$supplier[0]?>">Bewerken</a></td>
						<td><a href="<?=$location?>&supplier&supplrem=<?=$supplier[0]?>">Verwijderen</a></td>

					</tr>
				<?php } ?>
			</table>
		</div>
	<?php }


	//Producten weergeven
	else { ?>
		<h1>
			Product beheer
		</h1>
		<div class="link">
			<br><a href="<?=$location?>&n"><button>Product toevoegen</button></a>
			<a href="index.php?page=cms&module=category"><button>Categorieën beheren</button></a>
			<a href="<?=$location?>&supplier"><button>Leveranciers beheren</button></a>
		</div>
		<table class='cms page product'>
			<tr>
				<td><b>Productnaam</b></td>
				<td><b>Beschrijving</b></td>
				<td><b>Leverancier</b></td>
				<td><b>Prijs</b></td>
				<td></td>
				<td></td>
			</tr>
			<?php
			foreach ($product->getAll() as $pro) {
				$price = str_replace('.', ',', ($pro->getPrice())); ?>
			<tr>
				<td><?= $pro->getName(); ?></td>
				<td><?= $pro->getDescription(); ?></td>
				<td><?= $pro->getSupplierName(); ?></td>
				<td><?= "&euro;{$price}"; ?></td>
				<td>
					<a href="<?= $location ?>&e=<?= $pro->getId() ?>">Bewerken</a>
				</td>
				<td>
					<a href="<?= $location ?>&r=<?= $pro->getId() ?>">Verwijderen</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	<?php }

	?>

</div>
