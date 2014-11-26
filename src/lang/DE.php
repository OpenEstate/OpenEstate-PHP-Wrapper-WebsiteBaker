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

$i18n = array();

// Allgemein
$i18n['description'] = 'Dieses Modul integriert PHP-Immobilienexporte aus dem OpenEstate-ImmoTool in WebsiteBaker / BlackCat CMS / LEPTON CMS.';
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
$i18n['error_update_is_running'] = '<h3>Der Immobilienbestand wird momentan aktualisiert!</h3><p>Bitte besuchen Sie diese Seite in wenigen Minuten erneut.</p>';

return $i18n;
