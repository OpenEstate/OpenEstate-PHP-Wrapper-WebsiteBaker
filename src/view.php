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

// get content from database
$query_content = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_$module_directory WHERE section_id = '$section_id'");
if ($query_content->numRows() <= 0) {
  echo $module_i18n['error_no_page_found'];
}
else {
  $fetch_content = $query_content->fetchRow();
  $WB_PATH = WB_PATH;
  $WB_URL = WB_URL;

  // load settings
  $settings = unserialize($fetch_content['wrapper_settings']);
  if (!is_array($settings)) {
    $settings = array();
  }
  load_default_immotool_settings($settings);

  // setup environment
  //echo '<pre>' . print_r($settings, true) . '</pre>';
  //echo '<pre>' . print_r($_REQUEST, true) . '</pre>';
  //echo '<pre>' . print_r($_SERVER, true) . '</pre>';
  define('IMMOTOOL_BASE_PATH', $settings['immotool_base_path']);
  define('IMMOTOOL_BASE_URL', $settings['immotool_base_url']);
  if (is_file(IMMOTOOL_BASE_PATH . 'immotool.php.lock')) {
    echo $module_i18n['error_update_is_running'];
  }
  else {

    // determine the script to load
    $wrap = (isset($_REQUEST['wrap']) && is_string($_REQUEST['wrap'])) ? $_REQUEST['wrap'] : $settings['immotool_wrap_script'];
    if ($wrap == 'expose') {
      $wrap = 'expose';
      $script = 'expose.php';

      // keep wrapper settings in a global variable for further use
      $GLOBALS['openestate_wrapper_settings'] = $settings['immotool_expose'];

      // set default configuration values on the first request of the page
      if (!isset($_REQUEST['wrap'])) {
        if (isset($settings['immotool_expose']['lang'])) {
          $_REQUEST[IMMOTOOL_PARAM_LANG] = $settings['immotool_expose']['lang'];
        }
        if (isset($settings['immotool_expose']['id'])) {
          $_REQUEST[IMMOTOOL_PARAM_EXPOSE_ID] = $settings['immotool_expose']['id'];
        }
        if (isset($settings['immotool_expose']['view'])) {
          $_REQUEST[IMMOTOOL_PARAM_EXPOSE_VIEW] = $settings['immotool_expose']['view'];
        }
      }
    }
    else {
      $wrap = 'index';
      $script = 'index.php';

      // keep wrapper settings in a global variable for further use
      $GLOBALS['openestate_wrapper_settings'] = $settings['immotool_index'];

      // set default configuration values on the first request of the page
      if (!isset($_REQUEST['wrap'])) {
        $_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER_CLEAR] = '1';
        if (isset($settings['immotool_index']['lang'])) {
          $_REQUEST[IMMOTOOL_PARAM_LANG] = $settings['immotool_index']['lang'];
        }
        if (isset($settings['immotool_index']['view'])) {
          $_REQUEST[IMMOTOOL_PARAM_INDEX_VIEW] = $settings['immotool_index']['view'];
        }
        if (isset($settings['immotool_index']['mode'])) {
          $_REQUEST[IMMOTOOL_PARAM_INDEX_MODE] = $settings['immotool_index']['mode'];
        }
        if (isset($settings['immotool_index']['order'])) {
          $_REQUEST[IMMOTOOL_PARAM_INDEX_ORDER] = $settings['immotool_index']['order'];
        }
      }

      // clear filter selections, if this is explicitly selected
      if (isset($_REQUEST[IMMOTOOL_PARAM_INDEX_RESET])) {
        unset($_REQUEST[IMMOTOOL_PARAM_INDEX_RESET]);
        $_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER] = array();
        $_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER_CLEAR] = '1';
      }

      // load configured filter criterias into the request
      if (!isset($_REQUEST['wrap']) || isset($_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER])) {
        $filters = $settings['immotool_index']['filter'];
        if (is_array($filters)) {
          foreach ($filters as $filter => $value) {
            if (!isset($_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER]) || !is_array($_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER])) {
              $_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER] = array();
            }
            if (!isset($_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER][$filter])) {
              $_REQUEST[IMMOTOOL_PARAM_INDEX_FILTER][$filter] = $value;
            }
          }
        }
      }
    }

    // execute the script
    //echo 'wrap: ' . IMMOTOOL_BASE_PATH . $script;
    ob_start();
    include( IMMOTOOL_BASE_PATH . $script );
    $page = ob_get_contents();
    ob_end_clean();

    // setup stylesheets for the generated output
    $setup = new immotool_setup();
    if (is_callable(array('immotool_myconfig', 'load_config_default'))) {
      immotool_myconfig::load_config_default($setup);
    }
    $stylesheets = array(IMMOTOOL_BASE_URL . 'style.php?wrapped=1');
    if (is_string($setup->AdditionalStylesheet) && strlen($setup->AdditionalStylesheet) > 0) {
      $stylesheets[] = $setup->AdditionalStylesheet;
    }

    // setup base URL and hidden parameters for the generated output
    $baseUrl = $_SERVER['SCRIPT_NAME'];
    $hiddenParams = array();
    if (isset($_REQUEST['pageid'])) {
      $baseUrl .= '?pageid=' . $_REQUEST['pageid'];
      $hiddenParams['pageid'] = $_REQUEST['pageid'];
    }

    // convert and return the script output
    echo immotool_functions::wrap_page($page, $wrap, $baseUrl, IMMOTOOL_BASE_URL, $stylesheets, $hiddenParams);
  }
}
