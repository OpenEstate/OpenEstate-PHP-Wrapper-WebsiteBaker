<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Deinstallation des Moduls.
 * $Id: uninstall.php 902 2011-06-16 00:13:32Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009-2011, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) {
  exit("Cannot access this file directly");
}
include('info.php');

//Delete Search table entries
$database->query("DELETE FROM ".TABLE_PREFIX."search WHERE name = 'module' AND value = '$module_directory'");
$database->query("DELETE FROM ".TABLE_PREFIX."search WHERE extra = '$module_directory'");

//Delete the modul directory
$database->query("DROP TABLE ".TABLE_PREFIX."mod_$module_directory");
?>