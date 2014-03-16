<?php

// set up
	if ( ! isset( $content_width ) ) {
		$hinagata_options = hinagata_get_theme_options();
		$content_width = $hinagata_options[ 'content_width' ];
	}

	add_action( 'after_setup_theme', 'hinagata_setup' );
	if ( ! function_exists( 'hinagata_setup' ) ) {
		function hinagata_setup() {

			$hinagata_options = hinagata_get_theme_options();

			//load_theme_textdomain
			load_theme_textdomain( 'hinagata', get_template_directory() . '/languages' );

			//theme-support_automatic-feed-links
			add_theme_support( 'automatic-feed-links' );

			//theme-support_custom-background
			$hinagata_args = array (
				'default-color' => '',
				'default-image' => '',
				'wp-head-callback' => '_custom_background_cb',
				'admin-head-callback' => '',
				'admin-preview-callback' => '',
			);
			add_theme_support( 'custom-background', $hinagata_args );

			// theme-support_custom-header
			$hinagata_args = array (
				'default-image' => '',
				'random-default' => false,
				'width' => $hinagata_options[ 'custom_header_image_width' ],
				'height' => $hinagata_options[ 'custom_header_image_height' ],
				'flex-width' => true,
				'flex-height' => true,
				'default-text-color' => '000',
				'header-text' => true,
				'uploads' => true,
				'wp-head-callback' => 'hinagata_header_style',
				'admin-head-callback' => 'hinagata_admin_header_style',
				'admin-preview-callback' => 'hinagata_admin_header_image',
			);
			add_theme_support( 'custom-header', $hinagata_args );

			//theme-support_editor-style
			add_theme_support( 'editor-style' );
			if ( $hinagata_options[ 'check_hinagata_design' ] ) {
				add_editor_style();
			}
			add_filter( 'mce_css', 'hinagata_editor_style' );

			//theme-support_menus
			add_theme_support( 'menus' );
			register_nav_menu( 'site_navigation', __( 'site-navigation', 'hinagata' ) );

			//theme-support_post-thumbnails
			add_theme_support( 'post-thumbnails' );
		}
	}

	// theme-support_custom-header
		if ( ! function_exists( 'hinagata_header_style' ) ) {
			function hinagata_header_style() {
				$hinagata_output = '<style type="text/css">';
				if ( display_header_text() ) {
					$hinagata_output .='
						#site-title, #site-title *,
						#site-description, #site-description * {
							color: #' . get_header_textcolor() . ';
						}
					';
				} else {
					$hinagata_output .='
						#site-title, #site-title *,
						#site-description, #site-description * {
							display: none;
						}
					';
				}
				$hinagata_output .= '</style>';
				echo $hinagata_output ;
			}
		}

		if ( ! function_exists( 'hinagata_admin_header_style' ) ) {
			function hinagata_admin_header_style() {
				$hinagata_output = '<style type="text/css">';
				if ( ! display_header_text() ) {
					$hinagata_output .='
						#site-title, #site-title *,
						#site-description, #site-description * {
							display: none;
						}
					';
				} else {
					$hinagata_output .= '
						#site-title, #site-title * {font-size: 2.0rem;}
						#site-description, #site-description * {font-size: 1.8rem;}
						#site-title, #site-title *,
						#site-description, #site-description * {
							color:#' . get_header_textcolor() . ';
							letter-spacing: 0.05em;
							word-spacing: 0.05em;
							font-weight: bold;
							font-family: Arial, Helvetica, sans-serif!important;
						}
					';
				}
				$hinagata_output .= '</style>';
				echo $hinagata_output ;
			}
		}

		if ( ! function_exists( 'hinagata_admin_header_image' ) ) {
			function hinagata_admin_header_image() {
				$hinagata_header_image = get_header_image();
				$hinagata_header_textcolor = get_header_textcolor();
				$hinagata_output = '
					<h1 id="site-title">' . get_bloginfo( 'name' ) . '</h1>
					<h2 id="site-description" style="color:#' . $hinagata_header_textcolor . ';">' . get_bloginfo( 'description') . '</h2>
				';
				$hinagata_header_image = get_header_image();
				if ( $hinagata_header_image ) {
					$hinagata_output .= '<h3 id="site-image"><img src="' . $hinagata_header_image . '" width="' . get_custom_header() -> width .'" height="' . get_custom_header() -> height . '" /></h3>' ;
				}
				echo $hinagata_output ;
			}
		}

	//theme-support_editor-style
	function hinagata_editor_style( $hinagata_css ) {
		$hinagata_url = hinagata_rewrite_url();
		$hinagata_files = preg_split( '/,/', $hinagata_css );
		$hinagata_files[] = $hinagata_url[ 'css' ];
		$hinagata_files = array_map( 'trim', $hinagata_files );
		return join( ',', $hinagata_files );
	}



