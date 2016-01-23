<?php

class TextAnalyzerTest extends WP_UnitTestCase {
	function test_EmptyText() {
		$a = new TextAnalyzer( '' );

		$this->assertInstanceOf( 'TextAnalyzer', $a );

		$this->assertEquals( 0, $a->count_words(), 'Empty text should have 0 words' );
		$this->assertEquals( 0, $a->count_characters(), 'Empty text should have 0 characters' );
		$this->assertEquals( 0, $a->reading_time(), 'Empty text should have 0s reading time' );
		$this->assertEquals( 0, $a->speaking_time(), 'Empty text should have 0s speaking time' );
	}

	function test_SingleCharacter() {
		$a = new TextAnalyzer( 'a' );

		$this->assertEquals( 1, $a->count_words() );
		$this->assertEquals( 1, $a->count_characters(), 'A single character should have 1 character' );
		$this->assertEquals( 0.32608695652173914, $a->reading_time() );
		$this->assertEquals( 0.5, $a->speaking_time() );
	}

	function test_MultiCharacter() {
		$a = new TextAnalyzer( 'aaaaaa' );

		$this->assertEquals( 1, $a->count_words() );
		$this->assertEquals( 6, $a->count_characters() );
		$this->assertEquals( 0.32608695652173914, $a->reading_time() );
		$this->assertEquals( 0.5, $a->speaking_time() );
	}

	function test_MultiWord() {
		$a = new TextAnalyzer( 'aaa bbb ccc' );

		$this->assertEquals( 3, $a->count_words() );
		$this->assertEquals( 11, $a->count_characters() );
		$this->assertEquals( 0.97826086956521741, $a->reading_time() );

	}

	function test_OneMinuteReadingTime() {
		$text = 'aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa';
		$a    = new TextAnalyzer( $text );

		$this->assertEquals( 60, $a->reading_time() );
	}
	function test_OneMinuteSpeakingTime() {
		$text = 'aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa aaa';
		$a    = new TextAnalyzer( $text );

		$this->assertEquals( 60, $a->speaking_time() );
	}

}