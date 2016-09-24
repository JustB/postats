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

require_once plugin_dir_path( __FILE__ ) . 'src/TextAnalyzer.php';

class Postats {
	/**
	 * @var TextAnalyzer
	 */
	private $text_analyzer;

	public function __construct( $text_analyzer ) {
		$this->text_analyzer = $text_analyzer;
	}

	public static function init( $text_analizer ) {
		$self = new self( $text_analizer );
		add_action( 'plugins_loaded', array( $self, 'action_plugins_loaded' ) );
		add_filter( 'the_content', array( $self, 'filter_the_content' ) );
		add_action( 'wp_enqueue_scripts', array( $self, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'postats', plugin_dir_url( __FILE__ ) . 'css/main.css' );
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
		$output = '';
		if ( is_single() && is_main_query() ) {
			$this->text_analyzer->set_text( $text );
			$words         = $this->text_analyzer->count_words();
			$characters    = $this->text_analyzer->count_characters();
			$reading_time  = $this->text_analyzer->reading_time();
			$speaking_time = $this->text_analyzer->speaking_time();
			$post_id       = get_the_ID();

			ob_start();
			include plugin_dir_path( __FILE__ ) . 'views/stats.php';
			$output = ob_get_clean();

		}

		return $output;
	}
}

$ta = new TextAnalyzer();
Postats::init( $ta );