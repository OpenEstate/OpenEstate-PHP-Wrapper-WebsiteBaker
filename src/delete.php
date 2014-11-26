<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Eine bestehende Sektion entfernen.
 * $Id: delete.php 2051 2013-02-12 07:50:03Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009-2013, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) {
  exit("Cannot access this file directly");
}
include('info.php');

//this deletes the entrie in the database, when you delete your modul from a page
$database->query("DELETE FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");
?>