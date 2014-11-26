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

//get infos from the Database
$query_page_content = $database->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '$page_id'");
$fetch_page_content = $query_page_content->fetchRow();
$page_created = $fetch_page_content['link'];

$query_page_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_$module_directory WHERE section_id = '$section_id'");
$fetch_page_content = $query_page_content->fetchRow();

//load settings
$settings = unserialize( $fetch_page_content['wrapper_settings'] );
if (!is_array($settings)) $settings = array();
load_default_immotool_settings( $settings );

// ImmoTool-Umgebung einbinden
$environmentErrors = array();
$environmentFiles = array( 'config.php', 'include/functions.php', 'data/language.php' );
if (!is_dir($settings['immotool_base_path']))
{
  $environmentErrors[] = 'Bitte tragen Sie einen gültigen Export-Pfad ein!';
}
else
{
  define('IMMOTOOL_BASE_PATH', $settings['immotool_base_path']);
  foreach ($environmentFiles as $file)
  {
    if (!is_file(IMMOTOOL_BASE_PATH.$file))
      $environmentErrors[] = 'Die Datei \''.$file.'\' befindet sich nicht im Export-Pfad!';
  }
  if (count($environmentErrors)==0)
  {
    define('IN_WEBSITE', 1);
    foreach ($environmentFiles as $file)
    {
      //echo IMMOTOOL_BASE_PATH . $file . '<hr/>';
      include(IMMOTOOL_BASE_PATH.$file);
    }
    if (!defined('IMMOTOOL_SCRIPT_VERSION'))
      $environmentErrors[] = 'Die Skript-Version konnte nicht ermittelt werden!';
  }
}
$environmentIsValid = count($environmentErrors)==0;
?>

<script language="JavaScript">
<!--
function show_wrapper_settings( $value )
{
  document.getElementById( 'immotool_wrap_script_index_settings' ).style.visibility = ($value=='index')? 'visible': 'collapse';
  document.getElementById( 'immotool_wrap_script_expose_settings' ).style.visibility = ($value=='expose')? 'visible': 'collapse';
}
//-->
</script>

<div style="float:right; width:175px; background-color: #F0F0F0; padding:3px 5px 3px 5px;">
  <h2>Modul</h2>
  <div style="text-align:center;">
    <?php echo $module_name; ?><br/>
    version <?php echo $module_version; ?>
  </div>
  <h2>Lizenz</h2>
  <div style="text-align:center;">
    <a href="<?php echo WB_URL ?>/modules/openestate_php_wrapper/gpl-3.0-standalone.html" target="_blank"><?php echo $module_license; ?></a>
  </div>
  <h2>Autoren</h2>
  <div style="text-align:center;">
    <a href="http://www.openestate.org/" target="_blank">
      <img src="<?php echo WB_URL ?>/modules/openestate_php_wrapper/openestate.png" border="0" alt="0" />
      <div style="margin-top:0.5em;"><?php echo $module_author; ?></div>
    </a>
  </div>
  <h2>Unterst&uuml;tzung</h2>
  <div style="text-align:center;">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="11005790">
      <input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
      <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
</div>

<div style="margin-right:220px;">
<form name="edit" action="<?php echo WB_URL; ?>/modules/<?php echo $module_directory ?>/save.php" method="post" style="margin: 0;">

<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">

