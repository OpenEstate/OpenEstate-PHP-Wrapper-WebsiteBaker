<?php
/**
 * PHP-Wrapper für WebsiteBaker.
 * Sprachdatei, deutsch.
 * $Id: DE.php 52 2010-03-25 02:53:26Z andy $
 *
 * @author Andreas Rudolph & Walter Wagner
 * @copyright 2009, OpenEstate.org
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

$i18n = array();

// Allgemein
$i18n['description'] = 'Dieses Modul integriert PHP-Immobilienexporte aus dem OpenEstate-ImmoTool in WebsiteBaker.';
$i18n['setup'] = 'Anbindung der ImmoTool-Skripte';
$i18n['view'] = 'Darstellung auf der Webseite';

// Infobox
$i18n['info_module'] = 'Modul';
$i18n['info_version'] = 'version';
$i18n['info_license'] = 'Lizenz';
$i18n['info_authors'] = 'Autoren';
$i18n['info_support_us'] = 'Unterstützung';

// Anbindung
$i18n['setup_validate'] = 'Prüfung der Anbindung';
$i18n['setup_success'] = 'Die ImmoTool-Skripte sind korrekt eingebunden!';
$i18n['setup_problem'] = 'Die ImmoTool-Skripte sind NICHT korrekt eingebunden!';
$i18n['setup_errors'] = 'Fehlermeldungen';
$i18n['setup_step_export'] = 'Führen Sie einen PHP-Export via ImmoTool auf diesen Webspace durch.';
$i18n['setup_step_config'] = 'Tragen Sie den Pfad und URL des Exportes ein und klicken Sie zur erneuten Prüfung auf \'Speichern\'.';
$i18n['setup_path'] = 'Pfad zum ImmoTool-Export';
$i18n['setup_path_info'] = 'Tragen Sie hier den Pfad des Servers ein, wo die vom ImmoTool erzeugten Skripte abgelegt wurden. Der Serverpfad dieser CMS-Installation lautet:';
$i18n['setup_url'] = 'URL zum ImmoTool-Export';
$i18n['setup_url_info'] = 'Tragen Sie hier die Webadresse ein, über welche der ImmoTool-Export aus dem Internet erreichbar ist. Die Webadresse dieser CMS-Installation lautet:';

// Immobilienübersicht
$i18n['view_index'] = 'Immobilienübersicht / index.php';
$i18n['view_index_view'] = 'Ansicht';
$i18n['view_index_view_summary'] = 'Immobilienübersicht';
$i18n['view_index_view_fav'] = 'Vormerkliste';
$i18n['view_index_mode'] = 'Darstellung';
$i18n['view_index_mode_entry'] = 'als Liste';
$i18n['view_index_mode_gallery'] = 'als Galerie';
$i18n['view_index_language'] = 'Sprache';
$i18n['view_index_order'] = 'Sortierung';
$i18n['view_index_order_asc'] = 'aufsteigend';
$i18n['view_index_order_desc'] = 'absteigend';
$i18n['view_index_filter'] = 'Filterkriterium';

// Exposéansicht
$i18n['view_expose'] = 'Exposéansicht / expose.php';
$i18n['view_expose_id'] = 'ID der Immobilie';
$i18n['view_expose_view'] = 'Ansicht';
$i18n['view_expose_view_details'] = 'Details';
$i18n['view_expose_view_texts'] = 'Beschreibung';
$i18n['view_expose_view_gallery'] = 'Galerie';
$i18n['view_expose_view_contact'] = 'Kontakt';
$i18n['view_expose_view_terms'] = 'AGB';
$i18n['view_expose_language'] = 'Sprache';

// Fehler
$i18n['error_no_page_found'] = 'Kein darstellbarer Seiteninhalt gefunden!';
$i18n['error_no_export_path'] = 'Bitte tragen Sie einen gültigen Export-Pfad ein!';
$i18n['error_no_export_file_found'] = 'Die Datei \'%s\' befindet sich nicht im Export-Pfad!';
$i18n['error_no_export_version_found'] = 'Die Skript-Version konnte nicht ermittelt werden!';
$i18n['error_no_translation_found'] = 'Übersetzung kann nicht ermittelt werden!';

return $i18n;
?>