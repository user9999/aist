<div class="content_body">
    <form method="get">
        <h2><?php echo $GLOBALS['dblang_sExtended'][$GLOBALS['userlanguage']]?></h2>
        <table class=extsearch>
            <tr>
                <td><?php echo $GLOBALS['dblang_brand'][$GLOBALS['userlanguage']]?></td>
                <td><input type="text" name="frm_asearch_brand" value="<?php echo $TEMPLATE['brand'] ?>"></td>
            </tr>
            <tr>
                <td><?php echo $GLOBALS['dblang_model'][$GLOBALS['userlanguage']]?></td>
                <td><input type="text" name="frm_asearch_model" value="<?php echo $TEMPLATE['model'] ?>"></td>
            </tr>
            <tr>
                <td><?php echo $GLOBALS['dblang_articul'][$GLOBALS['userlanguage']]?></td>
                <td><input type="text" name="frm_asearch_oem" value="<?php echo $TEMPLATE['oem'] ?>"></td>
            </tr>
            <tr>
                <td><?php echo $GLOBALS['dblang_manufacturer'][$GLOBALS['userlanguage']]?></td>
                <td><input type="text" name="frm_asearch_country" value="<?php echo $TEMPLATE['country'] ?>"></td>
            </tr>
            <tr>
                <td><?php echo $GLOBALS['dblang_pName'][$GLOBALS['userlanguage']]?></td>
                <td><input type="text" name="frm_asearch_description" value="<?php echo $TEMPLATE['description'] ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="button" value="Поиск" /></td>
            </tr>
        </table>
    </form>
</div>
