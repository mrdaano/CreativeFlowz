<!--
@author: Yannick Berendsen
@date: 12-dec-2015
-->
<a href='index.php?page=cms&module=page&action=add'><button>Toevoegen</button></a>
<table class='cms page' width='100%'>
    <tr>
        <td><b>Title</b></td>
        <td><b>Homepage</b></td>
        <td><b>Domain</b></td>
        <td><b>Actie</b></td> 
    </tr>
    <?php
    foreach($Page->getPage() as $key => $pageData){
       ?>
        <tr>
            <td width='40%'>
                <?=$pageData->title?>
            </td>
            <td>
                <?=$Page->checkHomePage($pageData->id)?>
            </td>
            <td>
                <?=$Page->getDomain($pageData->domain_id);?>
            </td>
            <td>
                <a href='index.php?page=cms&module=page&action=edit&id=<?=$pageData->id?>'><button>Aanpassen</button></a>
            </td>
        </tr>
        <?php
    }
    ?>
    
</table>