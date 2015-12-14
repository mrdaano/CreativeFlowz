<div class='neworders page'>
    <?php
        if(isset($_GET['action'])){
            $page = $_GET['action'];
            include('app/cms/modules/pagemanagement/'.$page.'.php');
        }else{
            include('app/cms/modules/pagemanagement/index.php');   
        }
    ?>
</div>