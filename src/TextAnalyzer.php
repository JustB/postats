<?php


class TextAnalyzer {
	private $text;
	/**
	 * @var int Average Word Per Minute (WPM) while reading
	 */
	private $read_wpm;
	/**
	 * @var int Average Word Per Minute (WPM) while speaking
	 */
	private $speak_wpm;

	/**
	 * @param $text
	 * @param int $read_wpm
	 * @param int $speak_wpm
	 *
	 * Averages WPM taken from https://en.wikipedia.org/wiki/Words_per_minute
	 */
	public function __construct( $text = '', $read_wpm = 184, $speak_wpm = 120 ) {
		$this->text      = $text;
		$this->read_wpm  = $read_wpm;
		$this->speak_wpm = $speak_wpm;
	}

	public function set_text( $text ) {
		$this->text = wp_strip_all_tags( $text );
	}

	public function count_words() {
		return str_word_count( $this->text );
	}

	public function count_characters() {
		if ( empty( $this->text ) ) {
			return 0;
		}

		$characters = str_split( $this->text );

		return count( $characters );
	}

	public function reading_time() {
		$words = $this->count_words();

		return ( $words / $this->read_wpm ) * MINUTE_IN_SECONDS;
	}

	public function speaking_time() {
		$words = $this->count_words();

		return ( $words / $this->speak_wpm ) * MINUTE_IN_SECONDS;
	}
}