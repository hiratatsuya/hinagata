<?php do_action( 'begin_article' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'part' ); ?>>
	<div class="entry">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
		<div class="entry-main">

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div><!-- .entry-main -->
		<footer class="entry-footer">
			<?php hinagata_entry_link_pages(); ?>
			<?php hinagata_entry_meta(); ?>

		</footer><!-- .entry-footer -->
		<?php hinagata_entry_navigation(); ?>
	</div><!-- .entry -->
	<?php do_action( 'between_entry_comments' ); ?>
	<?php comments_template(); ?>
</article><!-- .part -->
<?php do_action( 'end_article' ); ?>
