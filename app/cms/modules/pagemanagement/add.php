<?php
if(isset($_POST['save'])){
    $Page->inputFields($_POST);
    $Page->newPage();
    
    if($Page->getError() != NULL){
        $response = $Page->getError();
    }
    
    if($Page->getMSG() != NULL){
        $response = $Page->getMSG();
    }
}
?>
<a href='/index.php?page=cms&module=page'><button>Annuleren</button></a><form method='post'><input class='btn' type='submit' name='save' value='Opslaan'>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Naam:</i>
        <li><input type='text' name='name'></li>
        <li>Titel:</i>
        <li><input type='text' name='title'></li>
        <li>Key woorden:</li>
        <li><input type='text' name='keyword'></li>
    </ul>
    <br/>
    <hr>
    <br/>
    <textarea name="content" class='texteditor'></textarea>
</form>
    <script>
        CKEDITOR.replace( 'content' );
        CKEDITOR.editorConfig = function( config ) {
            config.language = 'nl';
            config.uiColor = '#F7B42C';
            config.height = 500;
            config.toolbarCanCollapse = true;
        };

    </script>