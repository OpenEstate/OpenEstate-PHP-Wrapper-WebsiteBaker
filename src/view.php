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

// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) { exit("Cannot access this file directly"); }
include('info.php');

//if you create a modul, the script should be here in the view.php

//get content from database
$query_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");

if($query_content->numRows() > 0)
{
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

  // Script ermitteln
  $wrap = (isset($_REQUEST['wrap']) && is_string($_REQUEST['wrap']))? $_REQUEST['wrap']: $settings['immotool_wrap_script'];
  if ($wrap=='expose') 
  {
    $wrap = 'expose';
    $script = 'expose.php';
    
    // Standard-Parameter ggf. setzen
    //echo '<pre>';
    //print_r($_REQUEST);
    //echo '</pre>';
    $params = array( 'wrap', IMMOTOOL_PARAM_LANG, IMMOTOOL_PARAM_EXPOSE_ID, IMMOTOOL_PARAM_EXPOSE_VIEW );
    $useDefaultParams = true;
    foreach ($params as $param)
    {
      if (isset($_REQUEST[ $param ]))
      {
        $useDefaultParams = false;
        break;
      }
    }
    if ($useDefaultParams)
    {
      if (isset($settings['immotool_expose']['lang']))
        $_REQUEST[ IMMOTOOL_PARAM_LANG ] = $settings['immotool_expose']['lang'];
      if (isset($settings['immotool_expose']['id']))
        $_REQUEST[ IMMOTOOL_PARAM_EXPOSE_ID ] = $settings['immotool_expose']['id'];
      if (isset($settings['immotool_expose']['view']))
        $_REQUEST[ IMMOTOOL_PARAM_EXPOSE_VIEW ] = $settings['immotool_expose']['view'];
    }
  }
  else
  {
    $wrap = 'index';
    $script = 'index.php';
    
    // Standard-Parameter ggf. setzen
    //echo '<pre>';
    //print_r($_REQUEST);
    //echo '</pre>';
    $params = array( 'wrap', IMMOTOOL_PARAM_LANG, IMMOTOOL_PARAM_INDEX_VIEW, IMMOTOOL_PARAM_INDEX_ORDER, IMMOTOOL_PARAM_INDEX_FILTER );
    $useDefaultParams = true;
    foreach ($params as $param)
    {
      if (isset($_REQUEST[ $param ]))
      {
        $useDefaultParams = false;
        break;
      }
    }
    if ($useDefaultParams)
    {
      if (isset($settings['immotool_index']['lang']))
        $_REQUEST[ IMMOTOOL_PARAM_LANG ] = $settings['immotool_index']['lang'];
      if (isset($settings['immotool_index']['view']))
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_VIEW ] = $settings['immotool_index']['view'];
      if (isset($settings['immotool_index']['order']))
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_ORDER ] = $settings['immotool_index']['order'];
      if (isset($settings['immotool_index']['filter']))
        $_REQUEST[ IMMOTOOL_PARAM_INDEX_FILTER ] = $settings['immotool_index']['filter'];
    }
  }

  // Script ausführen
  //echo 'wrap: ' . IMMOTOOL_BASE_PATH . $script;
  ob_start();
  include( IMMOTOOL_BASE_PATH . $script );
  $page = ob_get_contents(); 
  ob_clean();

  // Stylesheets
  $setup = new immotool_setup();
  if (is_callable(array('immotool_myconfig', 'load_config_default'))) immotool_myconfig::load_config_default( $setup );
  $stylesheets = array( IMMOTOOL_BASE_URL . 'style.php' );
  if (is_string($setup->AdditionalStylesheet) && strlen($setup->AdditionalStylesheet)>0) 
    $stylesheets[] = $setup->AdditionalStylesheet;

  // Ausgabe erzeugen
  echo immotool_functions::wrap_page( $page, $wrap, $_SERVER['SCRIPT_NAME'], IMMOTOOL_BASE_URL, $stylesheets );	
}
else
{ 
	echo "Page content not found"; 
}
?>