// theme options
	class hinagata_DEFAULT_THEME_OPTIONS {
		const hinagata_CONTENT_WIDTH = 960;
		const hinagata_CUSTOM_HEADER_IMAGE_WIDTH = 960;
		const hinagata_CUSTOM_HEADER_IMAGE_HEIGHT = 240;
		const hinagata_ENQUEUE_CSS = 'handle=css&src=http://www.example.com/style.css&deps=&ver=&media=all';
		const hinagata_ENQUEUE_JS = 'handle=js&src=http://www.example.com/script.js&deps=jquery&ver=&in_footer=true';
	}

	function hinagata_default_theme_options() {
		$hinagata_args = array(
			'check_options_delete' => 0,
			'check_hinagata_design' => 1,
			'credit' => sprintf( __( 'Copyright &copy; %1$s; %2$s Some Rights Reserved.', 'hinagata' ), date_i18n( 'Y' ), get_bloginfo( 'name' ) ),
			'content_width' => hinagata_DEFAULT_THEME_OPTIONS::hinagata_CONTENT_WIDTH,
			'custom_header_image_width' => hinagata_DEFAULT_THEME_OPTIONS::hinagata_CUSTOM_HEADER_IMAGE_WIDTH,
			'custom_header_image_height' => hinagata_DEFAULT_THEME_OPTIONS::hinagata_CUSTOM_HEADER_IMAGE_HEIGHT,
			'enqueue_css' => '',
			'enqueue_js' => '',
			'custom_css' => '/* CSS */',
			'custom_js' => '/* JS */',
		);
		return apply_filters( 'hinagata_default_theme_options', $hinagata_args );
	}

	function hinagata_get_theme_options() {
		return get_option( 'hinagata_theme_options_' . get_option( 'stylesheet' ), hinagata_default_theme_options() );
	}

	add_action( 'admin_init', 'hinagata_theme_options_init' );
		function hinagata_theme_options_init() {

			register_setting(
				'hinagata_options',
				'hinagata_theme_options_' . get_option( 'stylesheet' ),
				'hinagata_theme_options_validate'
			);

			add_settings_section(
				'general',
				'',
				'__return_false',
				'theme_options'
			);

			add_settings_field( 'check_options_delete', __( 'options delete check', 'hinagata' ), 'hinagata_settings_field_check_options_delete', 'theme_options', 'general' );
			add_settings_field( 'check_hinagata_design', __( 'sample design check', 'hinagata' ), 'hinagata_settings_field_check_hinagata_design', 'theme_options', 'general' );
			add_settings_field( 'credit', __( 'credit', 'hinagata' ), 'hinagata_settings_field_credit', 'theme_options', 'general' );
			add_settings_field( 'content_width', __( 'content_width', 'hinagata' ), 'hinagata_settings_field_content_width', 'theme_options', 'general' );
			add_settings_field( 'custom_header_image_width', __( 'custom_header_image_width', 'hinagata' ), 'hinagata_settings_field_custom_header_image_width', 'theme_options', 'general' );
			add_settings_field( 'custom_header_image_height', __( 'custom_header_image_height', 'hinagata' ), 'hinagata_settings_field_custom_header_image_height', 'theme_options', 'general' );
			add_settings_field( 'enqueue_css', __( 'enqueue_css', 'hinagata' ), 'hinagata_settings_field_enqueue_css', 'theme_options', 'general' );
			add_settings_field( 'enqueue_js', __( 'enqueue_js', 'hinagata' ), 'hinagata_settings_field_enqueue_js', 'theme_options', 'general' );
			add_settings_field( 'custom_css', __( 'custom_css', 'hinagata' ), 'hinagata_settings_field_custom_css', 'theme_options', 'general' );
			add_settings_field( 'custom_js', __( 'custom_js', 'hinagata' ), 'hinagata_settings_field_custom_js', 'theme_options', 'general' );

			$hinagata_options = hinagata_get_theme_options();
			if ( $hinagata_options[ 'check_options_delete' ] == 1 ) {
				delete_option( 'hinagata_theme_options_' . get_option( 'stylesheet' ) );
			}
		}

	add_action( 'admin_menu', 'hinagata_theme_options_add_page' );
		function hinagata_theme_options_add_page() {
			add_theme_page(
				__( 'Theme Options', 'hinagata' ),
				__( 'Theme Options', 'hinagata' ),
				'edit_theme_options',
				'theme_options',
				'hinagata_theme_options_render_page'
			);
		}

	$hinagata_request_uri = site_url( $_SERVER[ 'REQUEST_URI' ] );
	if ( ! is_admin() && ! preg_match( '/(wp\-admin|wp\-login\.php)/i', $hinagata_request_uri ) ) {
		add_action( 'wp_before_admin_bar_render', 'hinagata_theme_options_add_admin_bar' );
		function hinagata_theme_options_add_admin_bar() {
			global $wp_admin_bar;
			$hinagata_args = array (
				'parent' => 'site-name',
				'id' => 'theme-options',
				'title' => __( 'Theme Options', 'hinagata' ),
				'href' => admin_url( 'themes.php?page=theme_options' ),
			);
			$wp_admin_bar -> add_menu( $hinagata_args );
		}
	}

	function hinagata_theme_options_render_page() {
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e( 'Theme Options', 'hinagata' ); ?></h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
			<?php
				settings_fields( 'hinagata_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}

		function hinagata_settings_field_check_options_delete() {
			$hinagata_options = hinagata_get_theme_options();
			?>
			<input type="checkbox" name="hinagata_theme_options_<?php echo get_option( 'stylesheet' ) ;?>[check_options_delete]" id="chechk_options_delete" value="1" <?php checked( '1', $hinagata_options[ 'check_options_delete' ] ); ?> /><br />
			<?php
			_e( 'if you want to delete theme options, then you need to check here. subsequently [Save all changes].', 'hinagata' );
		}

		function hinagata_settings_field_check_hinagata_design() {
			$hinagata_options = hinagata_get_theme_options();
			?>
			<input type="checkbox" name="hinagata_theme_options_<?php echo get_option( 'stylesheet' ) ;?>[check_hinagata_design]" id="chechk_options_delete" value="1" <?php checked( '1', $hinagata_options[ 'check_hinagata_design' ] ); ?> /><br />
			<?php
			_e( 'if you want to use sample design, then you need to check here.', 'hinagata' );
		}

		function hinagata_settings_field_credit() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<input type="text" class="regular-text" name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[credit]" id="credit" value="' . esc_attr( $hinagata_options[ 'credit' ] ) . '" />' ;
		}

		function hinagata_settings_field_content_width() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<input type="number" step="1" min="0" class="small-text" name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[content_width]" id="content_width" value="' . esc_attr( $hinagata_options[ 'content_width' ] ) . '" />' ;
			printf( __( '(default:%s)px', 'hinagata' ), hinagata_DEFAULT_THEME_OPTIONS::hinagata_CONTENT_WIDTH);
		}

		function hinagata_settings_field_custom_header_image_width() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<input type="number" step="1" min="0" class="small-text" name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[custom_header_image_width]" id="custom_header_image_width" value="' . esc_attr( $hinagata_options[ 'custom_header_image_width' ] ) . '" />' ;
			printf( __( '(default:%s)px', 'hinagata' ), hinagata_DEFAULT_THEME_OPTIONS::hinagata_CUSTOM_HEADER_IMAGE_WIDTH);
		}

		function hinagata_settings_field_custom_header_image_height() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<input type="number" step="1" min="0" class="small-text" name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[custom_header_image_height]" id="custom_header_image_height" value="' . esc_attr( $hinagata_options[ 'custom_header_image_height' ] ) . '" />' ;
			printf( __( '(default:%s)px', 'hinagata' ), hinagata_DEFAULT_THEME_OPTIONS::hinagata_CUSTOM_HEADER_IMAGE_HEIGHT);
		}

		function hinagata_settings_field_enqueue_css() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<textarea name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[enqueue_css]" id="enqueue_css" class="large-text" cols="50" rows="10" class="large-text">' . esc_textarea( $hinagata_options[ 'enqueue_css' ] ) . '</textarea><br />' ;
			_e( 'e.g. ', 'hinagata' );
			echo hinagata_DEFAULT_THEME_OPTIONS::hinagata_ENQUEUE_CSS . '<br />';
			_e( 'c.f. ', 'hinagata' );
			echo '<a href="' . esc_url( __( 'http://codex.wordpress.org/Function_Reference/wp_enqueue_style', 'hinagata' ) ) . '" target="_blank">' . __( 'Codex : Function Reference/wp enqueue style', 'hinagata' ) . '</a><br />' ;
			_e( 'if you want to use external style, then you must set some value.', 'hinagata' );
		}

		function hinagata_settings_field_enqueue_js() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<textarea name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[enqueue_js]" id="enqueue_js" class="large-text" cols="50" rows="10" class="large-text">' . esc_textarea( $hinagata_options[ 'enqueue_js' ] ) . '</textarea><br />' ;
			_e( 'e.g. ', 'hinagata' );
			echo hinagata_DEFAULT_THEME_OPTIONS::hinagata_ENQUEUE_JS . '<br />';
			_e( 'c.f. ', 'hinagata' );
			echo '<a href="' . esc_url( __( 'http://codex.wordpress.org/Function_Reference/wp_enqueue_script', 'hinagata' ) ) . '" target="_blank">' . __( 'Codex : Function Reference/wp enqueue script', 'hinagata' ) . '</a><br />' ;
			_e( 'if you want to use external script, then you must set some value.', 'hinagata' );

		}

		function hinagata_settings_field_custom_css() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<textarea name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[custom_css]" id="custom_css" class="large-text" cols="50" rows="10" class="large-text">' . esc_textarea( $hinagata_options[ 'custom_css' ] ) . '</textarea>' ;
		}

		function hinagata_settings_field_custom_js() {
			$hinagata_options = hinagata_get_theme_options();
			echo '<textarea name="hinagata_theme_options_' . get_option( 'stylesheet' ) . '[custom_js]" id="custom_js" class="large-text" cols="50" rows="10" class="large-text">' . esc_textarea( $hinagata_options[ 'custom_js' ] ) . '</textarea>' ;
		}

	function hinagata_theme_options_validate( $hinagata_input ) {
		$hinagata_output = $hinagata_defaults = hinagata_default_theme_options();

		if ( ! isset( $hinagata_input[ 'check_options_delete' ] ) ) {
			$hinagata_input[ 'check_options_delete' ] = null;
		}
		$hinagata_output[ 'check_options_delete' ] = $hinagata_input[ 'check_options_delete' ] == 1 ? 1 : 0;

		if ( ! isset( $hinagata_input[ 'check_hinagata_design' ] ) )
			$hinagata_input[ 'check_hinagata_design' ] = null;
		$hinagata_output[ 'check_hinagata_design' ] = $hinagata_input[ 'check_hinagata_design' ] == 1 ? 1 : 0;


		if ( isset( $hinagata_input[ 'credit' ] ) )
			$hinagata_output[ 'credit' ] = $hinagata_input[ 'credit' ];

		if ( isset( $hinagata_input[ 'content_width' ] ) )
			$hinagata_output[ 'content_width' ] = $hinagata_input[ 'content_width' ];

		if ( isset( $hinagata_input[ 'custom_header_image_width' ] ) )
			$hinagata_output[ 'custom_header_image_width' ] = $hinagata_input[ 'custom_header_image_width' ];

		if ( isset( $hinagata_input[ 'custom_header_image_height' ] ) )
			$hinagata_output[ 'custom_header_image_height' ] = $hinagata_input[ 'custom_header_image_height' ];

		if ( isset( $hinagata_input[ 'enqueue_css' ] ) )
			$hinagata_output[ 'enqueue_css' ] = $hinagata_input[ 'enqueue_css' ];

		if ( isset( $hinagata_input[ 'enqueue_js' ] ) )
			$hinagata_output[ 'enqueue_js' ] = $hinagata_input[ 'enqueue_js' ];

		if ( isset( $hinagata_input[ 'custom_css' ] ) )
			$hinagata_output[ 'custom_css' ] = $hinagata_input[ 'custom_css' ];

		if ( isset( $hinagata_input[ 'custom_js' ] ) )
			$hinagata_output[ 'custom_js' ] = $hinagata_input[ 'custom_js' ];

		return apply_filters( 'hinagata_theme_options_validate', $hinagata_output, $hinagata_input, $hinagata_defaults );
	}

	//customize register
	add_action( 'customize_register', 'hinagata_customize_register' );
	if ( ! function_exists( 'hinagata_customize_register' ) ) {
		function hinagata_customize_register( $wp_customize ) {

			$hinagata_label = 'theme-options';
			$hinagata_args = array(
				'title' => __( 'Theme Options', 'hinagata' ),
				'priority' => 120,
			);
			$wp_customize -> add_section( $hinagata_label, $hinagata_args );

			$hinagata_args = array(
				'credit' => array(
					'settings' => array(
						'type' => 'option'
					),
					'controls' => array(
						'section' => $hinagata_label,
						'settings' => 'hinagata_theme_options[credit]',
						'label' => __( 'credit', 'hinagata' ),
						'type' => 'text',
					),
				),
			);
			foreach( $hinagata_args as $hinagata_key => $hinagata_val ) {
				$wp_customize -> add_setting( 'hinagata_theme_options[' . $hinagata_key . ']', $hinagata_val[ 'settings' ] );
				$wp_customize -> add_control( $hinagata_key, $hinagata_val[ 'controls' ]);
			}
		}
	}

	//rewrite rules
	$hinagata_request_uri = site_url( $_SERVER[ 'REQUEST_URI' ] );
	if ( ! is_admin() && ! preg_match( '/(wp\-admin|wp\-login\.php)/i', $hinagata_request_uri ) ) {
		$hinagata_options = hinagata_get_theme_options();
		if ( $hinagata_options[ 'check_hinagata_design' ] ) {
			add_filter( 'use_default_gallery_style', '__return_false' );
			add_action( 'wp_enqueue_scripts', 'hinagata_enqueue_resets' );
				function hinagata_enqueue_resets(){
					add_thickbox();
					wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
					wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js' );
				}
		}
	}

	add_filter( 'wp_loaded', 'hinagata_rewrite_rules' );
	if ( ! function_exists( 'hinagata_rewrite_rules' ) ) {
		function hinagata_rewrite_rules() {
			register_activation_hook( __FILE__, 'flush_rewrite_rules' );
			new HINAGATA_AddRewriteRules( 'hinagata.css$', 'css', 'hinagata_css' );
			new HINAGATA_AddRewriteRules( 'hinagata.js$', 'js', 'hinagata_js' );
		}
	}

		function hinagata_css() {
			header( 'Content-type:text/css;charset=UTF-8' );
			$hinagata_options = hinagata_get_theme_options();
			echo $hinagata_options[ 'custom_css' ] ;
			exit;
		}

		function hinagata_js() {
			header( 'Content-type:text/javascript;charset=UTF-8' );
			$hinagata_options = hinagata_get_theme_options();
			echo $hinagata_options[ 'custom_js' ] ;
			exit;
		}

	// hinagata_rewrite_url() is used on theme-options and editor_style.
	function hinagata_rewrite_url() {
		$hinagata_home = home_url( '/' );
		$hinagata_url = array(
			'css' => $hinagata_home . '?css=true',
			'js' => $hinagata_home . '?js=true',
		);
		return $hinagata_url ;
	}

		add_action( 'wp_enqueue_scripts', 'hinagata_enqueue_styles' );
			function hinagata_enqueue_styles() {
				$hinagata_request_uri = site_url( $_SERVER[ 'REQUEST_URI' ] );
				if ( ! is_admin() && ! preg_match( '/(wp\-admin|wp\-login\.php)/i', $hinagata_request_uri ) ) {
					$hinagata_options = hinagata_get_theme_options();
					$hinagata_enqueue_styles = explode( "\n", $hinagata_options[ 'enqueue_css' ] );
					foreach( $hinagata_enqueue_styles as $hinagata_enqueue_style ) {
						hinagata_enqueue_style( $hinagata_enqueue_style );
					}
					if ( $hinagata_options[ 'check_hinagata_design' ] ) {
						wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/style.css' );
					}
					$hinagata_url = hinagata_rewrite_url();
					wp_enqueue_style( 'hinagata', $hinagata_url[ 'css' ] );
				}
			}

			function hinagata_enqueue_style( $hinagata_args ) {
				$hinagata_defaults = array (
					'handle' => '',
					'src' => false,
					'deps' => false,
					'ver' => false,
					'media' => 'all',
				);
				$hinagata_tmp = wp_parse_args( $hinagata_args, $hinagata_defaults );
				extract( $hinagata_tmp, EXTR_SKIP );
				wp_enqueue_style( $hinagata_tmp[ 'handle' ], $hinagata_tmp[ 'src' ], $hinagata_tmp[ 'deps' ], $hinagata_tmp[ 'ver' ], $hinagata_tmp[ 'media' ] );
			}

		add_action( 'wp_enqueue_scripts', 'hinagata_enqueue_scripts' );
			function hinagata_enqueue_scripts() {
				$hinagata_request_uri = site_url( $_SERVER[ 'REQUEST_URI' ] );
				if ( ! is_admin() && ! preg_match( '/(wp\-admin|wp\-login\.php)/i', $hinagata_request_uri ) ) {
					$hinagata_options = hinagata_get_theme_options();
					$hinagata_enqueue_scripts = explode( "\n", $hinagata_options[ 'enqueue_js' ] );
					foreach ( $hinagata_enqueue_scripts as $hinagata_enqueue_script ) {
						hinagata_enqueue_script( $hinagata_enqueue_script );
					}
					if ( $hinagata_options[ 'check_hinagata_design' ] ) {
						wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/script.js' , array( 'jquery' ), '', true );
					}
					$hinagata_url = hinagata_rewrite_url();
					wp_enqueue_script( 'hinagata', $hinagata_url[ 'js' ] , array( 'jquery' ), '', true );
				}
			}

			function hinagata_enqueue_script( $hinagata_args ) {
				$hinagata_defaults = array (
					'handle' => '',
					'src' => false,
					'deps' => false,
					'ver' => false,
					'in_footer' => false,
				);
				$hinagata_tmp = wp_parse_args( $hinagata_args, $hinagata_defaults );
				extract( $hinagata_tmp, EXTR_SKIP );
				wp_enqueue_script( $hinagata_tmp[ 'handle' ], $hinagata_tmp[ 'src' ], $hinagata_tmp[ 'deps' ], $hinagata_tmp[ 'ver' ], $hinagata_tmp[ 'in_footer' ] );
			}



