<?php

/**
 *
 *
 *
 * @link              http://www.dawsun.com
 * @since             1.0.0
 * @package           wp_generator_remover_dawsun
 *
 * @wordpress-plugin
 * Plugin Name:       WP Generator Remover by Dawsun
 * Plugin URI:        http://www.dawsun.com
 * Description:       Hide WordPress Generator Meta Tag from head section, just install and activate, no further settings needed.
 * Version:           1.0.0
 * Author:            Umar Draz
 * Author URI:        http://www.dawsun.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_generator_remover_dawsun
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}




/**
 * Begins execution of the plugin.
 *
 *
 * @since    1.0.0
 */
function run_wp_generator_remover_dawsun() {

	// remove WP Generator Meta Tag
	remove_action('wp_head', 'wp_generator');

}
run_wp_generator_remover_dawsun();
