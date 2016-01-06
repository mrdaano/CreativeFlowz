<!--
@author: Yannick Berendsen
@date: 12-dec-2015
-->
<a href='index.php?page=cms&module=domainmanagement&action=add'><button>Toevoegen</button></a>
<table class='cms page' width='100%'>
    <tr>
        <td><b>Naam</b></td>
        <td><b>Domain</b></td>
        <td><b>Actie</b></td> 
    </tr>
    <?php
    foreach($Domain->getDomain() as $key => $domainData){
       ?>
        <tr>
            <td width='40%'>
                <?=$domainData->name?>
            </td>
            <td>
                <?=$domainData->url?>
            </td>
            <td>
                <a href='index.php?page=cms&module=domainmanagement&action=edit&id=<?=$domainData->id?>'><button>Aanpassen</button></a>
            </td>
        </tr>
        <?php
    }
    ?>
    
</table>