// breadcrumbs
	if ( ! function_exists( 'hinagata_breadcrumbs' ) ) {
		function hinagata_breadcrumbs() {
			global $wp_query, $post;
			$hinagata_label = '';
			if ( is_404() ) {
				$hinagata_label = __( 'Nothing Found', 'hinagata' );
			} elseif ( is_search() ) {
				$hinagata_label = sprintf( __( 'Search Results: %s', 'hinagata' ), get_search_query() );
			} elseif ( is_category() ) {
				$hinagata_label = sprintf( __( 'Category Archives: %s', 'hinagata' ), single_term_title( '', false) );
			} elseif ( is_tag() ) {
				$hinagata_label = sprintf( __( 'Tag Archives: %s', 'hinagata' ), single_term_title( '', false) );
			} elseif ( is_day() ) {
				$hinagata_label = sprintf( __( 'Daily Archives: %s', 'hinagata' ), get_the_time( _x( 'F jS, Y', 'daily archives date format', 'hinagata' ) ) );
			} elseif ( is_month() ) {
				$hinagata_label = sprintf( __( 'Monthly Archives: %s', 'hinagata' ), get_the_time( _x( 'F, Y', 'monthly archives date format', 'hinagata' ) ) );
			} elseif ( is_year() ) {
				$hinagata_label = sprintf( __( 'Yearly Archives: %s', 'hinagata' ), get_the_time( _x( 'Y', 'yearly archives date format', 'hinagata' ) ) );
			} elseif ( is_author() ) {
				$hinagata_term = $wp_query -> queried_object;
				$hinagata_label = sprintf( __( 'Author Archives: %s', 'hinagata' ), $hinagata_term -> display_name );
			} elseif ( is_tax() ) {
				$hinagata_term = $wp_query -> queried_object;
				$hinagata_label = sprintf( __( 'Taxonomy Archives: %s', 'hinagata' ), $hinagata_term -> name );
			} elseif ( is_page() or is_attachment() ) {
				$hinagata_label = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"> ' . __( 'HOME', 'hinagata' ) .'</a> / ';
				$hinagata_ancestors = array_reverse( get_post_ancestors( $post -> ID ) );
				array_push( $hinagata_ancestors, $post -> ID );
				foreach ( $hinagata_ancestors as $ancestor ) {
					if ( $ancestor != end( $hinagata_ancestors ) ) {
						$hinagata_label .= '<a href="' . get_permalink( $ancestor ) . '" title="' . strip_tags( get_the_title( $ancestor ) ) . '">' . strip_tags( get_the_title( $ancestor ) ) .'</a> / ';
					}
				}
			/*
			} elseif ( is_single() ) {
				$hinagata_label = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"> / </a>';
				$category = get_the_category();
				$category_id = get_cat_ID( $category[0] -> cat_name );
				$hinagata_label .= get_category_parents( $category_id, true, ' / ' );
			} elseif ( is_paged() ) {
				$hinagata_label = __( 'Blog Archives', 'hinagata' );
			*/
			}
			if ( $hinagata_label ) {
				$hinagata_label = '<nav id="breadcrumbs">' . $hinagata_label . '</nav><!-- #breadcrumbs -->';
			}
			echo $hinagata_label ;
		}
	}



