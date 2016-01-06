
<div class="leftheader">
  <?php
  $items = array();
  $items['page'] = 'cms';
  $items['orders'] = 'cms';
  $items['media'] = 'cms';
  $items['users'] = 'cms';
  $items['domainmanagement'] = 'cms';
  
  foreach($items as $modules => $value){
    if($_GET['module'] == $modules){
      $items[$modules] = 'cmsactive';
    }
  }
  
  ?>
  <table class="cms">
    <tr>
      <td class="cmsuser"><p><?php echo $User->firstname()?></p><p class="cmsitalic cms">Administrator</p></td>
    </tr><tr>
      <td class="<?php echo $items['orders']?>"><a href="index.php?page=cms&module=orders" class="cms"><p>Order Systeem</p><p class="cmsitalic">Alles over de orders</p></a></td>
    </tr><tr>
      <td class="<?php echo $items['page']?>"><a href="index.php?page=cms&module=page" class="cms"><p>Pagina Beheer</p><p class="cmsitalic">Al het beheer van de pagina's</p></a></td>
    </tr><tr>
<<<<<<< HEAD
      <td class="<?php echo $items['media']?>"><a href="index.php?page=cms&module=media" class="cms"><p>Media Beheer</p><p class="cmsitalic">Al het beheer van foto's en video's</p></a></td>
=======
      <td class="cms"><a href="index.php?page=cms&module=mediamanagment" class="cms"><p>Media Beheer</p><p class="cmsitalic">Al het beheer van foto's en video's</p></a></td>
>>>>>>> origin/master
    </tr><tr>
      <td class="<?php echo $items['users']?>"><a href="index.php?page=cms&module=users" class="cms"><p>Gebruiker Beheer</p><p class="cmsitalic">Al het beheer van gebruikers</p></a></td>
    </tr>
    <tr>
      <td class="<?php echo $items['domainmanagement']?>"><a href="index.php?page=cms&module=domainmanagement" class="cms"><p>Domein Beheer</p><p class="cmsitalic">Al het beheer van de domeins</p></a></td>
    </tr>
    </tr><tr>
      <td class="cms"><a href="index.php?page=cms&module=product" class="cms"><p>Product Beheer</p><p class="cmsitalic">Al het beheer van producten</p></a></td>
    </tr>
    </tr><tr>
      <td class="cms"><a href="index.php?page=cms&module=category" class="cms"><p>Categorie Beheer</p><p class="cmsitalic">Al het beheer van alle categorieën</p></a></td>
    </tr>
  </table>
</div>

<?php
if(isset($_GET['module'])){
    if(file_exists('app/cms/modules/'.$_GET['module'].'.php')){
        include('app/cms/modules/'.$_GET['module'].'.php');
    }else{
        include('app/cms/404.php');
    }
}else{
?>
<div class="neworders">
      <p>Beste <?php echo $User->firstname()?>, er zijn <b>XX</b> nieuwe orders geplaatst!</p>
</div>
<?php
    
}?>