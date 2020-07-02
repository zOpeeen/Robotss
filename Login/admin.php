<?php
if(isset($_GET['admPass']))
{
    if($_GET['admPass'] == 'SENHA')
    {
        if($_GET['req'] == 'getInfos')
        {
            echo file_get_contents("userlist.ini");
        }
        if($_GET['req'] == 'write')
        {
            echo file_put_contents("userlist.ini", $_GET['data']);
        }
    }
}
?>