// comments
	$hinagata_request_uri = site_url( $_SERVER[ 'REQUEST_URI' ] );
	if ( ! is_admin() && ! preg_match( '/(wp\-admin|wp\-login\.php)/i', $hinagata_request_uri ) ) {
		add_action( 'wp_enqueue_scripts', 'hinagata_comment_reply' );
		if ( ! function_exists( 'hinagata_comment_reply' ) ) {
			function hinagata_comment_reply() {
				if ( is_singular() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply' );
				}
			}
		}
	}

	//hinagata_list_comments
	if ( ! function_exists( 'hinagata_list_comments' ) ) {
		function hinagata_list_comments( $comment, $hinagata_args, $depth ) {
			$GLOBALS[ 'comment' ] = $comment;
			extract( $hinagata_args, EXTR_SKIP );

			if ( 'div' == $hinagata_args[ 'style' ] ) {
				$hinagata_tag = 'div';
				$hinagata_add_below = 'comment';
			} else {
				$hinagata_tag = 'li';
				$hinagata_add_below = 'div-comment';
			}
			$hinagata_comment_class = comment_class( empty( $hinagata_args[ 'has_children' ] ) ? '' : 'parent', null, null, false );

			echo '<' . $hinagata_tag . ' ' . $hinagata_comment_class . ' ' . 'id="comment-' . get_comment_ID() . '">' ;

				if ( get_avatar( $comment ) && $hinagata_args[ 'avatar_size' ] != 0 ) {
					echo '<div class="comment-author vcard">' . get_avatar( $comment, $hinagata_args[ 'avatar_size' ] ) . '</div><!-- .comment-author.vcard -->' ;
				}

				if ( 'div' != $hinagata_args[ 'style' ] ) {
					echo '<div id="div-comment-' . get_comment_ID() . '" class="comment-body">' ;
				}

					printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'hinagata' ), get_comment_author_link() );

					if ( $comment -> comment_approved == '0' ) {
						echo '<em class="comment-awaiting-moderation">' . __( 'Your comment is awaiting moderation.', 'hinagata' ) . '</em><br />' ;
					}

					echo '<div class="comment-meta commentmetadata"><a href="' . htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">' ;
						printf( __( '%1$s at %2$s', 'hinagata' ), get_comment_date(), get_comment_time() ) ?></a><?php edit_comment_link( __( '(Edit)', 'hinagata' ),' ','' );
					echo '</div><!-- .comment-meta -->' ;

					echo '<div class="comment-text">' ;
						comment_text();
					echo '</div><!-- .comment-text -->' ;

					echo '<div class="reply">' ;
						comment_reply_link( array_merge( $hinagata_args, array( 'add_below' => $hinagata_add_below, 'depth' => $depth, 'max_depth' => $hinagata_args[ 'max_depth' ] ) ) );
					echo '</div><!-- .reply -->' ;

				if ( 'div' != $hinagata_args[ 'style' ] ) {
					echo '</div><!-- .comment-body -->' ;
				}
		}
	}



