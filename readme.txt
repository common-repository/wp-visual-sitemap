=== WP Visual Sitemap ===
Contributors: corgux
Tags: sitemap, visual sitemap, front end sitemap
Requires at least: 4.7.5
Tested up to: 5.3.2
Stable tag: trunk
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a visual sitemap to the front end of your site.

== Description ==
Add a visual sitemap of your site's pages, or of a menu, to any page on your website. Options available to add icons and choose the colour of the sitemap.

== Installation ==
* Upload wp-visual-sitemap folder to your /wp-content/plugins/ directory.
* Activate the plugin through the ‘Plugins’ menu in WordPress.
* Customise the look and feel of the sitemap by going to Settings > WP Visual Sitemap.
* In the page editor choose icon and whether to exclude the page from the sitemap.
* You can override the sitemap's CSS by creating a directory named 'wp-visual-sitemap' in your template  with a stylesheet named wpvs-front-end.css.  It's advisable to copy the stylesheet from the plugin's CSS directory, then make your changes.
* Use the [wp_visual_sitemap] shortcode to display your sitemap!
* Use the "menu" attribute to display a visual sitemap of a menu of your choice, e.g. [wp_visual_sitemap menu="my menu"]

== Frequently Asked Questions ==
None yet!

== Screenshots ==
1. Main settings, with preview panel showing colour choices.
2. Page settings, where you can choose to exclude the page from the sitemap, and choose the icon to use.
3. Example of a sitemap displayed on the page.

== Changelog ==
= 0.1 =
* Initial release

= 0.2 =
* Fixed issue with default settings

= 0.3 =
* Changed default to include all pages

= 0.4 =
* Improved admin preview panel

= 0.5 =
* Improvements to admin UI

= 1.0.1 =
* Add menu functionality

= 1.0.2 =
* Bug fix