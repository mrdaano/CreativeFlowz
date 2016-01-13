<?php 
if (!isset($_SESSION['_user']) || $_SESSION['_user']['userLevel'] == 1) {
  include 'app/pages/404.php';
} else { ?>
  <div class="leftheader">
    <table class="cms">
      <tr>
        <td class="cmsuser"><p><?php echo $User->firstname()?></p><p class="cmsitalic cms">Administrator</p></td>
      </tr><tr>
        <td class="cmsactive"><a href="index.php?page=customer&module=orders" class="cms"><p>Mijn Orders</p><p class="cmsitalic">Alles over de orders</p></a></td>
      </tr><tr>
        <td class="cmsactive"><a href="index.php?page=customer&module=accountsettings" class="cms"><p>Mijn gegevens</p><p class="cmsitalic">Gegevens inzien en wijzigen</p></a></td>
      </tr>
    </table>
  </div>
  <?php
  if(isset($_GET['module'])){
      if(file_exists('app/pages/module/'.$_GET['module'].'.php')){
          include('app/pages/module/'.$_GET['module'].'.php');
      }else{
          include('app/pages/404.php');
      }
  }else{
      ?>

      <?php
  }
}
?>