// entries
	//hinagata_entry_thumbnail
	if ( ! function_exists( 'hinagata_entry_thumbnail' ) ) {
		function hinagata_entry_thumbnail() {
			global $post;
			if ( has_post_thumbnail() ) {
				echo '<div class="entry-thumbnail"><a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a></div>' . "\n" ;
			}
		}
	}

	//hinagata_entry_link_pages
	if ( ! function_exists( 'hinagata_entry_link_pages' ) ) {
		function hinagata_entry_link_pages() {
			$hinagata_args = array(
				'before' => '',
				'after' => '',
				'next_or_number' => 'number',
				'echo' => '0',
			);
			$hinagata_link_pages = wp_link_pages( $hinagata_args );
			if ( $hinagata_link_pages != '' ) {
				echo '<nav class="link_pages">' ;
				_e( 'Pages:', 'hinagata' );
				if ( preg_match_all( "/(<a [^>]*>[\d]+<\/a>|[\d]+)/i", $hinagata_link_pages, $matched, PREG_SET_ORDER ) ) {
					foreach ( $matched as $link ) {
						if ( preg_match( "/<a ([^>]*)>([\d]+)<\/a>/i", $link[0], $link_matched ) )
							echo "<a class=\"page-numbers\" {$link_matched[1]}>{$link_matched[2]}</a>\n" ;
						else
							echo "<span class=\"page-numbers current\">{$link[0]}</span>\n" ;
					}
				}
				echo '</nav><!-- .link_pages -->' ;
			}
		}
	}

	//hinagata_enry_meta
	if ( ! function_exists( 'hinagata_enry_meta' ) ) {
		function hinagata_entry_meta() {

			echo '<div class="entry-meta">' ;

				edit_post_link( __( 'Edit this entry.', 'hinagata' ), "\n" . '<div class="edit_post">' , '</div><!-- .edit_post -->' . "\n" );

				$hinagata_categories_list = get_the_category_list( __( ', ', 'hinagata' ) );
				if ( $hinagata_categories_list ) {
					echo '<span class="categories-links">' . __( 'Categorized: ', 'hinagata' ) . $hinagata_categories_list . '</span><!-- .categories-links -->' ;
				}

				$hinagata_tag_list = get_the_tag_list( '', __( ', ', 'hinagata' ) );
				if ( $hinagata_tag_list ) {
					_e( ' / ', 'hinagata' );
					echo '<span class="tags-links">' . __( 'Tagged: ', 'hinagata' ) . $hinagata_tag_list . '</span><!-- .tags-links -->' ;
				}

				if ( $hinagata_categories_list || $hinagata_tag_list ) {
					echo '<br />' ;
				}

				$the_date = get_the_date();
				if ( $the_date ) {
					echo '<span class="posted_on">' . __( 'Posted on: ', 'hinagata' ) . '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_time() ) . '" rel="bookmark" class="entry-date">' . get_the_date() . '</a></span><!-- .posted_on -->' ;
				}

				$the_author = get_the_author();
				if ( $the_author ) {
					_e( ' / ', 'hinagata' );
					printf( '<span class="author vcard">' . __( 'Posted by: ', 'hinagata' ) . '<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span><!-- .author.vcard -->',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						esc_attr( sprintf( __( 'View all posts by %s', 'hinagata' ), get_the_author() ) ),
						get_the_author()
					);
				}

			echo '</div><!-- .entry-meta -->' ;

		}
	}

	//hinagata_entry_comments_link
	if ( ! function_exists( 'hinagata_entry_comments_link' ) ) {
		function hinagata_entry_comments_link() {
			comments_popup_link(
				__( 'Leave a comment', 'hinagata' ),
				__( 'One Response', 'hinagata' ),
				__( '% Responses', 'hinagata' ),
				'entry_comments-link',
				''
			);
		}
	}

	//hinagata_entry_navigation
	if ( ! function_exists( 'hinagata_entry_navigation' ) ) {
		function hinagata_entry_navigation() {
			if ( get_previous_post() or get_next_post() ) {
				echo '<nav class="entry-navigation">' ;
				previous_post_link( '<div class="nav-previous">%link</div>', '&laquo; %title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title &raquo;' );
				echo '</nav><!-- .entry-navigation -->' ;
			}
		}
	}

	//hinagata_entry_thumbnail
	if ( ! function_exists( 'hinagata_entry_404' ) ) {
		function hinagata_entry_404() {
			echo '<p>' . __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hinagata' ) . '</p>' ;
			get_search_form();
		}
	}



