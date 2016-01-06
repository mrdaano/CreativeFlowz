<?php
if(isset($_POST['save'])){
    $Domain->inputFields($_POST);
    $Domain->newDomain();
    
    if($Domain->getError() != NULL){
        $response = $Domain->getError();
    }
    
    if($Domain->getMSG() != NULL){
        $response = $Domain->getMSG();
    }
}
?>
<form method='post'><input class='btn' type='submit' name='save' value='Opslaan'> <a class='btn' href='/index.php?page=cms&module=page'>Annuleren</a>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Naam: </i>
        <li><input type='text' name='name'></li>
        <li>URL:</i>
        <li><input type='text' name='url'></li>
    </ul>
</form>
