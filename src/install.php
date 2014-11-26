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

if (defined('WB_PATH') == false) {
  exit("Cannot access this file directly");
}
include('info.php');

// create table
global $database;
$database->query("DROP TABLE IF EXISTS `" . TABLE_PREFIX . "mod_" . $module_directory . "`");
$mod_create_table = 'CREATE TABLE `' . TABLE_PREFIX . 'mod_' . $module_directory . '` ( '
    . '`section_id` INT NOT NULL DEFAULT \'0\' ,'
    . '`page_id` INT NOT NULL DEFAULT \'0\','
    . '`wrapper_settings` TEXT NOT NULL DEFAULT \'\' ,'
    . 'PRIMARY KEY (section_id)'
    . ' )';
$database->query($mod_create_table);

// insert module informations into the search table
$field_info = array();
$field_info['page_id'] = 'page_id';
$field_info['title'] = 'page_title';
$field_info['link'] = 'link';
$field_info['description'] = 'description';
$field_info['modified_when'] = 'modified_when';
$field_info['modified_by'] = 'modified_by';
$field_info_value = serialize($field_info);
$database->query("INSERT INTO " . TABLE_PREFIX . "search (name,value,extra) VALUES ('module', '$module_directory', '$field_info_value')");
// query start
$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title,	[TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by	FROM [TP]mod_$module_directory, [TP]pages WHERE ";
$database->query("INSERT INTO " . TABLE_PREFIX . "search (name,value,extra) VALUES ('query_start', '$query_start_code', '$module_directory')");
// query body
$query_body_code = " [TP]pages.page_id = [TP]mod_$module_directory.page_id AND [TP]mod_$module_directory.simple_output [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";
$database->query("INSERT INTO " . TABLE_PREFIX . "search (name,value,extra) VALUES ('query_body', '$query_body_code', '$module_directory')");
// query end
$query_end_code = "";
$database->query("INSERT INTO " . TABLE_PREFIX . "search (name,value,extra) VALUES ('query_end', '$query_end_code', '$module_directory')");

// insert blank row (there needs to be at least on row for the search to work)
$database->query("INSERT INTO " . TABLE_PREFIX . "mod_$module_directory (page_id,section_id) VALUES ('0','0')");