// heading
	if ( ! function_exists( 'hinagata_heading' ) ) {
		function hinagata_heading() {
			$hinagata_output = '
				<a class="home-link" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">
					<h1 id="site-title">' . get_bloginfo( 'name' ) . '</h1>
					<h2 id="site-description">' . get_bloginfo( 'description' ) . '</h2>
			';

			$hinagata_header_image = get_header_image();
			if ( $hinagata_header_image ) {
				$hinagata_output .= '<h3 id="site-image"><img src="' . $hinagata_header_image . '" width="' . get_custom_header() -> width .'" height="' . get_custom_header() -> height . '" /></h3>' ;
			}

			$hinagata_output .= '</a>';

			if ( has_nav_menu( 'site_navigation' ) ) {
				$hinagata_output .= '<h4 id="menu-toggle">' . __( 'Menu', 'hinagata' ) . '</h4>';
				$hinagata_output .= wp_nav_menu( array(
					'container' => 'nav',
					'container_id' => 'site-navigation',
					'theme_location' => 'site_navigation',
					'echo' => 0,
				) );
			}
			echo $hinagata_output ;
		}
	}



// colophon
	if ( ! function_exists( 'hinagata_colophon' ) ) {
		function hinagata_colophon() {
			$hinagata_options = hinagata_get_theme_options();
			if ( $hinagata_options[ 'credit' ] ) {
				echo '<small id="site-credit">' . $hinagata_options[ 'credit' ] . '</small>' ;
			}
			echo apply_filters( 'site_generator', '<small id="site-generator"><a href="' . esc_url( __( 'http://wordpress.org/', 'hinagata' ) ) . '" title="' . __( 'Semantic Personal Publishing Platform', 'hinagata' ) . '">' . sprintf( __( 'Proudly powered by %s', 'hinagata' ), 'WordPress' ) . '</a></small>' ) ;
		}
	}



