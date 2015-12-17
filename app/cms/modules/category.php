<div class="page">
<?php
$db = new Database();

$allCategory = new Category($db);
$category = new Category($db);

//Errors
if (isset($_GET['m'])) {
	echo "<br><h2>";
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
	echo "</h2>";	
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

	<a href="index.php?page=cms&module=category&r=<?php echo $category->getId() ?>">Verwijder</a>
	<?php echo '<a href="index.php?page=cms&module=category">Terug</a>';
}

//Categorie weergeven en toevoegen
else { ?>
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
	</form>
	<table class="cms page product">
		<tr>
			<td>
				<b>Parent:</b>
			</td>
			<td>
				<b>Child:</b>
			</td>
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
			<td colspan="2">Er zijn geen categoriën gevonden.</td>
		<?php } ?>
	</table>
<?php }
?>
</div>