<?php
/*
 * Plugin Name:       WP Post QR Code
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Effortlessly enhance posts and pages with QR codes using this plugin – seamlessly bridging digital and print interactions.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mohamed Alamin
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       wp-post-qr-code
 * Domain Path:       /languages
 */

class WPQC_QR_Code {
    private $size = 150;
    private $position = 'sticky';
    private $color = '00ffff';
    public function __construct(){
        add_action ( 'init', array( $this,'init') );
    }

    public function init( ){
        add_filter( 'the_content', array( $this,'add_qr_code') );
        $this->size = apply_filters( 'wpqc_qr_code_size', $this->size );
        $this->color = apply_filters( 'wpqc_qr_code_color', $this->color );
        $this->position = apply_filters( 'wpqc_qr_code_position', $this->position );
    }

    public function add_qr_code( $content){
        $title = get_the_title();
        $current_link = esc_url(get_permalink());
        if( $this->position == "bottom"){
            $custom_content = '<div style="border: 1px solid #ddd; padding: 10px; margin: 20px 0;">';}
        else if( $this->position == "sticky" ){
            $custom_content = '<div style="border: 1px solid #ddd; position:fixed; right:0; bottom:0; padding: 10px;">';
        }
        
        $custom_content .= "<img src='https://api.qrserver.com/v1/create-qr-code/?size={$this->size}x{$this->size}&data={ $current_link }&color={$this->color}' alt='QR Code for {$title}' />";
        $custom_content .=  "</div>";

        $content .= $custom_content;
        return $content;
    }

}

new WPQC_QR_Code;
