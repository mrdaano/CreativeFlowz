<?php
	$media = new Media;
	if(isset($_POST['submit'])) {
		if($media->addFile()) {
			die("Gelukt...");
		}
	}
?>
        <div class="neworders media_beheer">
              <h1>Media beheer</h1>
              <?php
	             foreach($media->getErrors() as $error) {
		             echo "<p class=\"error\">{$error}</p>";
	             }
	            if (isset($_GET['actie'])) {
		            if ($_GET['actie'] == "toevoegen") { ?>
			            <form action="index.php?page=cms&module=mediamanagment&actie=toevoegen" method="post" enctype="multipart/form-data">
				            <div>
					            <label>Bestand*</label>
					            <input type="file" name="file">
				            </div>
				            <input type="submit" value="Uploaden" class="btn" name="submit">
			            </form>
		        <?php    }
	            } else {
	          ?>
              <a href="index.php?page=cms&module=mediamanagment&actie=toevoegen" class="btn">Voeg bestand toe</a>
              <table class="media_table">
	              <thead>
		              <tr>
			              <th>Naam</th>
			              <th>Type</th>
			              <th>Acties</th>
		              </tr>
	              </thead>
	              <tbody>
		              <tr>
			              <td><a href="#">Test.png</a></td>
			              <td>Image</td>
			              <td><a href="#" class="btn">Verwijderen</a></td>
		              </tr>
		              <tr>
			              <td>Test.png</td>
			              <td>Image</td>
			              <td>Edit</td>
		              </tr>
	              </tbody>
              </table>
              <?php } ?>
        </div>