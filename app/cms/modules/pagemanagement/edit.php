<div class='status'></div>
<?php
unset($pageData);
$Page->indicator($_GET['id']);
$pageData = $Page->pageData($_GET['id']);
if(isset($_POST['save'])){
    $Page->inputFields($_POST);
    $Page->verificate();
    
    if($Page->getError() != NULL){
        $response = $Page->getError();
    }
    if($Page->getMSG() != NULL){
        $response = $Page->getMSG();
        echo '<script type="text/javascript">window.location.href = "index.php?page=cms&module=page";</script>';
    }
}
?>
<a href='/index.php?page=cms&module=page'><button>Annuleren</button></a><form method='post'><input class='btn' type='submit' name='save' value='Opslaan'> <?=$Page->isHomepage()?>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Titel:</i>
        <li><input type='text' name='title' value='<?php echo $pageData->title?>'></li>
        <li>Key woorden:</li>
        <li><input type='text' name='keyword' value='<?php echo $pageData->keyword?>'></li>
    </ul>
    <br/>
    <hr>
    <br/>
    <textarea name="content" class='texteditor'><?php echo $pageData->content?></textarea>
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