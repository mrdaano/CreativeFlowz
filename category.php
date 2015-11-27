<?php
include_once 'app/classes/Database.php';
include_once 'app/classes/Category.php';

if (isset($_POST['newCategory'])) {
	if ($_POST['newCategory'] == '') {
		header('location: category.php?e=none');
	} else {
		$newCategory = new Category();
		$newCategory->setCategory($_POST['newCategory']);
		$position = $_POST['position'];
		if ($_POST['position'] != '') {
			if (filter_input(INPUT_POST, 'position', FILTER_VALIDATE_INT)) {
				$newCategory->setPostion($_POST['position']);
			} else {
				header('location: category.php?e=pos');
				break;
			}
		}
		if ($newCategory->controle() == 'true') {
			$newCategory->createCategory();
			header('location: category.php');
		} else {
			header('location: category.php?e=' . $newCategory->controle());
		}
		
	}
}

$database = new Database();
$allCategory = $database::start()->get('*', 'category')->results();
$category = array();
foreach ($allCategory as $key => $std) {
	$category[$key] = new Category();
	$category[$key]->setCategory($std->name);
	$category[$key]->setId($std->id);
	$category[$key]->setPostion($std->position); ?>

	<ul>
		<li>
			<?php echo $category[$key]->getCategory(); ?>
		</li>
		<li>
			<a href="?e=<?php echo $category[$key]->getId(); ?>">
				Bewerken
			</a>
		</li>
		<li>
			<a href="?r=<?php echo $category[$key]->getId(); ?>">
				Verwijder
			</a>
		</li>
	</ul>

<?php } ?>

<form action="category.php" method="post">
	<input type="text" name="newCategory">
	<input type="text" name="position">
	<input type="submit">
</form>

<?php
		if (isset($_GET['e'])) {
			switch ($_GET['e']) {
				case 'none':
					echo "U heeft geen categorie ingevoerd.";
					break;

				case 'pos':
					echo "U heeft geen juiste positie ingevuld";
					break;

				case 'catexist';
					echo "Deze catogorie bestaat al.";
					break;

				case 'posexist';
					echo "Deze positie is al in gebruik.";
					break;
			}	
		}
		
	?>