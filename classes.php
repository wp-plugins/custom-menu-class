<?php
function custom_menu_classes_basic_classes($classes)
{

	$classes[] = array(
		'name' => __('No selection', 'custom-menu-class'),
		'class' => ''
	);

	return $classes;
}
add_filter('custom_menu_css_classes', 'custom_menu_classes_basic_classes');