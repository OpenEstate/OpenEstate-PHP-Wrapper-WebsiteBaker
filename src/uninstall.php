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

// delete search table entries
$database->query("DELETE FROM " . TABLE_PREFIX . "search WHERE name = 'module' AND value = '$module_directory'");
$database->query("DELETE FROM " . TABLE_PREFIX . "search WHERE extra = '$module_directory'");

// delete the module directory
$database->query("DROP TABLE " . TABLE_PREFIX . "mod_$module_directory");
