=== Custom Menu Class ===
Contributors: Theodoros Fabisch
Tags: menu, classes, menu class, css class, css classes, predefined css class
Requires at least: 3.7
Tested up to: 4.2.2
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Set predefined CSS classes to menu items

== Description ==

Simple plugin that adds extra functionality to Menu Items. The plugin will allow to set predefined CSS classes to menu items.
Support for the plugin "If Menu": http://wordpress.org/plugins/if-menu/ - does not break the "If Menu" plugin.

Example of adding new CSS classes for menu items is in the "FAQ" tab here.

Custom Menu Class is 100% free. if you have questions or need additional information u can comment on my Website (http://deving.de - http://deving.de/blog/wordpress/2292-wordpress-plugin-fuer-voreingestellte-css-klassen-fuer-menue-links/) or in the "Support" Tab here.

== Installation ==

To install the plugin, follow the steps below

1. Upload `custom-menu-class` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define CSS classes for menu items:
`
//theme's functions.php
add_filter('custom_menu_css_classes', 'custom_menu_classes_extra');

function custom_menu_classes_extra($classes)
{
	$classes[] = array(
		'name' => __('Footer CSS Class 1', 'custom-menu-class'),
		'class' => 'footer-class-1'
	);
	
	$classes[] = array(
		'name' => __('Footer CSS Class 2', 'custom-menu-class'),
		'class' => 'footer-class-2'
	);

	return $classes;
}
`
4. Set predefined CSS classes for your Menu Items in Appearance -> Menus page - Choose CSS classes from the select field (multiple selection is possible)

== Frequently Asked Questions ==

= How can I set the CSS classes? =

Example of adding new CSS classes for menu items.

`
//theme's functions.php
add_filter('custom_menu_css_classes', 'custom_menu_classes_extra');

function custom_menu_classes_extra($classes)
{
	$classes[] = array(
		'name' => __('Footer CSS Class 1', 'custom-menu-class'),
		'class' => 'footer-class-1'
	);
	
	$classes[] = array(
		'name' => __('Footer CSS Class 2', 'custom-menu-class'),
		'class' => 'footer-class-2'
	);

	return $classes;
}
`

== Screenshots ==

1. Here's a screenshot of it in action

== Changelog ==

= 0.1 =
* Plugin release. Basis for this plugin is "If Menu": http://wordpress.org/plugins/if-menu/

= 0.1.2 =
* Added Screenshot
* Bugfix: Filter function name