OpenEstate-PHP-Wrapper for WebsiteBaker 0.5
===========================================

This module integrates [OpenEstate-PHP-Export](https://github.com/OpenEstate/OpenEstate-PHP-Export)
into a *WebsiteBaker* based website.


Description
-----------

### English

OpenEstate.org provides a freeware software - called *OpenEstate-ImmoTool* -
for small and medium sized real-estate-agencies all over the world.

As one certain feature of this software, the managed properties can be exported
to any website that supports PHP. Together with this module, the exported
properties can be easily integrated into a *WebsiteBaker* based website without
any frames.

### Deutsch

Im Rahmen des OpenEstate-Projektes wird unter Anderem eine kostenlose
Immobiliensoftware unter dem Namen *OpenEstate-ImmoTool* entwickelt. Gemeinsam
mit den Anwendern soll eine Softwarelösung für kleine bis mittelgroße
Immobilienunternehmen entwickelt werden.

Unter Anderem können die im *OpenEstate-ImmoTool* verwalteten Immobilien als
PHP-Skripte auf die eigene Webseite exportiert werden. Mit Hilfe dieses Moduls
kann dieser PHP-Export unkompliziert in eine auf *WebsiteBaker* basierende
Webseite integriert werden.


Changelog
---------

### 0.5

-   translated any source code comments into English
-   made some syntax fixes

### 0.4.5

-   Some smaller improvements.

### 0.4.4

-   Some smaller improvements.

### 0.4.3

-   Configured options of a properties page are not taken into account under
    certain conditions.
    (see [Forum](http://board.openestate.org/viewtopic.php?f=7&t=8698))
-   Provide all available order options in the administration page.
    (see [Forum](http://board.openestate.org/viewtopic.php?f=7&t=8763#p12562))

### 0.4.2

-   Reset filter selection, if a property page is accessed for the first time or
    if the website visitor jumps between multiple property pages.
    (see [Forum](http://board.openestate.org/viewtopic.php?f=7&t=3329))

### 0.4.1

-   Show an error message on the website, if OpenEstate-ImmoTool is currently
    exporting properties to the webspace.
    (see [Bug-Tracker #594](http://tracker.openestate.org/view.php?id=594))
-   Add an empty `upgrade.php` for better compatibility with *WebsiteBaker*.

### 0.4

-   Some smaller fixes

### 0.3

-   module internationalized
-   module translated into English
-   select between list and gallery view in the administration form
-   fixed HTML errors in the administration form

### 0.2

-   First public release


License
-------

[GNU General Public License 3](http://www.gnu.org/licenses/gpl-3.0-standalone.html)
