<?php
include_once 'app/classes/Category.php';
include_once 'app/classes/Database.php';

$category = array();

//Categorie toevoegen
if (isset($_POST['newCategory'])) { 
	$newCategory = new Category();
	filter_input(INPUT_POST, 'newHead', FILTER_VALIDATE_INT);
	if ($_POST['newHead'] == 0) {
		$_POST['newHead'] = null;
	}
	header('location: category.php' . $newCategory->createCategory($_POST['newCategory'], $_POST['newHead']));
}


//Categorie updaten
if (isset($_POST['updateCategory']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
	$updateCategory = new Category();
	$oldCategory = new Category();
	$oldCategory->set('auto', $_GET['id']);
	$updateCategory->linkProduct($_GET['id'], $_POST['product_category']);
	if ($_POST['updateHead'] == 0) {
		$_POST['updateHead'] = null;
	}
	header('location: category.php' . $updateCategory->updateCategory($_GET['id'], $_POST['updateCategory'], $_POST['updateHead'], $oldCategory->get('name'), $oldCategory->get('head')));
}


//Categorie verwijderen
if (filter_input(INPUT_GET, 'r', FILTER_VALIDATE_INT)) {
	$removeCategory = new Category();
	echo $removeCategory->removeCategory($_GET['r']);
	header('location: category.php');
}


//Categorie bewerken
if (filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT)) {	
	$id = $_GET['e'];
	$category[$id] = new Category();
	$category[$id]->set('auto', $_GET['e']); ?>

	<form action="category.php?id=<?php echo $id ?>" method="post">
		<input type="text" name="updateCategory" value="<?php echo $category[$id]->get('name') ?>">
		<select name="updateHead">
			<?php
				if ($category[$id]->get('head') == NULL) {
					echo '<option value="0">Geen</option>';
				} else {
					echo '<option value="' . $category[$id]->get('head') . '">';
					echo $category[$id]->get('nameHead') . "</option>";
					echo '<option value="0">Geen</option>';
				}

				$database = new Database();
				$sql = $database::start()->get('id', 'category', array(array('head', 'IS', 'NULL')))->results();
				if (!empty($sql)) {
					foreach ($sql as $key => $std) {
						if ($std->id != $id && $std->id != $category[$id]->get('head')) {
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

	<a href="?r=<?php echo $id ?>">Verwijder</a>
	<?php echo '<a href="category.php">Terug</a>';
}

//Categorie weergeven en toevoegen
else { 
	$database = new Database();
	$sql = $database::start()->get('id', 'category', array(array('head', 'IS', 'NULL')))->results();	
	foreach ($sql as $key => $std) {
		$category[$key] = new Category();
		$category[$key]->set('auto', $std->id); ?>
		<ul>
			<li>
				<a href="<?php echo "?e=" . $category[$key]->get('id'); ?>">
					 <?php echo $category[$key]->get('name'); ?>
				</a>
			</li>
			<?php
				$sqlHead = $database::start()->get('id', 'category', array(array('head', '=', $category[$key]->get('id'))))->results();
				foreach ($sqlHead as $keyHead => $stdHead) {
					$categoryHead[$keyHead] = new Category();
					$categoryHead[$keyHead]->set('auto', $stdHead->id); ?>
					<ul>
						<li>
							<a href="<?php echo "?e=" . $categoryHead[$keyHead]->get('id'); ?>">
								 <?php echo $categoryHead[$keyHead]->get('name'); ?>
							</a>
						</li>
					</ul>
				<?php }	?>
		</ul>
		
	<?php } ?>

	<form action="category.php" method="post">
		<input type="text" name="newCategory">
		<select name="newHead">
			<option value="0">Geen</option>
			<?php
				$database = new Database();
				$sql = $database::start()->get('id', 'category', array(array('head', 'IS', 'NULL')))->results();
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