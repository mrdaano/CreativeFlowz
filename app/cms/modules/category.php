<?php
$db = new Database();

$allCategory = new Category($db);
$category = new Category($db);

//Categorie toevoegen
if (isset($_POST['newCategory'])) {
	$newCategory = new Category($db);
	filter_input(INPUT_POST, 'newParent', FILTER_VALIDATE_INT);
	if ($_POST['newParent'] == 0) {
		$_POST['newParent'] = NULL;
	}
	$newCategory->setName($_POST['newCategory']);
	$newCategory->setParent($_POST['newParent']);
	header('location: index.php?cmspage&module=category' . $newCategory->createCategory());
}

//Categorie updaten
if (isset($_POST['updateCategory']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
	$updateCategory = new Category($db);
	$oldCategory = new Category($db);
	if ($_POST['updateParent'] == 0) {
		$_POST['updateParent'] = NULL;
	}
	$updateCategory->setId($_GET['id']);
	$updateCategory->setName($_POST['updateCategory']);
	$updateCategory->setParent($_POST['updateParent']);

	$oldCategory->setAuto($_GET['id']);
	$updateCategory->linkProduct($_POST['product_category']);
	header('location: index.php?cmspage&module=category' . $updateCategory->updateCategory($oldCategory->getName(), $oldCategory->getParent()));
}

//Categorie verwijderen
if (filter_input(INPUT_GET, 'r', FILTER_VALIDATE_INT)) {
	$removeCategory = new Category($db);
	$removeCategory->setId($_GET['r']);
	echo $removeCategory->removeCategory();
	header('location: index.php?cmspage&module=category');
}

//Categorie bewerken
if (filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT)) {
	$id = $_GET['e'];
	$category->setAuto($_GET['e']); ?>

	<form action="index.php?cmspage&module=category&id=<?php echo $category->getId() ?>" method="post">
		<input type="text" name="updateCategory" value="<?php echo $category->getName() ?>">
		<select name="updateParent">
			<?php
				if ($category->getParent() == NULL) {
					echo '<option value="0">Geen</option>';
				} else {
					echo '<option value="' . $category->getParent() . '">';
					echo $category->getNameParent() . "</option>";
					echo '<option value="0">Geen</option>';
				}

				foreach ($allCategory->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) {
					if ($cat->getId() != $category->getId() && $cat->getId() != $category->getParent()) {
						echo '<option value="';
							echo $cat->getId();
						echo '">';
							echo $cat->getName();
						echo "</option>";
					}
				}
			?>
		</select>
		<br>
		<?php
			foreach ($category->getLinkedProducts() as $product) {
				echo '<input type="checkbox" name="product_category[]" value="' . $product[0] . '"';
				if (isset($product[2])) {
					echo "checked";
				}
				echo '>' . $product[1] . "<br>";
			}
		?>
		<input type="submit">
	</form>

	<a href="index.php?cmspage&module=category&r=<?php echo $category->getId() ?>">Verwijder</a>
	<?php echo '<a href="index.php?cmspage&module=category">Terug</a>';
}

//Categorie weergeven en toevoegen
else {
	foreach ($allCategory->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) { ?>
		<ul>
			<li>
				<a href="<?php echo "index.php?cmspage&module=category&e=" . $cat->getId(); ?>">
					<?php echo $cat->getName(); ?>
				</a>
			</li>
			<?php
				foreach ($allCategory->getAll(array(array('parent', '=', $cat->getId()))) as $child) { ?>
					<ul>
						<li>
							<a href="<?php echo "index.php?cmspage&module=category&e=" . $child->getId(); ?>">
								 <?php echo $child->getName(); ?>
							</a>
						</li>
					</ul>
			<?php	} ?>
		</ul>
	<?php } ?>

	<form action="" method="post">
		<input type="text" name="newCategory">
		<select name="newParent">
			<option value="0">Geen</option>
			<?php
				$sql = $db::start()->get('id', 'category', array(array('parent', 'IS', 'NULL')))->results();
				if (!empty($sql)) {
					foreach ($sql as $key => $std) {
						$category->setAuto($std->id);

						echo '<option value="' . $category->getId() . '">';
						echo $category->getName() . "</option>";
					}
				}
			?>
		</select>
		<input type="submit">
	</form> <?php
}

