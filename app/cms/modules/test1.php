<?php
$db = new Database();
$category = new Category($db); ?>

<ul>
	<li>
		Geen
	</li>
	<?php foreach ($category->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) { ?>
	<li>
		<?php echo $cat->getName(); ?>
		<ul>
		<?php foreach ($category->getAll(array(array('parent', '=', $cat->getId()))) as $child) { ?>
			<li>
				<?php echo $child->getName(); ?>
			</li>
		<?php } ?>
		</ul>
	</li>
	<?php } ?>
</ul>