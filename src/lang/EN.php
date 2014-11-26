<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Sprachdatei, englisch.
 * $Id: EN.php 52 2010-03-25 02:53:26Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

$i18n = array();

// Allgemein
$i18n['description'] = 'This module integrates PHP-exported properties from OpenEstate-ImmoTool into WebsiteBaker.';
$i18n['setup'] = 'Configure exported scripts';
$i18n['view'] = 'Configure generated view';

// Infobox
$i18n['info_module'] = 'Module';
$i18n['info_version'] = 'version';
$i18n['info_license'] = 'License';
$i18n['info_authors'] = 'Authors';
$i18n['info_support_us'] = 'Support us!';

// Anbindung
$i18n['setup_validate'] = 'Validate configuration';
$i18n['setup_success'] = 'The exported scripts are correctly configured!';
$i18n['setup_problem'] = 'The exported scripts are NOT correctly configured!';
$i18n['setup_errors'] = 'Error messages';
$i18n['setup_step_export'] = 'Export your properties from ImmoTool to your website via PHP.';
$i18n['setup_step_config'] = 'Configure path and URL, that points to the exported scripts, and click \'Save\' to perform a new validation.';
$i18n['setup_path'] = 'Path to exported scripts';
$i18n['setup_path_info'] = 'Enter the path on your server, that points to the exported scripts. The path of this CMS installation is:';
$i18n['setup_url'] = 'URL of exported scripts';
$i18n['setup_url_info'] = 'Enter the URL on your server, that points to the exported scripts. The URL of this CMS installation is:';

// Immobilienübersicht
$i18n['view_index'] = 'Property listing / index.php';
$i18n['view_index_view'] = 'View';
$i18n['view_index_view_summary'] = 'Summary';
$i18n['view_index_view_fav'] = 'Favourites';
$i18n['view_index_mode'] = 'Mode';
$i18n['view_index_mode_entry'] = 'Tabular mode';
$i18n['view_index_mode_gallery'] = 'Gallery mode';
$i18n['view_index_language'] = 'Language';
$i18n['view_index_order'] = 'Order';
$i18n['view_index_order_asc'] = 'ascending';
$i18n['view_index_order_desc'] = 'descending';
$i18n['view_index_filter'] = 'Filter';

// Exposéansicht
$i18n['view_expose'] = 'Property details / expose.php';
$i18n['view_expose_id'] = 'Property ID';
$i18n['view_expose_view'] = 'View';
$i18n['view_expose_view_details'] = 'Details';
$i18n['view_expose_view_texts'] = 'Description';
$i18n['view_expose_view_gallery'] = 'Gallery';
$i18n['view_expose_view_contact'] = 'Contact';
$i18n['view_expose_view_terms'] = 'Terms';
$i18n['view_expose_language'] = 'Language';

// Fehler
$i18n['error_no_page_found'] = 'Page content not found!';
$i18n['error_no_export_path'] = 'Please enter a valid script path!';
$i18n['error_no_export_file_found'] = 'The file \'%s\' was not found in the script path!';
$i18n['error_no_export_version_found'] = 'Can\'t load the script version!';
$i18n['error_no_translation_found'] = 'Can\'t find translation!';

return $i18n;
?>