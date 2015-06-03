<?php
/*
Plugin Name: Custom Menu Class
Plugin URI: http://wordpress.org/plugins/custom-menu-class/
Description: Select predefined CSS classes to menu items
Version: 0.1
Author: Theodoros Fabisch
Author URI: http://deving.de
License: GPL2
Thanks to the Author of "If Menu" - (Basis for this plugin: http://wordpress.org/plugins/if-menu/)
*/

/*  Copyright 2012 More WordPress (email: theodoros.aiken@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Custom_Menu_Class
{
	public static function init()
	{
		if (is_admin())
		{
			add_action('admin_init', 'Custom_Menu_Class::admin_init');
			add_action('wp_update_nav_menu_item', 'Custom_Menu_Class::wp_update_nav_menu_item', 10, 2);
			add_filter('wp_edit_nav_menu_walker', create_function('', 'return "Custom_Menu_Class_Walker_Nav_Menu_Edit";'));
		}
		else if (!is_admin())
		{
			add_filter('wp_get_nav_menu_items', 'Custom_Menu_Class::wp_get_nav_menu_items');
		}
	}

	public static function get_classes()
	{
		$classes = apply_filters('custom_menu_css_classes', array());

		return $classes;
	}

	public static function wp_get_nav_menu_items($items)
	{
		$classes = Custom_Menu_Class::get_classes();
		$hidden_items = array();

		foreach($items as $key => $item)
		{
			if (in_array($item -> menu_item_parent, $hidden_items))
			{
				unset( $items[$key] );
				$hidden_items[] = $item -> ID;
			}
			else if (get_post_meta($item -> ID, 'Custom_Menu_Class_class', true))
			{
				$class = get_post_meta($item -> ID, 'Custom_Menu_Class_class', true);

				foreach ($class as $selected_class)
				{
					$item -> classes[] = $selected_class;
				}
			}
		}

		return $items;
	}

	public static function admin_init()
	{
		global $pagenow;

		if ($pagenow == 'nav-menus.php')
		{
			//wp_enqueue_script( 'custom-menu-class-js', plugins_url( 'custom-menu-class.js' , __FILE__ ), array( 'jquery' ) );
		}
	}

	public static function edit_menu_item_settings($item)
	{
		$classes = Custom_Menu_Class::get_classes();

		$Custom_Menu_Class_class = get_post_meta($item -> ID, 'Custom_Menu_Class_class', true);

		ob_start();
		?>
		<p class="custom-menu-class-condition description description-wide" style="display: <?php echo $Custom_Menu_Class_enable ? 'block' : 'block' ?>">
			<label for="edit-menu-item-custom-menu-class-<?php echo $item -> ID; ?>">
				<?php _e('CSS-Classes (predefined)<br /><small>Hold down the control (ctrl) button to select multiple options</small>', 'custom-menu-class') ?><br />
				<select id="edit-menu-item-custom-menu-class-<?php echo $item -> ID; ?>" name="menu-item-custom-menu-class[<?php echo $item -> ID; ?>][]" multiple="multiple">
					<?php foreach($classes as $class): ?>
						<option value="<?php echo $class['class']; ?>" <?php selected(true, in_array($class['class'], $Custom_Menu_Class_class), true); ?>><?php echo $class['name']; ?></option>
					<?php endforeach ?>
				</select>
			</label>
		</p>
		<?php
		$html = ob_get_clean();

		return $html;
	}

	public static function wp_update_nav_menu_item($menu_id, $menu_item_db_id)
	{
		update_post_meta($menu_item_db_id, 'Custom_Menu_Class_class', $_POST['menu-item-custom-menu-class'][$menu_item_db_id]);
	}
}

/* ------------------------------------------------
	Custom Walker for nav items - with "if menu" plugin support
------------------------------------------------ */
require_once(ABSPATH . 'wp-admin/includes/nav-menu.php');

if (class_exists('If_Menu_Walker_Nav_Menu_Edit'))
{
	class Custom_Menu_Class_Walker_Nav_Menu_Edit extends If_Menu_Walker_Nav_Menu_Edit
	{
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
		{
			$desc_snipp = '<div class="menu-item-actions description-wide submitbox">';
			parent::start_el($output, $item, $depth, $args, $id);

			$pos = strrpos($output, $desc_snipp);

			if ($pos !== false)
			{
				$output = substr_replace($output, Custom_Menu_Class::edit_menu_item_settings($item).$desc_snipp, $pos, strlen($desc_snipp));
			}
		}
	}
}
else
{
	class Custom_Menu_Class_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit
	{
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
		{
			$desc_snipp = '<div class="menu-item-actions description-wide submitbox">';
			parent::start_el($output, $item, $depth, $args, $id);

			$pos = strrpos($output, $desc_snipp);

			if ($pos !== false)
			{
				$output = substr_replace($output, Custom_Menu_Class::edit_menu_item_settings($item).$desc_snipp, $pos, strlen($desc_snipp));
			}
		}
	}
}

/* ------------------------------------------------
	Include default classes for menu items
------------------------------------------------ */
include 'classes.php';

/* ------------------------------------------------
	Run the plugin
------------------------------------------------ */
add_action('init', 'Custom_Menu_Class::init', 99);