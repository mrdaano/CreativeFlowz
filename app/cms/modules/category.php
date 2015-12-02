<?php
$category = array();

//Categorie toevoegen
if (isset($_POST['newCategory'])) { 
	$newCategory = new Category();
	filter_input(INPUT_POST, 'newParent', FILTER_VALIDATE_INT);
	if ($_POST['newParent'] == 0) {
		$_POST['newParent'] = NULL;
	}
	header('location: index.php?cmspage&module=category' . $newCategory->createCategory($_POST['newCategory'], $_POST['newParent']));
}


//Categorie updaten
if (isset($_POST['updateCategory']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
	$updateCategory = new Category();
	$oldCategory = new Category();
	if ($_POST['updateParent'] == 0) {
		$_POST['updateParent'] = NULL;
	}
	$oldCategory->set('auto', $_GET['id']);
	$updateCategory->linkProduct($_GET['id'], $_POST['product_category']);
	header('location: index.php?cmspage&module=category' . $updateCategory->updateCategory($_GET['id'], $_POST['updateCategory'], $_POST['updateParent'], $oldCategory->get('name'), $oldCategory->get('parent')));
}


//Categorie verwijderen
if (filter_input(INPUT_GET, 'r', FILTER_VALIDATE_INT)) {
	$removeCategory = new Category();
	echo $removeCategory->removeCategory($_GET['r']);
	header('location: index.php?cmspage&module=category');
}


//Categorie bewerken
if (filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT)) {	
	$id = $_GET['e'];
	$category[$id] = new Category();
	$category[$id]->set('auto', $_GET['e']); ?>

	<form action="index.php?cmspage&module=category&id=<?php echo $id ?>" method="post">
		<input type="text" name="updateCategory" value="<?php echo $category[$id]->get('name') ?>">
		<select name="updateParent">
			<?php
				if ($category[$id]->get('parent') == NULL) {
					echo '<option value="0">Geen</option>';
				} else {
					echo '<option value="' . $category[$id]->get('parent') . '">';
					echo $category[$id]->get('nameParent') . "</option>";
					echo '<option value="0">Geen</option>';
				}

				$database = new Database();
				$sql = $database::start()->get('id', 'category', array(array('parent', 'IS', 'NULL')))->results();
				if (!empty($sql)) {
					foreach ($sql as $key => $std) {
						if ($std->id != $id && $std->id != $category[$id]->get('parent')) {
							$category[$key] = new Category();
							$category[$key]->set('auto', $std->id);

							echo '<option value="' . $category[$key]->get('id') . '">';
							echo $category[$key]->get('name') . "</option>";
						}
					}
				}
			?>
		</select>
		<br>
		<?php
			
			$sql = $database::start()->get(array('name', 'id'), 'product')->results();
			foreach ($sql as $std) {
				echo '<input type="checkbox" name="product_category[]" value="' . $std->id . '"';
				$sqlChecked = $database::start()->get('product_id', 'product_category', array(array('category_id', '=', $id)))->results();
				foreach ($sqlChecked as $stdChecked) {
					//echo $stdChecked->product_id;
					if ($stdChecked->product_id == $std->id) {
						echo "checked";
					}
				}
				echo '>' . $std->name . "<br>";
			}
		?>
		<input type="submit">
	</form>

	<a href="index.php?cmspage&module=category&r=<?php echo $id ?>">Verwijder</a>
	<?php echo '<a href="index.php?cmspage&module=category">Terug</a>';
}

//Categorie weergeven
else { 
	$database = new Database();
	$sql = $database::start()->get('id', 'category', array(array('parent', 'IS', 'NULL')))->results();	
	foreach ($sql as $key => $std) {
		$category[$key] = new Category();
		$category[$key]->set('auto', $std->id); ?>
		<ul>
			<li>
				<a href="<?php echo "index.php?cmspage&module=category&e=" . $category[$key]->get('id'); ?>">
					 <?php echo $category[$key]->get('name'); ?>
				</a>
			</li>
			<?php
				$sqlParent = $database::start()->get('id', 'category', array(array('parent', '=', $category[$key]->get('id'))))->results();
				foreach ($sqlParent as $keyParent => $stdParent) {
					$categoryParent[$keyParent] = new Category();
					$categoryParent[$keyParent]->set('auto', $stdParent->id); ?>
					<ul>
						<li>
							<a href="<?php echo "index.php?cmspage&module=category&e=" . $categoryParent[$keyParent]->get('id'); ?>">
								 <?php echo $categoryParent[$keyParent]->get('name'); ?>
							</a>
						</li>
					</ul>
				<?php }	?>
		</ul>
		
	<?php } ?>

	<form action="" method="post">
		<input type="text" name="newCategory">
		<select name="newParent">
			<option value="0">Geen</option>
			<?php
				$database = new Database();
				$sql = $database::start()->get('id', 'category', array(array('parent', 'IS', 'NULL')))->results();
				if (!empty($sql)) {
					foreach ($sql as $key => $std) {
						$category[$key] = new Category();
						$category[$key]->set('auto', $std->id);

						echo '<option value="' . $category[$key]->get('id') . '">';
						echo $category[$key]->get('name') . "</option>";
					}
				}
			?>
		</select>
		<input type="submit">
	</form> 

	<?php
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