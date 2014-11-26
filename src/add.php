<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Eine neue Sektion hinzufügen.
 * $Id: add.php 2051 2013-02-12 07:50:03Z andy $
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

//this adds a new line in the database when you add your modul to a page
$database->query("INSERT INTO ".TABLE_PREFIX."mod_$module_directory (page_id,section_id) VALUES ('$page_id','$section_id')");
?>