//Errors
if (isset($_GET['m'])) {
	echo "<br>";
	switch ($_GET['m']) {
			case 'none':
				echo "U heeft geen categorie ingevoerd.";
				break;
			case 'pos':
				echo "U heeft geen juiste positie ingevuld";
				break;
			case 'exist':
				echo "Deze catogorie bestaat al.";
				break;
			case 'subcat':
				echo "Deze categorie bevat sub catogorieen, u kunt deze zelf niet onderverdelen. ";
	}
}
?>
=======
<div class="neworders page category">
	<?php
	$db = new Database();

	$allCategory = new Category($db);
	$category = new Category($db);

	//Errors
	if (isset($_GET['m'])) {
		switch ($_GET['m']) {
				case 'none':
					$error =  "U heeft geen categorie ingevoerd.";
					break;
				case 'pos':
					$error =  "U heeft geen juiste positie ingevuld";
					break;
				case 'exist':
					$error =  "Deze categorie bestaat al.";
					break;
				case 'subcat':
					$error =  "Deze categorie bevat sub categorieën, daarom kunt deze categorie zelf niet onderverdelen. ";
		}
	}

	//Categorie toevoegen
	if (isset($_POST['newCategory'])) {
		$newCategory = new Category($db);
		filter_input(INPUT_POST, 'newParent', FILTER_VALIDATE_INT);
		if ($_POST['newParent'] == 0) {
			$_POST['newParent'] = NULL;
		}
		$newCategory->setName($_POST['newCategory']);
		$newCategory->setParent($_POST['newParent']);
		header('location: index.php?page=cms&module=category' . $newCategory->createCategory());
	}

	//Categorie updaten
	if (isset($_POST['updateCategory']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
		$updateCategory = new Category($db);
		$oldCategory = new Category($db);
		if ($_POST['updateParent'] == 0) {
			$_POST['updateParent'] = NULL;
		}
		$updateCategory->setId($_GET['id']);
		$updateCategory->setName($_POST['updateCategory']);
		$updateCategory->setParent($_POST['updateParent']);

		$oldCategory->setAuto($_GET['id']);
		$updateCategory->linkProduct($_POST['product_category']);
		header('location: index.php?page=cms&module=category' . $updateCategory->updateCategory($oldCategory->getName(), $oldCategory->getParent()));
	}

	//Categorie verwijderen
	if (filter_input(INPUT_GET, 'r', FILTER_VALIDATE_INT)) {
		$removeCategory = new Category($db);
		$removeCategory->setId($_GET['r']);
		echo $removeCategory->removeCategory();
		header('location: index.php?page=cms&module=category');
	}

	//Categorie bewerken
	if (filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT)) {
		$id = $_GET['e'];
		$category->setAuto($_GET['e']); ?>

		<form action="index.php?page=cms&module=category&id=<?php echo $category->getId() ?>" method="post">
			<h1>
				Categorie bewerken:
			</h1>
			<?php if (isset($error)) {
				echo "<h2>". $error ."</h2>";
			} else {
				echo "<h2><br></h2>";
			} ?>
			<div class="edit">
				Categorie naam:<br>
				<input type="text" name="updateCategory" value="<?php echo $category->getName() ?>"><br>
				Valt onder:<br>
				<select name="updateParent">
					<?php
						if ($category->getParent() == NULL) {
							echo '<option value="0">Geen</option>';
						} else {
							echo '<option value="' . $category->getParent() . '">';
							echo $category->getNameParent() . "</option>";
							echo '<option value="0">Geen</option>';
						}

						foreach ($allCategory->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) {
							if ($cat->getId() != $category->getId() && $cat->getId() != $category->getParent()) {
								echo '<option value="';
									echo $cat->getId();
								echo '">';
									echo $cat->getName();
								echo "</option>";
							}
						}
					?>
				</select><br>
				<input type="submit" value="Categorie opslaan" class="btn"><br>
				<a href="index.php?page=cms&module=category"><button>Ga terug</button></a>
				<a href="index.php?page=cms&module=category&r=<?php echo $category->getId() ?>"><button>Verwijder categorie</button></a>
			</div>
			<div class="linkedProducts">
				<h2>
					Gelinkte producten:
				</h2>
				<?php
					foreach ($category->getLinkedProducts() as $product) {
						echo '<input type="checkbox" name="product_category[]" value="' . $product[0] . '"';
						if ($product[2]) {
							echo "checked";
						}
						echo '>' . $product[1] . "<br>";
					}
				?><br>
			</div>
		</form>
	<?php }

	//Categorie weergeven en toevoegen
	else { ?>
		<h1>
			Categorie Beheer
		</h1>
		<br>
		<form action="" method="post" class="add">
			<h2>
				Categorie toevoegen:
			</h2>
			<?php if (isset($error)) {
				echo "<h3>" . $error . "</h3>";
			} else {
				echo "<h3><br></h3>";
			} ?>
			<br>
			Categorie naam:<br>
			<input type="text" name="newCategory"><br>
			Valt onder:<br>
			<select name="newParent">
				<option value="0">Geen</option>
				<?php
					$sql = $db::start()->get('id', 'category', array(array('parent', 'IS', 'NULL')))->results();
					if (!empty($sql)) {
						foreach ($sql as $key => $std) {
							$category->setAuto($std->id);

							echo '<option value="' . $category->getId() . '">';
							echo $category->getName() . "</option>";
						}
					}
				?>
			</select><br>
			<input type="submit" class="btn" value="Categorie opslaan">
		</form>
		<table class="cms page product show">
			<h2>
				Alle categorieën:
			</h2>
			<tr>
				<td>
					<b>Parent:</b>
				</td>
				<td>
					<b>Child:</b>
				</td>
				<td></td>
				<td></td>
			</tr>
			<?php foreach ($allCategory->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) {
				$gevonden = true; ?>
				<tr>
					<td>
						<?php echo $cat->getName(); ?>
					</td>
					<td></td>
					<td>
						<a href="<?php echo "index.php?page=cms&module=category&e=" . $cat->getId(); ?>">
							Bewerken
						</a>
					</td>
					<td>
						<a href="<?php echo "index.php?page=cms&module=category&r=" . $cat->getId(); ?>">
							 Verwijderen
						</a>
					</td>
				</tr>
				<?php
					foreach ($allCategory->getAll(array(array('parent', '=', $cat->getId()))) as $child) { ?>
						<tr>
							<td align="right"> - </td>
							<td>
								<?=$child->getName()?>
							</td>
							<td>
								<a href="<?php echo "index.php?page=cms&module=category&e=" . $child->getId(); ?>">
									 Bewerken
								</a>
							</td>
							<td>
								<a href="<?php echo "index.php?page=cms&module=category&r=" . $child->getId(); ?>">
									 Verwijderen
								</a>
							</td>
						</tr>
					<?php	} ?>
				</tr>
			<?php }
			if (!isset($gevonden)) { ?>
				<td colspan="4">Er zijn geen categorieën gevonden.</td>
			<?php } ?>
		</table>
	<?php }
	?>
</div>