<h2>Anbindung der ImmoTool-Skripte</h2>
<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Prüfung der Anbindung</td>
	  <td style="padding-bottom:0.8em;">
			<?php
			  if ($environmentIsValid)
			  {
			    echo '<h3 style="color:green; margin:0;">Die ImmoTool-Skripte sind korrekt eingebunden!<br/><span style="font-size:0.7em;">version ' . IMMOTOOL_SCRIPT_VERSION . '</span></h3>';
			  }
			  else
			  {
			    echo '<h3 style="color:red; margin-top:0;">Die ImmoTool-Skripte sind NICHT korrekt eingebunden.</h3>';
			    echo '<ul>';
			    echo '<li style="color:red;">&raquo; Führen Sie einen PHP-Export via ImmoTool auf diesen Webspace durch.</li>';
			    echo '<li style="color:red;">&raquo; Tragen Sie den Pfad des Exportes ein und klicken Sie zur erneuten Prüfung auf \'Speichern\'.</li>';
          echo '</ul>';
          echo '<h3 style="color:red;">Fehlermeldungen</h3>';
          echo '<ul>';
          foreach ($environmentErrors as $error) echo '<li style="color:red;">&raquo; ' . $error . '</li>';
          echo '</ul>';
			  }
			?>
	  </td>
	</tr>
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Pfad zum ImmoTool-Export</td>
	  <td style="padding-bottom:0.8em;">
			<input name="immotool_base_path" type="text" value="<?php echo $settings['immotool_base_path']; ?>" style="width:100%;border:1px solid #c0c0c0;"><br/>
			<i style="font-size:0.9em;">
			  Tragen Sie hier den Pfad des Servers ein, wo die vom ImmoTool erzeugten Skripte abgelegt wurden.
			  Der Serverpfad dieser CMS-Installation lautet: <?php echo '<b>'.WB_PATH.'</b>'; ?>
	  	</i>	  
	  </td>
	</tr>
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">URL zum ImmoTool-Export</td>
	  <td style="padding-bottom:0.8em;">
			<input name="immotool_base_url" type="text" value="<?php echo $settings['immotool_base_url']; ?>" style="width:100%;border:1px solid #c0c0c0;"><br/>
			<i style="font-size:0.9em;">
			  Tragen Sie hier die Webadresse ein, über welche der ImmoTool-Export aus dem Internet erreichbar ist.
			  Die Webadresse dieser CMS-Installation lautet: <?php echo '<b>'.WB_URL.'</b>'; ?>
	  	</i>	  
	  </td>
	</tr>
</table>

<?php

