<div class="leftheader">
  <table class="cms">
    <tr>
      <td class="cmsuser"><p><?php echo $User->firstname()?></p><p class="cmsitalic cms">Administrator</p></td>
    </tr><tr>
      <td class="cmsactive"><a href="index.php?page=customer&module=orders" class="cms"><p>Mijn Orders</p><p class="cmsitalic">Alles over de orders</p></a></td>
    </tr>
  </table>
</div>
<?php
if(isset($_GET['module'])){
    if(file_exists('app/pages/modules/'.$_GET['module'].'.php')){
        include('app/pages/modules/'.$_GET['module'].'.php');
    }else{
        include('app/pages/404.php');
    }
}else{
    ?>

    <?php
}
?>