// jpeg_quality
	add_filter(
		'jpeg_quality',
		function( $arg ) {
			return 100;
		}
	);



// pagination
	if ( ! function_exists( 'hinagata_pagination' ) ) {
		function hinagata_pagination() {
			global $wp_rewrite, $wp_query, $paged;
			$hinagata_paginate_base = get_pagenum_link( 1 );
			if ( strpos( $hinagata_paginate_base, '?' ) || ! $wp_rewrite -> using_permalinks() ) {
				$hinagata_paginate_format = '';
				$hinagata_paginate_base = add_query_arg( 'paged', '%#%' );
			} else {
				$hinagata_paginate_format = ( substr( $hinagata_paginate_base, -1 , 1 ) == '/' ? '' : '/' ) . user_trailingslashit( 'page/%#%/', 'paged' );
				$hinagata_paginate_base .= '%_%';
			}

			$hinagata_args = array (
				'base' => $hinagata_paginate_base,
				'format' => $hinagata_paginate_format,
				'total' => $wp_query -> max_num_pages,
				'mid_size' => 3,
				'current' => ( $paged ? $paged : 1 ),
			);
			$hinagata_paginate_links = paginate_links( $hinagata_args );

			if ( $hinagata_paginate_links ) {
				echo '<nav id="pagination">' . __( 'Pages:', 'hinagata' ) . $hinagata_paginate_links . '</nav><!-- #pagination -->' . "\n" ;
			}
		}
	}



// the_date
	add_action( 'the_post', 'hinagata_the_date' );
	if ( ! function_exists( 'hinagata_the_date' ) ) {
		function hinagata_the_date() {
			global $previousday;
			$previousday = '';
		}
	}