// Wenn eine gültige ImmoTool-Umgebung konfiguriert ist, können weitere Einstellungen vorgenommen werden
$translations = null;
$lang = null;
if ($environmentIsValid)
{
  $setupIndex = new immotool_setup_index();
  $setupExpose = new immotool_setup_expose();
  $translations = null;
  $lang = immotool_functions::init_language( $setupIndex->DefaultLanguage, $setupIndex->DefaultLanguage, $translations );
  if (!is_array($translations)) 
  {
    echo 'Übersetzung kann nicht ermittelt werden!<hr/>';
    $environmentIsValid = false;
  }
}
if ($environmentIsValid)
{
?>
<h2>Darstellung auf der Webseite</h2>
<h3>
  <input type="radio" id="immotool_wrap_script_index" name="immotool_wrap_script" value="index" onchange="show_wrapper_settings('index');" <?php echo ($settings['immotool_wrap_script']=='index')? 'checked="checked"': '' ?>/>
  <label for="immotool_wrap_script_index">Immobilienübersicht / index.php</label>
</h3>
<table cellpadding="0" cellspacing="0" border="0" id="immotool_wrap_script_index_settings" style="width:100%;visibility:<?php echo ($settings['immotool_wrap_script']=='index')? 'visible': 'collapse' ?>;">

	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Ansicht</td>
	  <td style="padding-bottom:0.8em;">
	    <select name="immotool_index[view]" style="border:1px solid #c0c0c0;">
	      <option value="index" <?php echo ($settings['immotool_index']['view']=='index')? 'selected="selected"': ''; ?>>Immobilienübersicht</option>
	      <option value="fav" <?php echo ($settings['immotool_index']['view']=='fav')? 'selected="selected"': ''; ?>>Vormerkliste</option>
	    </select>
	  </td>
	</tr>
	
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Sprache</td>
	  <td style="padding-bottom:0.8em;">
	    <select name="immotool_index[lang]" style="border:1px solid #c0c0c0;">
	      <?php
	      foreach (immotool_functions::get_language_codes() as $code)
	      {
	        $selected = ($settings['immotool_index']['lang']==$code)? 'selected="selected"': '';
	        echo '<option value="' . $code . '" ' . $selected . '>' . immotool_functions::get_language_name( $code ) . '</option>';
	      }
	      ?>
	    </select>
	  </td>
	</tr>

	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Sortierung</td>
	  <td style="padding-bottom:0.8em;">
	    <select name="immotool_index[order]" style="border:1px solid #c0c0c0;">
	      <?php
        $sortedOrders = array();
        $availableOrders = array();
        foreach ($setupIndex->OrderOptions as $key)
        {
          $orderObj = immotool_functions::get_order($key);
          //$by = $orderObj->getName();
          $by = $orderObj->getTitle( $translations, $lang );
        	$sortedOrders[$key] = $by;
        	$availableOrders[$key] = $orderObj;
        }
        asort($sortedOrders);    
      
        echo '<optgroup label="aufsteigend">';
        foreach ($sortedOrders as $key=>$by)
        {
          $orderObj = $availableOrders[$key];
          $o = $key . '-asc';
          $selected = ($settings['immotool_index']['order']==$o)? 'selected="selected"': '';
          echo '<option value="' . $o . '" ' . $selected . '>&uarr; ' . $by . ' &uarr;</option>';
        }
        echo '</optgroup>';
        echo '<optgroup label="absteigend">';
        foreach ($sortedOrders as $key=>$by)
        {
          $orderObj = $availableOrders[$key];
          $o = $key . '-desc';
          $selected = ($settings['immotool_index']['order']==$o)? 'selected="selected"': '';
          echo '<option value="' . $o . '" ' . $selected . '>&darr; ' . $by . ' &darr;</option>';
        }       
        echo '</optgroup>';
	      ?>
	    </select>
	  </td>
	</tr>
	
	<?php
  //foreach ($setupIndex->FilterOptions as $key)
	foreach (immotool_functions::list_available_filters() as $key)
	{
    $filterObj = immotool_functions::get_filter( $key );
    if (!is_object($filterObj)) 
    {
      //echo "Filter-Objekt $key nicht gefunden<hr/>";
      continue;
    }
    $filterValue = (isset($settings['immotool_index']['filter'][$key]))? $settings['immotool_index']['filter'][$key]: '';
    $filterWidget = $filterObj->getWidget( $filterValue, $lang, $translations, $setupIndex );
    if (!is_string($filterWidget) || strlen($filterWidget)==0) 
    {
      //echo "Filter-Widget $key nicht erzeugt<hr/>";
      continue;
    }
    $filterWidget = str_replace( '<select ', '<select style="border:1px solid #c0c0c0;" ', $filterWidget );
	  ?>
  	<tr valign="top">
      <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Filterkriterium<br/><span style="font-weight:normal;font-size:0.9em;"><?php echo $filterObj->getTitle( $translations, $lang ); ?></span></td>
      <td style="padding-bottom:0.8em;"><?php echo $filterWidget; ?></td>
    </tr>
    <?php	  
	}
	?>
</table>

<h3>
  <input type="radio" id="immotool_wrap_script_expose" name="immotool_wrap_script" value="expose" onchange="show_wrapper_settings('expose');" <?php echo ($settings['immotool_wrap_script']=='expose')? 'checked="checked"': '' ?>/>
  <label for="immotool_wrap_script_expose">Exposéansicht / expose.php</label>
</h3>
<table cellpadding="0" cellspacing="0" border="0" id="immotool_wrap_script_expose_settings" style="width:100%;visibility:<?php echo ($settings['immotool_wrap_script']=='expose')? 'visible': 'collapse' ?>;">
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">ID der Immobilie</td>
	  <td style="padding-bottom:0.8em;">
	    <input name="immotool_expose[id]" type="text" style="border:1px solid #c0c0c0;" maxlength="15" value="<?php echo (isset($settings['immotool_expose']['id']) && is_numeric($settings['immotool_expose']['id']))? $settings['immotool_expose']['id']: '' ?>"/>
	  </td>
	</tr>
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Ansicht des Exposés</td>
	  <td style="padding-bottom:0.8em;">
	    <select name="immotool_expose[view]" style="border:1px solid #c0c0c0;">
	      <option value="details" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view']=='details')? 'selected="selected"': ''; ?>>Details</option>
	      <option value="texts" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view']=='texts')? 'selected="selected"': ''; ?>>Beschreibung</option>
	      <option value="gallery" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view']=='gallery')? 'selected="selected"': ''; ?>>Galerie</option>
	      <option value="contact" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view']=='contact')? 'selected="selected"': ''; ?>>Kontakt</option>
	      <option value="terms" <?php echo (isset($settings['immotool_expose']['view']) && $settings['immotool_expose']['view']=='terms')? 'selected="selected"': ''; ?>>AGB</option>
	    </select>
	  </td>
	</tr>
	<tr valign="top">
	  <td style="width:20%; text-align:right; font-weight:bold; white-space:nowrap; padding-right:1em;">Sprache</td>
	  <td style="padding-bottom:0.8em;">
	    <select name="immotool_expose[lang]" style="border:1px solid #c0c0c0;">
	      <?php
	      foreach (immotool_functions::get_language_codes() as $code)
	      {
	        $selected = ($settings['immotool_expose']['lang']==$code)? 'selected="selected"': '';
	        echo '<option value="' . $code . '" ' . $selected . '>' . immotool_functions::get_language_name( $code ) . '</option>';
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
			<input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;"></form>
		</td>
		<td align="right">
			<input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/index.php'; return false;" style="width: 100px; margin-top: 5px;" />
		</td>
	</tr>
</table>