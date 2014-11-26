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

// get infos from the database
$query_page_content = $database->query("SELECT * FROM " . TABLE_PREFIX . "pages WHERE page_id = '$page_id'");
$fetch_page_content = $query_page_content->fetchRow();
$page_created = $fetch_page_content['link'];

$query_page_content = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_$module_directory WHERE section_id = '$section_id'");
$fetch_page_content = $query_page_content->fetchRow();

// load settings
$settings = unserialize($fetch_page_content['wrapper_settings']);
if (!is_array($settings)) {
  $settings = array();
}
load_default_immotool_settings($settings);

// init script environment
$environmentErrors = array();
$environmentFiles = array('config.php', 'private.php', 'include/functions.php', 'data/language.php');
if (!is_dir($settings['immotool_base_path'])) {
  $environmentErrors[] = $module_i18n['error_no_export_path'];
}
else {
  define('IMMOTOOL_BASE_PATH', $settings['immotool_base_path']);
  foreach ($environmentFiles as $file) {
    if (!is_file(IMMOTOOL_BASE_PATH . $file)) {
      $environmentErrors[] = str_replace('%s', $file, $module_i18n['error_no_export_file_found']);
    }
  }
  if (count($environmentErrors) == 0) {
    define('IN_WEBSITE', 1);
    foreach ($environmentFiles as $file) {
      //echo IMMOTOOL_BASE_PATH . $file . '<hr/>';
      include(IMMOTOOL_BASE_PATH . $file);
    }
    if (!defined('IMMOTOOL_SCRIPT_VERSION')) {
      $environmentErrors[] = $module_i18n['error_no_export_version_found'];
    }
  }
}
$environmentIsValid = count($environmentErrors) == 0;
?>

<script language="JavaScript" type="text/javascript">
<!--
function show_wrapper_settings($value)
{
  document.getElementById('immotool_wrap_script_index_settings').style.visibility = ($value == 'index') ? 'visible' : 'collapse';
  document.getElementById('immotool_wrap_script_expose_settings').style.visibility = ($value == 'expose') ? 'visible' : 'collapse';
}
//-->
</script>

<div style="float:right; width:175px; background-color: #F0F0F0; padding:3px 5px 3px 5px;">
  <h2><?php echo $module_i18n['info_module']; ?></h2>
  <div style="text-align:center;">
    <?php echo $module_name . '<br/>' . $module_i18n['info_version'] . ' ' . $module_version; ?>
  </div>
  <h2><?php echo $module_i18n['info_license']; ?></h2>
  <div style="text-align:center;">
    <a href="<?php echo WB_URL ?>/modules/openestate_php_wrapper/gpl-3.0-standalone.html" target="_blank"><?php echo $module_license; ?></a>
  </div>
  <h2><?php echo $module_i18n['info_authors']; ?></h2>
  <div style="text-align:center;">
    <a href="http://openestate.org/" target="_blank">
      <img src="<?php echo WB_URL ?>/modules/openestate_php_wrapper/openestate.png" border="0" alt="0" />
      <div style="margin-top:0.5em;"><?php echo $module_author; ?></div>
    </a>
  </div>
  <h2><?php echo $module_i18n['info_support_us']; ?></h2>
  <div style="text-align:center;">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="11005790">
      <input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
      <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>

