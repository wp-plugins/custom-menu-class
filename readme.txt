=== Custom Menu Class ===
Contributors: Theodoros Fabisch
Tags: menu, classes, css class, css classes
Requires at least: 3.7
Tested up to: 4.2.2
Stable tag: trunk
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Set predefined CSS classes to menu items

== Description ==

Simple plugin that adds extra functionality to Menu Items. The plugin will allow to set predefined CSS classes to menu items.
Support for the plugin "If Menu": http://wordpress.org/plugins/if-menu/ - does not break the "If Menu" plugin.

== Installation ==

To install the plugin, follow the steps below

1. Upload `custom-menu-class` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set predefined CSS classes for your Menu Items in Appearance -> Menus page - Choose CSS classes from the select field (multiple selection is possible)

== Frequently Asked Questions ==

= How can I set the CSS classes? =

Example of adding new CSS classes for menu items.

`
//theme's functions.php
add_filter('custom_menu_css_classes', 'custom_menu_classes_basic_classes');

function custom_menu_classes_basic_classes($classes)
{
	$classes[] = array(
		'name' => 'Footer: CSS Class 1',
		'class' => 'footer-class-1'
	);

	$classes[] = array(
		'name' => 'Footer: CSS Class 2',
		'class' => 'footer-class-2'
	);

	//...

	return $classes;
}
`

== Changelog ==

= 0.1 =
* Plugin release. Basis for this plugin is "If Menu": http://wordpress.org/plugins/if-menu/