<div class='neworders page'>
	<h1>Users</h1>
    <?php
        if(isset($_GET['action'])){
            $page = $_GET['action'];
            include('app/cms/modules/users/'.$page.'.php');
        }else{
            include('app/cms/modules/users/index.php');   
        }
        setcookie("key","value", time()+3600);
    ?>
</div>