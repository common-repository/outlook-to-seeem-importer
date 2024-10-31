=== Outlook to SeeEm importer ===
Contributors: Brad Allured (schneidley@gmail.com)
Donate link: http://thealluredproject.co.cc/donate.php
Tags: csv, import, spreadsheet, excel, outlook, SeeEm, contact, manager
Requires at least: 2.0.2
Tested up to: 2.9.1
Stable tag: 0.1.2

Import contacts from Outlook CSV files into your WordPress SeeEm Contact Manager.

== Description ==

This plugin imports contacts from CSV (Comma Separated Value) files into your WordPress database, where SeeEm Contact Manager can use them. It is designed to import a large quantity of contacts, specifically an entire MS Outlook Address Book, from a CSV file. It gives a number of options to customize how new entries and entry updates are handled.

= Features =

* Imports new contacts from CSV files on your local machine
* Updates existing contacts with information from the CSV file
* Includes options to customize how new contacts are added and existing contacts are updated
* Deals with Word-style quotes and other non-standard characters using WordPress' built-in mechanism (same one that normalizes your input when you write your posts)
* Columns in the CSV file can be in any order, provided that they have correct headings

== Changelog ==

* v0.1.2 - Initial public resease of the plugin

== Installation ==

Installing the plugin:

1. Unzip the plugin's directory into `wp-content/plugins`.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. The plugin will be available under Manage -> SeeEm importer (in WordPress 2.6 and below) or under Tools -> SeeEm importer (in WordPress 2.7 and above) on WordPress administration page.

== Screenshots ==

1. The plugin menu on the Wordpress Admin page.

== Usage ==
Create the CSV file: In Outlook 2007, click 'File' -> 'Import and Export', select 'Export to a file', and click 'Next'. Select 'Comma Separated Values (Windows)' and click 'Next'. Select the contact folder you wish to export and click 'Next'. Choose a file path and name that you can remember and click 'Next'. finally, click 'Map Custom Fields...' -> 'Clear Map' -> 'Default Map' -> 'OK' -> 'Finish'. your CSV file will then be created.

Upload a CSV file: Click on the SeeEm importer link on your WordPress admin page (under Manage on WordPress 2.6 and below; under Tools in WordPress 2.7 and above). Choose the import options: upload new contacts as 'published' or as 'drafts', update existing contacts to reflect data in the CSV file (or not), delete info not found in the CSV file for existing contacts (or not). Choose the file you would like to import and click 'Import'.

The most important part of using the plugin is having your CSV file in the right format. See the example files under 'Outlook_to_SeeEm_importer' -> 'Example_CSV_Files' (in the downloaded .ZIP folder) for examples of proper format. The key for this plugin to work is to have the proper header names in the CSV file.

= Notes: =

* Most columns in the file are optional. The only ones that __must__ be present are `First Name` and `Last Name`.
* Most values are also optional. Again, the only ones necessary are those under `First Name` and `Last Name` column headings.
* Once again, the order of columns in the file is not important, however the CSV header (the first line in the file that lists column names) must be present and its labels must correspond to the values separated by commas.

== Credits ==

This plugin was inspired by and modeled after [CSV Importer](http://wordpress.org/extend/plugins/csv-importer/) by Dennis Kobozev.

It uses much of the original code from [CSV Importer](http://wordpress.org/extend/plugins/csv-importer/) in a modified form, as well as [php-csv-parser](http://code.google.com/p/php-csv-parser/) by Kazuyoshi Tlacaelel.