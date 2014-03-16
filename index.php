<?php
get_header();
	hinagata_breadcrumbs();
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			if ( is_singular() ){
				get_template_part( 'content', 'singular' );
			} else {
				get_template_part( 'content', 'archive' );
			}
		}
	} else {
		get_template_part( 'content', '404' );
	}
	hinagata_pagination();
get_footer();
