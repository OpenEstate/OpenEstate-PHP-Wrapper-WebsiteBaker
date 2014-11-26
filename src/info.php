<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Allgemeine Informationen & Einstellungen zum Modul.
 * $Id: info.php 2051 2013-02-12 07:50:03Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009-2013, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Informationen zum Modul
 */

// this becomes the name of the directory created
$module_directory = 'openestate_php_wrapper';

// this becomes the name of the module
$module_name = 'OpenEstate PHP-Wrapper';

// defines that the module is to be used as an option when creating an page, needed for WB versions since 2.6.x
$module_function = 'page';

// Give your module an version number
$module_version = '0.4.5';

// Say for what vesion you have designed the module, this line is needed for WB versions since 2.6.x
$module_platform = '2.6.x';

// Say who has worked on this module
$module_author = 'Andreas Rudolph, Walter Wagner';

// Say under what license the module is released
$module_license = 'GNU General Public License version 3';

// Give a short descreption what the module does
$module_description = 'This module integrates PHP-exported properties from OpenEstate-ImmoTool into WebsiteBaker.';


/**
 * Definition der zu verwendenden Parameter.
 */

if (!defined('IMMOTOOL_PARAM_LANG'))
  define('IMMOTOOL_PARAM_LANG', 'wrapped_lang');
if (!defined('IMMOTOOL_PARAM_FAV'))
  define('IMMOTOOL_PARAM_FAV', 'wrapped_fav');
if (!defined('IMMOTOOL_PARAM_INDEX_PAGE'))
  define('IMMOTOOL_PARAM_INDEX_PAGE', 'wrapped_page');
if (!defined('IMMOTOOL_PARAM_INDEX_RESET'))
  define('IMMOTOOL_PARAM_INDEX_RESET', 'wrapped_reset');
if (!defined('IMMOTOOL_PARAM_INDEX_ORDER'))
  define('IMMOTOOL_PARAM_INDEX_ORDER', 'wrapped_order');
if (!defined('IMMOTOOL_PARAM_INDEX_FILTER'))
  define('IMMOTOOL_PARAM_INDEX_FILTER', 'wrapped_filter');
if (!defined('IMMOTOOL_PARAM_INDEX_FILTER_CLEAR'))
  define('IMMOTOOL_PARAM_INDEX_FILTER_CLEAR', 'wrapped_clearFilters');
if (!defined('IMMOTOOL_PARAM_INDEX_VIEW'))
  define('IMMOTOOL_PARAM_INDEX_VIEW', 'wrapped_view');
if (!defined('IMMOTOOL_PARAM_INDEX_MODE'))
  define('IMMOTOOL_PARAM_INDEX_MODE', 'wrapped_mode');
if (!defined('IMMOTOOL_PARAM_EXPOSE_ID'))
  define('IMMOTOOL_PARAM_EXPOSE_ID', 'wrapped_id');
if (!defined('IMMOTOOL_PARAM_EXPOSE_VIEW'))
  define('IMMOTOOL_PARAM_EXPOSE_VIEW', 'wrapped_view');
if (!defined('IMMOTOOL_PARAM_EXPOSE_IMG'))
  define('IMMOTOOL_PARAM_EXPOSE_IMG', 'wrapped_img');
if (!defined('IMMOTOOL_PARAM_EXPOSE_CONTACT'))
  define('IMMOTOOL_PARAM_EXPOSE_CONTACT', 'wrapped_contact');
if (!defined('IMMOTOOL_PARAM_EXPOSE_CAPTCHA'))
  define('IMMOTOOL_PARAM_EXPOSE_CAPTCHA', 'wrapped_captchacode');
if (!defined('OPENESTATE_WRAPPER'))
  define('OPENESTATE_WRAPPER', '1');


/**
 * Standard-Konfiguration erzeugen.
 */

if (!function_exists('load_default_immotool_settings')) {
  function load_default_immotool_settings( &$settings ) {
    // Name des zu wrappenden Skriptes
    if (!isset($settings['immotool_wrap_script']) || !is_string($settings['immotool_wrap_script']))
      $settings['immotool_wrap_script'] = 'index';

    // Server-Pfad zu den ImmoTool-Skripten
    if (!isset($settings['immotool_base_path']) || !is_string($settings['immotool_base_path']))
      $settings['immotool_base_path'] = WB_PATH . '/media/immotool/';

    // URL zu den ImmoTool-Skripten
    if (!isset($settings['immotool_base_url']) || !is_string($settings['immotool_base_url']))
      $settings['immotool_base_url'] = WB_URL . '/media/immotool/';

    if (!isset($settings['immotool_index']) || !is_array($settings['immotool_index']))
      $settings['immotool_index'] = array();

    if (!isset($settings['immotool_index']['view']) || !is_string($settings['immotool_index']['view']))
      $settings['immotool_index']['view'] = 'index';

    if (!isset($settings['immotool_index']['mode']) || !is_string($settings['immotool_index']['mode']))
      $settings['immotool_index']['mode'] = 'entry';

    if (!isset($settings['immotool_index']['order']) || !is_string($settings['immotool_index']['order']))
      $settings['immotool_index']['order'] = 'id-asc';

    if (!isset($settings['immotool_index']['filter']) || !is_array($settings['immotool_index']['filter']))
      $settings['immotool_index']['filter'] = array();

    if (!isset($settings['immotool_expose']) || !is_array($settings['immotool_expose']))
      $settings['immotool_expose'] = array();
  }
}


/**
 * Übersetzungen zum Modul ermitteln
 */

$module_i18n = array();
foreach (array(LANGUAGE, DEFAULT_LANGUAGE, 'EN') as $lang) {
  $i18n_file = WB_PATH . '/modules/' . $module_directory . '/lang/' . $lang . '.php';
  if (!is_file($i18n_file)) continue;
  $module_i18n = include( $i18n_file );
  if (is_array($module_i18n)) break;
}
if (!is_array($module_i18n)) {
  echo 'Can\'t load module translation!<hr/>';
}
else {
  $module_description = $module_i18n['description'];
}
?>