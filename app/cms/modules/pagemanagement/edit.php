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
<script type='text/javascript'>
    $(document).ready(function(){
        $('#mediaitems').hide();
    });
   
    function show(args) {
        $('#mediaitems').show();
        $('#showmedia').attr('onclick', 'hide()');
        console.log('Show');
    }
    
    function hide() {
        $('#mediaitems').hide();
        $('#showmedia').attr('onclick', 'show()');
        console.log('Hide');
    }
</script>
<form method='post'><input class='btn' type='submit' name='save' value='Opslaan'>
<a href='/index.php?page=cms&module=page' class='btn'>Annuleren</a>
    <h3>Pagina</h3>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Naam van de pagina:</i>
        <li><input type='text' name='name' value='<?php echo $pageData->name?>'></li>
        <li>Titel:</i>
        <li><input type='text' name='title' value='<?php echo $pageData->title?>'></li>
        <li>Key woorden:</li>
        <li><input type='text' name='keyword' value='<?php echo $pageData->keyword?>'></li>
        <li>Pagina als homepage</li>
        <li><?php echo $Page->isHomePage()?></li>
        <li>Pagina op een andere website zetten:</li>
        <li><?php echo $Domain->returnDomains(false, 'domain', $pageData->domain_id);?></li>
    </ul>
    <br/>
    <hr>
    <h3>Media <span id='showmedia' style='cursor: pointer;' onclick='show()'>[Show]</span></h3>
    <?php echo $Page->getPageMedia();?>
    <hr><br/>
    <h3>Content</h3>
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