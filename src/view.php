<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Darstellung einer Sektion auf der Webseite.
 * $Id: view.php 1706 2012-08-15 14:47:38Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009-2012, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) {
  exit("Cannot access this file directly");
}
include('info.php');

//get content from database
$query_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");
if($query_content->numRows() <= 0) {
  echo $module_i18n['error_no_page_found'];
}
else {
  $fetch_content = $query_content->fetchRow();
  $WB_PATH = WB_PATH;
  $WB_URL = WB_URL;

  //load settings
  $settings = unserialize( $fetch_content['wrapper_settings'] );
  if (!is_array($settings)) $settings = array();
  load_default_immotool_settings( $settings );

  //print settings for debugging
  //echo '<pre>';
  //print_r( $settings );
  //echo '</pre>';

  // setup environment
  define( 'IMMOTOOL_BASE_PATH', $settings['immotool_base_path'] );  // Server-Pfad zu den ImmoTool-Skripten
  define( 'IMMOTOOL_BASE_URL', $settings['immotool_base_url'] );   // URL zu den ImmoTool-Skripten
  if (is_file(IMMOTOOL_BASE_PATH . 'immotool.php.lock')) {
    echo $module_i18n['error_update_is_running'];
  }
  else {
    // Script ermitteln
    $wrap = (isset($_REQUEST['wrap']) && is_string($_REQUEST['wrap']))? $_REQUEST['wrap']: $settings['immotool_wrap_script'];
    if ($wrap=='expose') {
      $wrap = 'expose';
      $script = 'expose.php';
      //echo '<pre>' . print_r($_REQUEST, true) . '</pre>'; return;

      // Standard-Konfigurationswerte beim ersten Aufruf setzen
      if (!isset($_REQUEST[ 'wrap' ])) {
        if (isset($settings['immotool_expose']['lang']))
          $_REQUEST[ IMMOTOOL_PARAM_LANG ] = $settings['immotool_expose']['lang'];
        if (isset($settings['immotool_expose']['id']))
          $_REQUEST[ IMMOTOOL_PARAM_EXPOSE_ID ] = $settings['immotool_expose']['id'];
        if (isset($settings['immotool_expose']['view']))
          $_REQUEST[ IMMOTOOL_PARAM_EXPOSE_VIEW ] = $settings['immotool_expose']['view'];
      }
    }
    else {
      $wrap = 'index';
      $script = 'index.php';
      //echo '<pre>' . print_r($_REQUEST, true) . '</pre>'; return;

      // Standard-Konfigurationswerte beim ersten Aufruf setzen
      if (!isset($_REQUEST[ 'wrap' ])) {
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER_CLEAR ] = '1';
        if (isset($settings['immotool_index']['lang']))
          $_REQUEST[ IMMOTOOL_PARAM_LANG ] = $settings['immotool_index']['lang'];
        if (isset($settings['immotool_index']['view']))
          $_REQUEST[ IMMOTOOL_PARAM_INDEX_VIEW ] = $settings['immotool_index']['view'];
        if (isset($settings['immotool_index']['mode']))
          $_REQUEST[ IMMOTOOL_PARAM_INDEX_MODE ] = $settings['immotool_index']['mode'];
        if (isset($settings['immotool_index']['order']))
          $_REQUEST[ IMMOTOOL_PARAM_INDEX_ORDER ] = $settings['immotool_index']['order'];
      }

      // Zurücksetzen der gewählten Filter
      if (isset($_REQUEST[IMMOTOOL_PARAM_INDEX_RESET])) {
        unset($_REQUEST[IMMOTOOL_PARAM_INDEX_RESET]);
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ] = array();
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER_CLEAR ] = '1';
      }

      // vorgegebene Filter-Kriterien mit der Anfrage zusammenführen
      if (!isset($_REQUEST[ 'wrap' ]) || isset($_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ])) {
        $filters = $settings['immotool_index']['filter'];
        if (is_array($filters)) {
          foreach ($filters as $filter=>$value) {
            if (!is_array($_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ])) {
              $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ] = array();
            }
            if (!isset($_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ][$filter])) {
              $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ][$filter] = $value;
            }
          }
        }
      }
    }

    // Script ausführen
    //echo 'wrap: ' . IMMOTOOL_BASE_PATH . $script;
    ob_start();
    include( IMMOTOOL_BASE_PATH . $script );
    $page = ob_get_contents();
    //ob_clean();
    ob_end_clean();

    // Stylesheets
    $setup = new immotool_setup();
    if (is_callable(array('immotool_myconfig', 'load_config_default'))) immotool_myconfig::load_config_default( $setup );
    $stylesheets = array( IMMOTOOL_BASE_URL . 'style.php' );
    if (is_string($setup->AdditionalStylesheet) && strlen($setup->AdditionalStylesheet)>0)
      $stylesheets[] = $setup->AdditionalStylesheet;

    // Ausgabe erzeugen
    $baseUrl = $_SERVER['SCRIPT_NAME'];
    $hiddenParams = array();
    if (isset($_REQUEST['pageid'])) {
      $baseUrl .= '?pageid='.$_REQUEST['pageid'];
      $hiddenParams['pageid'] = $_REQUEST['pageid'];
    }
    echo immotool_functions::wrap_page( $page, $wrap, $baseUrl, IMMOTOOL_BASE_URL, $stylesheets, $hiddenParams );
  }
}
?>