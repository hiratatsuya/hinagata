<?php do_action( 'begin_article' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'parts' ); ?>>
	<div class="entry">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->
		<div class="entry-main">
			<?php hinagata_entry_thumbnail(); ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading &raquo;', 'hinagata' ) ); ?>
			</div>
		</div><!-- .entry-main -->
		<footer class="entry-footer">
			<?php hinagata_entry_link_pages(); ?>
			<?php hinagata_entry_meta(); ?>
			<?php hinagata_entry_comments_link(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry -->


</article><!-- .parts -->
<?php do_action( 'end_article' ); ?>