// widgets
	add_action( 'widgets_init', 'hinagata_register_sidebar' );
	if ( ! function_exists( 'hinagata_register_sidebar' ) ) {
		function hinagata_register_sidebar() {

			$hinagata_labels[ 'container' ] = array(
				'header_before_container' => __( 'Header Before Container', 'hinagata' ),
				'header_after_container' => __( 'Header After Container', 'hinagata' ),
				'main_before_container' => __( 'Main Before Container', 'hinagata' ),
				'main_after_container' => __( 'Main After Container', 'hinagata' ),
				'footer_before_container' => __( 'Footer Before Container', 'hinagata' ),
				'footer_after_container' => __( 'Footer After Container', 'hinagata' ),
			);

			$hinagata_labels[ 'content' ] = array(
				'header_before_content' => __( 'Header Before Content', 'hinagata' ),
				'header_after_content' => __( 'Header After Content', 'hinagata' ),
				'main_before_content' => __( 'Main Before Content', 'hinagata' ),
				'main_after_content' => __( 'Main After Content', 'hinagata' ),
				'footer_before_content' => __( 'Footer Before Content', 'hinagata' ),
				'footer_after_content' => __( 'Footer After Content', 'hinagata' ),
			);

			$hinagata_args = array(
				'before_widget' => '<div id="%1$s" class="content widget %2$s">',
				'after_widget' => '</div><!-- .content.widget -->',
				'before_title' => '<h1 class="widget-title">',
				'after_title' => '</h1>',
			);
			foreach( $hinagata_labels[ 'container' ] as $hinagata_key => $hinagata_val ) {
				$hinagata_args[ 'id' ] = $hinagata_key;
				$hinagata_args[ 'name'] = $hinagata_val;
				register_sidebar( $hinagata_args );
			}

			$hinagata_args[ 'before_widget' ] = '<div id="%1$s" class="widget %2$s">';
			foreach( $hinagata_labels[ 'content' ] as $hinagata_key => $hinagata_val ) {
				$hinagata_args[ 'id' ] = $hinagata_key;
				$hinagata_args[ 'name'] = $hinagata_val;
				register_sidebar( $hinagata_args );
			}

		}
	}

	if ( ! function_exists( 'hinagata_widget' ) ) {
		function hinagata_widget( $hinagata_label, $class ) {
			do_action( 'begin_' . $hinagata_label );
			if ( is_active_sidebar( $hinagata_label ) ) {
				echo '<aside class="' . $class . ' widgets" id="' . $hinagata_label . '">' ;
				dynamic_sidebar( $hinagata_label );
				echo '</aside><!-- .' . $class . '.widgets #' . $hinagata_label . '-->' ;
			}
			do_action( 'end_' . $hinagata_label );
		}
	}

	// do_shortcode
	add_filter( 'widget_text', 'do_shortcode' );


// wp_title
	add_filter( 'wp_title', 'hinagata_wp_title', 10, 2 );
	if ( ! function_exists( 'hinagata_wp_title' ) ) {
		function hinagata_wp_title( $hinagata_title, $hinagata_sep ) {
			global $paged, $page;

			if ( is_feed() ) {
				return $hinagata_title ;
			}
			$hinagata_title .= get_bloginfo( 'name' );
			$hinagata_sep = ' ' . $hinagata_sep . ' ';
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
				$hinagata_title = $hinagata_title . $hinagata_sep . $site_description;
			}
			if ( $paged >= 2 || $page >= 2 ) {
				$hinagata_title = $hinagata_title . $hinagata_sep . sprintf( __( 'Page %s', 'hinagata' ), max( $paged, $page ) );
			}
			return $hinagata_title ;
		}
	}



// AddRewriteRules
if ( ! class_exists( 'HINAGATA_AddRewriteRules' ) ) {
	class HINAGATA_AddRewriteRules {
		private $hinagata_rule = null;
		private $hinagata_query = null;
		private $hinagata_callback = null;

		function __construct( $hinagata_rule, $hinagata_query, $hinagata_callback ) {
			$this -> rule = $hinagata_rule;
			$this -> query = $hinagata_query;
			$this -> callback = $hinagata_callback;
			add_filter( 'query_vars', array( &$this, 'query_vars' ) );
			add_action( 'generate_rewrite_rules', array( &$this, 'generate_rewrite_rules' ) );
			add_action( 'wp', array( &$this, 'wp' ) );
		}

		public function generate_rewrite_rules( $wp_rewrite ) {
			$new_rules[ $this -> rule ] = $wp_rewrite -> index . '?' . (
				strpos( $this->query, '=' ) === FALSE ? $this -> query . '=1' : $this -> query
			);
			$wp_rewrite -> rules = $new_rules + $wp_rewrite -> rules;
		}

		private function parse_query( $hinagata_query ) {
			$hinagata_query = explode( '&', $hinagata_query );
			$hinagata_query = explode( '=', is_array( $hinagata_query ) && isset( $hinagata_query[ 0 ] ) ? $hinagata_query[ 0 ] : $hinagata_query );
			return is_array( $hinagata_query ) && isset( $hinagata_query[ 0 ] ) ? $hinagata_query[ 0 ] : $hinagata_query ;
		}

		public function query_vars( $hinagata_vars ) {
			$hinagata_vars[] = $this -> parse_query( $this -> query );
			return $hinagata_vars ;
		}

		public function wp() {
			if ( get_query_var( $this -> parse_query( $this -> query ) ) ) {
				call_user_func( $this -> callback );
			}
		}
	}
}
