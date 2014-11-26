<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Eine bestehende Sektion aktualisieren.
 * $Id: save.php 2051 2013-02-12 07:50:03Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009-2013, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

require('../../config.php');
include('info.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

// bisherige Konfiguration ermitteln
$settings = array();
$query_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");
if($query_content->numRows() > 0) {
  $fetch_content = $query_content->fetchRow();
  $settings = unserialize( $fetch_content['wrapper_settings'] );
}

// Änderungen in die Konfiguration übernehmen
load_default_immotool_settings( $settings );
$settings['immotool_base_path'] = trim($admin->get_post('immotool_base_path'));
$settings['immotool_base_url'] = trim($admin->get_post('immotool_base_url'));
$settings['immotool_wrap_script'] = $admin->get_post('immotool_wrap_script');
$settings['immotool_index'] = $admin->get_post('immotool_index');
$settings['immotool_index']['filter'] = $admin->get_post(IMMOTOOL_PARAM_INDEX_FILTER);
$settings['immotool_expose'] = $admin->get_post('immotool_expose');

// Pfad muss ein '/' am Ende haben
$len = strlen($settings['immotool_base_path']);
if ($len>0 && $settings['immotool_base_path'][$len-1]!='/')
  $settings['immotool_base_path'] .= '/';

// URL muss ein '/' am Ende haben
$len = strlen($settings['immotool_base_url']);
if ($len>0 && $settings['immotool_base_url'][$len-1]!='/')
  $settings['immotool_base_url'] .= '/';

//echo '<pre>';
//print_r($settings);
//echo '</pre>';

// Einstellungen in die Datenbank übernehmen
$query = "UPDATE ".TABLE_PREFIX."mod_$module_directory SET "
        ." wrapper_settings = '" . serialize($settings) . "'";
$query .= " WHERE section_id = '$section_id'";
$database->query($query);

// Check if there is a database error, otherwise say successful
if($database->is_error()) {
  $admin->print_error($database->get_error(), $js_back);
} else {
  $admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer()
?>