<form name="edit" action="<?php echo WB_URL; ?>/modules/<?php echo $module_directory ?>/save.php" method="post" style="margin: 0;">

  <div style="margin-right:220px;">
    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">

    <h2><?php echo $module_i18n['setup']; ?></h2>
    <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
      <tr valign="top">
        <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['setup_validate']; ?></td>
        <td style="padding-bottom:0.8em;">
          <?php
          if ($environmentIsValid) {
            echo '<h3 style="color:green; margin:0;">' .
            $module_i18n['setup_success'] . '<br/>' .
            '<span style="font-size:0.7em;">' . $module_i18n['info_version'] . ' ' . IMMOTOOL_SCRIPT_VERSION . '</span>' .
            '</h3>';
          }
          else {
            echo '<h3 style="color:red; margin-top:0;">' . $module_i18n['setup_problem'] . '</h3>';
            echo '<ul>';
            echo '<li style="color:red;">&raquo; ' . $module_i18n['setup_step_export'] . '</li>';
            echo '<li style="color:red;">&raquo; ' . $module_i18n['setup_step_config'] . '</li>';
            echo '</ul>';
            echo '<h3 style="color:red;">' . $module_i18n['setup_errors'] . '</h3>';
            echo '<ul>';
            foreach ($environmentErrors as $error) {
              echo '<li style="color:red;">&raquo; ' . $error . '</li>';
            }
            echo '</ul>';
          }
          ?>
        </td>
      </tr>
      <tr valign="top">
        <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['setup_path']; ?></td>
        <td style="padding-bottom:0.8em;">
          <input name="immotool_base_path" type="text" value="<?php echo $settings['immotool_base_path']; ?>" style="width:100%;border:1px solid #c0c0c0;"><br/>
          <i style="font-size:0.9em;"><?php echo $module_i18n['setup_path_info'] . '<br/><b>' . WB_PATH . '</b>'; ?></i>
        </td>
      </tr>
      <tr valign="top">
        <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['setup_url']; ?></td>
        <td style="padding-bottom:0.8em;">
          <input name="immotool_base_url" type="text" value="<?php echo $settings['immotool_base_url']; ?>" style="width:100%;border:1px solid #c0c0c0;"><br/>
          <i style="font-size:0.9em;"><?php echo $module_i18n['setup_url_info'] . '<br/><b>' . WB_URL . '</b>'; ?></i>
        </td>
      </tr>
    </table>
    <?php

    // show additional admin actions,
    // if the scripts of OpenEstate-PHP-Export were correctly loaded
    $translations = null;
    $lang = null;
    if ($environmentIsValid) {
      $setupIndex = new immotool_setup_index();
      //$setupExpose = new immotool_setup_expose();
      if (is_callable(array('immotool_functions', 'init_config'))) {
        immotool_functions::init_config($setupIndex, 'load_config_index');
        //immotool_functions::init_config($setupExpose, 'load_config_expose');
      }
      $translations = null;
      $lang = immotool_functions::init_language($setupIndex->DefaultLanguage, $setupIndex->DefaultLanguage, $translations);
      if (!is_array($translations)) {
        echo $module_i18n['error_no_translation_found'] . '<hr/>';
        $environmentIsValid = false;
      }
    }
    if ($environmentIsValid) {
      ?>
      <h2><?php echo $module_i18n['view']; ?></h2>
      <h3>
        <input type="radio" id="immotool_wrap_script_index" name="immotool_wrap_script" value="index" onchange="show_wrapper_settings('index');" <?php echo ($settings['immotool_wrap_script'] == 'index') ? 'checked="checked"' : '' ?>/>
        <label for="immotool_wrap_script_index"><?php echo $module_i18n['view_index']; ?></label>
      </h3>
      <table cellpadding="0" cellspacing="0" border="0" id="immotool_wrap_script_index_settings" style="width:100%;visibility:<?php echo ($settings['immotool_wrap_script'] == 'index') ? 'visible' : 'collapse' ?>;">

        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_index_view']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_index[view]" style="border:1px solid #c0c0c0;">
              <option value="index" <?php echo ($settings['immotool_index']['view'] == 'index') ? 'selected="selected"' : ''; ?>><?php echo $i18n['view_index_view_summary']; ?></option>
              <option value="fav" <?php echo ($settings['immotool_index']['view'] == 'fav') ? 'selected="selected"' : ''; ?>><?php echo $i18n['view_index_view_fav']; ?></option>
            </select>
          </td>
        </tr>

        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_index_mode']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_index[mode]" style="border:1px solid #c0c0c0;">
              <option value="entry" <?php echo ($settings['immotool_index']['mode'] == 'entry') ? 'selected="selected"' : ''; ?>><?php echo $i18n['view_index_mode_entry']; ?></option>
              <option value="gallery" <?php echo ($settings['immotool_index']['mode'] == 'gallery') ? 'selected="selected"' : ''; ?>><?php echo $i18n['view_index_mode_gallery']; ?></option>
            </select>
          </td>
        </tr>

        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_index_language']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_index[lang]" style="border:1px solid #c0c0c0;">
              <?php
              foreach (immotool_functions::get_language_codes() as $code) {
                $selected = ($settings['immotool_index']['lang'] == $code) ? 'selected="selected"' : '';
                echo '<option value="' . $code . '" ' . $selected . '>' . immotool_functions::get_language_name($code) . '</option>';
              }
              ?>
            </select>
          </td>
        </tr>

        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_index_order']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_index[order]" style="border:1px solid #c0c0c0;">
              <?php
              $sortedOrders = array();
              $availableOrders = array();
              $orderNames = array();

              // get all available order classes
              if (is_callable(array('immotool_functions', 'list_available_orders'))) {
                $orderNames = immotool_functions::list_available_orders();
              }

              // get explicitly enabled order classes
              // this mechanism is a fallback for older versions of the OpenEstate-PHP-Export,
              // that don't support immotool_functions::list_available_orders()
              else if (is_array($setupIndex->OrderOptions)) {
                $orderNames = $setupIndex->OrderOptions;
              }

              foreach ($orderNames as $key) {
                $orderObj = immotool_functions::get_order($key);
                $by = $orderObj->getTitle($translations, $lang);
                $sortedOrders[$key] = $by;
                $availableOrders[$key] = $orderObj;
              }
              asort($sortedOrders);

              echo '<optgroup label="' . $module_i18n['view_index_order_asc'] . '">';
              foreach ($sortedOrders as $key => $by) {
                $orderObj = $availableOrders[$key];
                $o = $key . '-asc';
                $selected = ($settings['immotool_index']['order'] == $o) ? 'selected="selected"' : '';
                echo '<option value="' . $o . '" ' . $selected . '>&uarr; ' . $by . ' &uarr;</option>';
              }
              echo '</optgroup>';
              echo '<optgroup label="' . $module_i18n['view_index_order_desc'] . '">';
              foreach ($sortedOrders as $key => $by) {
                $orderObj = $availableOrders[$key];
                $o = $key . '-desc';
                $selected = ($settings['immotool_index']['order'] == $o) ? 'selected="selected"' : '';
                echo '<option value="' . $o . '" ' . $selected . '>&darr; ' . $by . ' &darr;</option>';
              }
              echo '</optgroup>';
              ?>
          </select>
          </td>
        </tr>

        <?php
        foreach (immotool_functions::list_available_filters() as $key) {
          $filterObj = immotool_functions::get_filter($key);
          if (!is_object($filterObj)) {
            //echo "Can't find filter object $key<hr/>";
            continue;
          }
          $filterValue = (isset($settings['immotool_index']['filter'][$key])) ? $settings['immotool_index']['filter'][$key] : '';
          $filterWidget = $filterObj->getWidget($filterValue, $lang, $translations, $setupIndex);
          if (!is_string($filterWidget) || strlen($filterWidget) == 0) {
            //echo "Can't create widget for filter object $key<hr/>";
            continue;
          }
          $filterWidget = str_replace('<select ', '<select style="border:1px solid #c0c0c0;" ', $filterWidget);
          ?>
          <tr valign="top">
            <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_index_filter']; ?><br/><span style="font-weight:normal;font-size:0.9em;"><?php echo $filterObj->getTitle($translations, $lang); ?></span></td>
            <td style="padding-bottom:0.8em;"><?php echo $filterWidget; ?></td>
          </tr>
          <?php
        }
        ?>
      </table>

      <h3>
        <input type="radio" id="immotool_wrap_script_expose" name="immotool_wrap_script" value="expose" onchange="show_wrapper_settings('expose');" <?php echo ($settings['immotool_wrap_script'] == 'expose') ? 'checked="checked"' : '' ?>/>
        <label for="immotool_wrap_script_expose"><?php echo $module_i18n['view_expose']; ?></label>
      </h3>
      <table cellpadding="0" cellspacing="0" border="0" id="immotool_wrap_script_expose_settings" style="width:100%;visibility:<?php echo ($settings['immotool_wrap_script'] == 'expose') ? 'visible' : 'collapse' ?>;">
        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_expose_id']; ?></td>
          <td style="padding-bottom:0.8em;">
            <input name="immotool_expose[id]" type="text" style="border:1px solid #c0c0c0;" maxlength="15" value="<?php echo (isset($settings['immotool_expose']['id']) && is_numeric($settings['immotool_expose']['id'])) ? $settings['immotool_expose']['id'] : '' ?>"/>
          </td>
        </tr>
        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_expose_view']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_expose[view]" style="border:1px solid #c0c0c0;">
              <option value="details" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view'] == 'details') ? 'selected="selected"' : ''; ?>><?php echo $module_i18n['view_expose_view_details']; ?></option>
              <option value="texts" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view'] == 'texts') ? 'selected="selected"' : ''; ?>><?php echo $module_i18n['view_expose_view_texts']; ?></option>
              <option value="gallery" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view'] == 'gallery') ? 'selected="selected"' : ''; ?>><?php echo $module_i18n['view_expose_view_gallery']; ?></option>
              <option value="contact" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view'] == 'contact') ? 'selected="selected"' : ''; ?>><?php echo $module_i18n['view_expose_view_contact']; ?></option>
              <option value="terms" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view'] == 'terms') ? 'selected="selected"' : ''; ?>><?php echo $module_i18n['view_expose_view_terms']; ?></option>
            </select>
          </td>
        </tr>
        <tr valign="top">
          <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;"><?php echo $module_i18n['view_expose_language']; ?></td>
          <td style="padding-bottom:0.8em;">
            <select name="immotool_expose[lang]" style="border:1px solid #c0c0c0;">
              <?php
              foreach (immotool_functions::get_language_codes() as $code) {
                $selected = ($settings['immotool_expose']['lang'] == $code) ? 'selected="selected"' : '';
                echo '<option value="' . $code . '" ' . $selected . '>' . immotool_functions::get_language_name($code) . '</option>';
              }
              ?>
            </select>
          </td>
        </tr>
      </table>

      <?php
    }
    ?>
  </div>

  <table cellpadding="0" cellspacing="0" border="0" style="width:100%; clear:both;">
    <tr>
      <td align="left">
        <input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;">
      </td>
      <td align="right">
        <input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/index.php';
            return false;" style="width: 100px; margin-top: 5px;" />
      </td>
    </tr>
  </table>
</form>