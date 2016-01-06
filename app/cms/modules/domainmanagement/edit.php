<div class='status'></div>
<?php
$Domain->indicator($_GET['id']);
$pageData = $Domain->domainData($_GET['id']);
if(isset($_POST['save'])){
    $Domain->inputFields($_POST);
    $Domain->verificate();
    
    if($Domain->getError() != NULL){
        $response = $Domain->getError();
    }
    if($Domain->getMSG() != NULL){
        $response = $Domain->getMSG();
        echo '<script type="text/javascript">window.location.href = "index.php?page=cms&module=domainmanagement";</script>';
    }
}
?>
<form method='post'><input class='btn' type='submit' name='save' value='Opslaan'> <a href='/index.php?page=cms&module=domainmanagement' class='btn'>Annuleren</a>
    <?php echo '<div class="msg">'.$response."</div>";?>
    <ul>
        <li>Naam:</i>
        <li><input type='text' name='name' value='<?php echo $pageData->name?>'></li>
        <li>URL:</li>
        <li><input type='text' name='url' value='<?php echo $pageData->url?>'></li>
    </ul>