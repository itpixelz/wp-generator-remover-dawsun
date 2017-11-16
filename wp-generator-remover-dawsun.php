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
 * Description:       Hide/Remove WordPress Generator Meta, Hide/Remove Stylesheet Version, Hide/Remove Javascript Version
 * Version:           2.0.0
 * Author:            Umar Draz
 * Author URI:        http://www.dawsun.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_generator_remover_dawsun
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}




class Wp_generator_remover_dawsun
{

    public $ptions;
    public function __construct()
    {

        $this->options = get_option('wpgrd_settings');
        add_action('admin_menu', array(
            $this,
            'wpgrd_add_admin_menu'
        ));
        add_action('admin_init', array(
            $this,
            'wpgrd_settings_init'
        ));

        register_activation_hook(__FILE__, array(
            $this,
            'wpgrd_defaults'
        ));

				$this->apply_settings();



    }

		// apply the settings
		public function apply_settings(){

			// check for wordpess generator
			if(isset($this->options['wpgrd_checkbox_field_wp_generator']) && $this->options['wpgrd_checkbox_field_wp_generator'] == 1){
				$this->wpgrd_remove_wp_generator_meta();
			}

			// check for sytlesheet generator
			if(isset($this->options['wpgrd_checkbox_field_stylesheet']) && $this->options['wpgrd_checkbox_field_stylesheet'] == 1){
				add_filter('style_loader_src', array($this, 'wpgrd_remove_version_script_style'), 20000);
			}

			// check for script/ javascript generator
			if(isset($this->options['wpgrd_checkbox_field_script']) && $this->options['wpgrd_checkbox_field_script'] == 1){
				add_filter('script_loader_src', array($this, 'wpgrd_remove_version_script_style'), 20000);
			}

		}




    public function wpgrd_add_admin_menu()
    {

        add_options_page('WP Generator Remover by Dawsun Settings', 'WP Generator Remover Setting', 'manage_options', 'wp_generator_remover_by_dawsun', array(
            $this,
            'wpgrd_options_page'
        ));

    }


    public function wpgrd_settings_init()
    {

        register_setting('wpgrd_options', 'wpgrd_settings');

        add_settings_section('wpgrd_wpgrd_options_section', __('Update Settings', 'wp_generator_remover_dawsun'), array(
            $this,
            'wpgrd_settings_section_callback'
        ), 'wpgrd_options');

        add_settings_field('wpgrd_checkbox_field_wp_generator', __('Hide WP Generator Version Meta', 'wp_generator_remover_dawsun'), array(
            $this,
            'wpgrd_checkbox_field_wp_generator_render'
        ), 'wpgrd_options', 'wpgrd_wpgrd_options_section');

        add_settings_field('wpgrd_checkbox_field_stylesheet', __('Hide Stylesheet Version Link', 'wp_generator_remover_dawsun'), array(
            $this,
            'wpgrd_checkbox_field_stylesheet_render'
        ), 'wpgrd_options', 'wpgrd_wpgrd_options_section');

        add_settings_field('wpgrd_checkbox_field_script', __('Hide Javascript Version Link', 'wp_generator_remover_dawsun'), array(
            $this,
            'wpgrd_checkbox_field_script_render'
        ), 'wpgrd_options', 'wpgrd_wpgrd_options_section');



    }


    public function wpgrd_checkbox_field_wp_generator_render()
    {


?>



	<input type='checkbox' name='wpgrd_settings[wpgrd_checkbox_field_wp_generator]' <?php
        checked(isset($this->options['wpgrd_checkbox_field_wp_generator']), 1);
?> value='1'>
	<?php

    }


    public function wpgrd_checkbox_field_stylesheet_render()
    {


?>
	<input type='checkbox' name='wpgrd_settings[wpgrd_checkbox_field_stylesheet]' <?php
        checked(isset($this->options['wpgrd_checkbox_field_stylesheet']), 1);
?> value='1'>
	<?php

    }


    public function wpgrd_checkbox_field_script_render()
    {


?>
	<input type='checkbox' name='wpgrd_settings[wpgrd_checkbox_field_script]' <?php
        checked(isset($this->options['wpgrd_checkbox_field_script']), 1);
?> value='1'>
	<?php

    }





    public function wpgrd_settings_section_callback()
    {

        echo __('Update options and save', 'wp_generator_remover_dawsun');

    }


    public function wpgrd_options_page()
    {

?>
	<form action='options.php' method='post'>

		<h2>WP Generator Remover by Dawsun Settings</h2>

		<?php
        settings_fields('wpgrd_options');
        do_settings_sections('wpgrd_options');
        submit_button();
?>

	</form>
	<?php

    }


    public function wpgrd_defaults()
    {

        $defaults = array(
            'wpgrd_checkbox_field_wp_generator' => 1,
            'wpgrd_checkbox_field_stylesheet' => 1,
            'wpgrd_checkbox_field_script' => 1,
        );

        if (is_admin()) {
            update_option('wpgrd_settings', $defaults);
        }
    }



		// remove WP Generator Meta Tag
		public function wpgrd_remove_wp_generator_meta() {


			remove_action('wp_head', 'wp_generator');

		}



		// handle stylesheet/javascript url
		public function wpgrd_remove_version_script_style( $target_url ) {


		        if(strpos( $target_url, 'ver=' )) {
		            $target_url = remove_query_arg( 'ver', $target_url );
		        }

		    return $target_url;
		}



}


new Wp_generator_remover_dawsun();
