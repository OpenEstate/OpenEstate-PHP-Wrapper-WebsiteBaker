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

// this contians vars that deal with the mod!
$module_directory = 'openestate_php_wrapper';		// this becomes the name of the directory created
$module_name = 'OpenEstate PHP-Wrapper';	// this becomes the name of the modul
$module_function = 'page';				// defines that the module is to be used as an option when creating an page, needed for WB versions since 2.6.x
$module_version = '0.2';				// Give your modul an version number 
$module_platform = '2.6.x';				//Say for what vesion you have designed the modul, this line is needed for WB versions since 2.6.x
$module_author = 'Andreas Rudolph, Walter Wagner';	//Say who has worked on this modul
$module_license = 'GNU General Public License version 3';			//Say under what license the modul is released
$module_description = 'This module integrates PHP-exported properties from OpenEstate-ImmoTool into WB';		//Give a short descreption what the modul does

// ALL OTHER PROJECT VARS SHOULD GO BELOW THIS LINE....

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

/**
 * Standard-Konfiguration erzeugen.
 */
if (!function_exists('load_default_immotool_settings'))
{
  function load_default_immotool_settings( &$settings )
  {
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
      
    if (!isset($settings['immotool_index']['order']) || !is_string($settings['immotool_index']['order']))
      $settings['immotool_index']['order'] = 'id-asc';
      
    if (!isset($settings['immotool_index']['filter']) || !is_array($settings['immotool_index']['filter']))
      $settings['immotool_index']['filter'] = array();    
      
    if (!isset($settings['immotool_expose']) || !is_array($settings['immotool_expose']))
      $settings['immotool_expose'] = array();
  }
}
?>