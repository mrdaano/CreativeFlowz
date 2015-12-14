<?php
	$media = new Media;
	if(isset($_POST['submit'])) {
		if($media->addFile()) {
			echo "<script> window.location = 'index.php?page=cms&module=mediamanagment&success';</script>";
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
		           if (isset($_GET['success'])) {
			           echo "<p>Bestand is geupload.</p>";
		           }
	          ?>
              <a href="index.php?page=cms&module=mediamanagment&actie=toevoegen" class="btn">Voeg bestand toe</a>
			  <?php echo hexdec(uniqid()); ?>
              <table class="media_table">
	              <thead>
		              <tr>
			              <th>Naam</th>
			              <th>Type</th>
			              <th>Acties</th>
		              </tr>
	              </thead>
	              <tbody>
		              <?php foreach($media->getMedia() as $item) { ?>
		              <tr>
			              <td><a href="/<?php echo $item->path . '/' . $item->name; ?>" target="_blank"><?php echo $item->name; ?></a></td>
			              <td>Image</td>
			              <td><a href="#" class="btn">Verwijderen</a></td>
		              </tr>
		              <?php } ?>
	              </tbody>
              </table>
              <?php } ?>
        </div>