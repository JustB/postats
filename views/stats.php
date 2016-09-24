<?php
/**
 *
 * @var integer $post_id
 * @var integer $words
 * @var integer $characters
 * @var float $reading_time
 * @var float $speaking_time
 */
?>
<div class="postats-container">
	<?php printf( '<h6 class="postats postats-%s">' . __( 'Post Stats', 'postats' ) . '</h6>', $post_id ); ?>
	<ul>
		<li><?php printf( _n( '%d word', '%d words', $words, 'postats' ), $words ) ?></li>
		<li><?php printf( _n( '%d character', '%d characters', $characters, 'postats' ), $characters ) ?></li>
		<li><?php printf( __( 'Reading time: %d s', 'postats' ), $reading_time ) ?></li>
		<li><?php printf( __( 'Speaking time: %ds', 'postats' ), $speaking_time ) ?></li>
	</ul>
</div>
