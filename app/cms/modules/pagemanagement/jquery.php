<?php
if(isset($_POST['formid']) && $_POST['formid'] == 1){
    // Include de database 
    
    echo 'Toegevoegd: '.$_POST['data'];
    
    // Database insert
    
    die();
}
?>