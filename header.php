<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="page">

			<header>

				<div class="wrapper">

					<?php hinagata_widget( 'header_before_container', 'container' ); ?>

					<div class="container">

						<?php hinagata_widget( 'header_before_content', 'content' ); ?>

						<div class="content">

							<div id="heading">
								<?php hinagata_heading(); ?>
							</div><!-- #heading -->

						</div><!-- .content -->

						<?php hinagata_widget( 'header_after_content', 'content' ); ?>

					</div><!-- .container -->

					<?php hinagata_widget( 'header_after_container', 'container' ); ?>

				</div><!-- #wrapper -->

			</header>

			<main>

				<div class="wrapper">

					<?php hinagata_widget( 'main_before_container', 'container' ); ?>

					<div class="container">

						<?php hinagata_widget( 'main_before_content', 'content' ); ?>

						<div class="content">
