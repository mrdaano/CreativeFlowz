<?php
if(isset($_POST['save'])){
    $Page->inputFields($_POST);
    $Page->newPage();
    
    foreach($_POST as $key => $value){
        $Cookie->__set($_POST[$key], $value);
    }
    
    if($Page->getError() != NULL){
        $response = $Page->getError();
    }
    
    if($Page->getMSG() != NULL){
        $response = $Page->getMSG();
    }
}
?>
<form method='post'><input class='btn' type='submit' name='save' value='Opslaan'> <a class='btn' href='/index.php?page=cms&module=page'>Annuleren</a>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Naam van de pagina: </i>
        <li><input type='text' name='name' value='<?=$_COOKIE['name']?>'></li>
        <li>Titel:</i>
        <li><input type='text' name='title' value='<?=$_COOKIE['title']?>'></li>
        <li>Key woorden:</li>
        <li><input type='text' name='keyword' value='<?=$_COOKIE['keyword']?>'></li>
        <li>Website:</li>
        <li><?php echo $Domain->returnDomains(false, 'domain');?></li>
    </ul>
    <br/>
    <hr>
    <br/>
    <textarea name="content" class='texteditor'><?=$_COOKIE['content']?></textarea>
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