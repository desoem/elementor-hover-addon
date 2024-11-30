<?php
/**
 * Plugin Name: Elementor Hover Addon
 * Plugin URI: https://github.com/deseom
 * Description: Adds a custom widget to Elementor that shows text on image hover with motion effects.
 * Version: 1.3
 * Author: Ridwan Sumantri
 * Author URI: https://github.com/deseom
 * Text Domain: elementor-hover-addon
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Check if Elementor is installed and activated
function hover_addon_check_elementor() {
    // Make sure Elementor is installed and activated
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo esc_html__( 'Elementor Hover Addon requires Elementor to be installed and activated.', 'elementor-hover-addon' );
            echo '</p></div>';
        } );
        return;
    }
}
add_action( 'plugins_loaded', 'hover_addon_check_elementor' );

// Register the widget and enqueue styles after Elementor is fully loaded
function register_hover_image_widget() {
    // Ensure Elementor is loaded before proceeding
    if ( class_exists( 'Elementor\Widget_Base' ) ) {
        // Require the widget file
        require_once plugin_dir_path( __FILE__ ) . 'widget-hover-image.php';

        // Register the widget
        \Elementor\Plugin::instance()->widgets_manager->register( new \Hover_Image_Widget() );
        
        // Enqueue widget styles
        add_action( 'wp_enqueue_scripts', 'enqueue_hover_image_styles' );
    }
}
add_action( 'elementor/widgets/widgets_registered', 'register_hover_image_widget' );

// Enqueue CSS for the hover effect
function hover_image_widget_enqueue_styles() {
    wp_enqueue_style( 'hover-image-widget', plugins_url( '/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'hover_image_widget_enqueue_styles' );
