<div id="comments">
<?php
	if ( isset ( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'comments.php' == basename ( $_SERVER[ 'SCRIPT_FILENAME' ] ) ) {
		die ( 'Please do not load this page directly. Thanks!' );
	}
	if ( post_password_required () ) {
		echo '<p class="nocomments">' . __( 'This post is password protected. Enter the password to view any comments.', 'hinagata' ) . '</p></div><!-- #comments -->' ;
		return;
	}

	if ( have_comments() ) {
?>
		<header class="comments-header">
			<h1 class="comments-title">
				<?php
					comments_number( array(
						__( 'No Responses', 'hinagata' ),
						__( 'One Response', 'hinagata' ),
						__( '% Responses', 'hinagata' ),
					) );
				?>
			</h1><!-- .comments-title -->
		</header><!-- .comments-header -->

		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'avatar_size' => get_option( 'thumbnail_size_w' ) / 2,
					'callback' => 'hinagata_list_comments',
				) );
			?>
		</ol><!-- .commentlist -->

		<nav class="comments-nav">
			<div class="nav-previous"><?php previous_comments_link(); ?></div><!-- .nav-previous -->
			<div class="nav-next"><?php next_comments_link(); ?></div><!-- .nav-next -->
		</nav><!-- .comments-nav -->
<?php
	} else {
		if ( ! comments_open() ) {
			echo '<p class="nocomments">' . __( 'Comments are closed.', 'hinagata' ) . '</p><!-- .nocomments -->' ;
		}
	}

	if ( comments_open() ) {
?>
		<div id="respond">
			<?php comment_form(); ?>
		</div><!-- #respond -->
<?php
	}
?>
</div><!-- #comments -->
