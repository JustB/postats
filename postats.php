<?php

/*
Plugin Name: Postats
Description: Print stats about your posts.
Plugin URI: http://borzacchiello.it/postats
Version: 0.1
Author: Giustino Borzacchiello
Author URI: http://borzacchiello.it
Text Domain: postats
Domain Path: /languages/
License: GPL v2 or later

Copyright © 2016 Giustino Borzacchiello

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

class Postats {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'action_plugins_loaded' ) );
		add_filter( 'the_content', array( $this, 'filter_the_content') );
	}

	public function action_plugins_loaded() {
		load_plugin_textdomain( 'postats', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function filter_the_content( $content ) {
		$post_stats = $this->analyze_text( $content );

		return $content . $post_stats;
	}

	/**
	 * @param $text string Text to analyze
	 *
	 * @return string The content, with the statistics appended
	 */
	public function analyze_text( $text ) {
		$text = wp_strip_all_tags( $text );
		$words_array = preg_split( "/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY );

		$output = sprintf( '<div class="postats">' . __( 'Post Stats: your posts has %s words', 'postats' ) . '</div>',
			count( $words_array ) );


		return $output;
	}

	/**
	 * Singleton instantiator.
	 *
	 */
	public static function get_instance() {
		static $instance;

		if ( ! isset( $instance ) ) {
			$instance = new Postats();
		}

		return $instance;
	}
}

$GLOBALS['postats'] = Postats::get_instance();