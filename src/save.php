<?php

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2006, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

require('../../config.php');
include('info.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

// bisherige Konfiguration ermitteln
$settings = array();
$query_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");
if($query_content->numRows() > 0)
{
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