<?php
/*
 * A WebsiteBaker module for the OpenEstate-PHP-Export
 * Copyright (C) 2010-2014 OpenEstate.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require('../../config.php');
include('info.php');

// include WB admin wrapper script
$update_when_modified = true; // tells script to update when this page was last updated
require(WB_PATH . '/modules/admin.php');

// load current page configuration
$settings = array();
$query_content = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_$module_directory WHERE section_id = '$section_id'");
if ($query_content->numRows() > 0) {
  $fetch_content = $query_content->fetchRow();
  $settings = unserialize($fetch_content['wrapper_settings']);
}

// put changes into configuration of the current page
load_default_immotool_settings($settings);
$settings['immotool_base_path'] = trim($admin->get_post('immotool_base_path'));
$settings['immotool_base_url'] = trim($admin->get_post('immotool_base_url'));
$settings['immotool_wrap_script'] = $admin->get_post('immotool_wrap_script');
$settings['immotool_index'] = $admin->get_post('immotool_index');
$settings['immotool_index']['filter'] = $admin->get_post(IMMOTOOL_PARAM_INDEX_FILTER);
$settings['immotool_expose'] = $admin->get_post('immotool_expose');

// make sure, that the path ends with an /
$len = strlen($settings['immotool_base_path']);
if ($len > 0 && $settings['immotool_base_path'][$len - 1] != '/') {
  $settings['immotool_base_path'] .= '/';
}

// make sure, that the URL ends with an /
$len = strlen($settings['immotool_base_url']);
if ($len > 0 && $settings['immotool_base_url'][$len - 1] != '/') {
  $settings['immotool_base_url'] .= '/';
}

//echo '<pre>' . print_r($settings, true) . '</pre>';

// save modified page configuration
$query = "UPDATE " . TABLE_PREFIX . "mod_$module_directory SET "
    . "wrapper_settings = '" . serialize($settings) . "' "
    . "WHERE section_id = '$section_id'";
$database->query($query);

// check if there is a database error, otherwise say successful
if ($database->is_error()) {
  $admin->print_error($database->get_error(), $js_back);
}
else {
  $admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
}

// print admin footer
$admin->print_footer();
