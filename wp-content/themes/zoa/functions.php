<?php
/*! REQUIRED THEME FILE
------------------------------------------------->*/

/*THEME INCLUDES*/
require_once get_template_directory() . '/inc/init.php';

/*TGM PLUGIN*/
require_once get_template_directory() . '/tgm-plugin/recommend_plugins.php';

/*KIRKI PLUGIN*/
require_once get_template_directory() . '/inc/kirki-fallback.php';

/*CUSTOMIZE*/
require_once get_template_directory() . '/inc/customizer.php';

/*ELEMENTOR*/
require_once get_template_directory() . '/inc/elementor.php';

/*WOOCOMMERCE*/
require_once get_template_directory() . '/inc/woocommerce.php';


/*! ADMIN
------------------------------------------------->*/
add_action( 'admin_enqueue_scripts', 'zoa_admin_style' );
function zoa_admin_style() {
	wp_enqueue_style(
		'zoa-admin-style',
		get_template_directory_uri() . '/css/custom.css'
	);
}


/*! CUSTOMIZE
------------------------------------------------->*/
add_action( 'customize_preview_init', 'zoa_customizer_live_preview' );
function zoa_customizer_live_preview(){
	wp_enqueue_script(
		'zoa-customize-preview',
		get_template_directory_uri() . '/js/customize-preview.js',
		array(),
		null,
		true
	);
}

/*! ELEMENTOR
------------------------------------------------->*/

/*FOR WIDGET*/
add_action( 'elementor/frontend/after_register_scripts', 'zoa_register_script_file' );
function zoa_register_script_file(){
	wp_register_script(
		'tiny-slider',
		get_template_directory_uri() . '/js/tiny-slider.js',
		array(),
		null,
		true
	);

	/*CPUNTDOWN*/
	wp_register_script(
		'countdown',
		get_template_directory_uri() . '/js/countdown.js',
		array(),
		null,
		true
	);
}

/*FOR PAGE SETTING: RELOAD PAGE*/
add_action( 'elementor/preview/enqueue_scripts', 'zoa_scripts_in_preview_mode' );
function zoa_scripts_in_preview_mode(){
	wp_enqueue_script(
		'zoa-elementor-preview',
		get_template_directory_uri() . '/js/elementor-preview.js',
		array(),
		null,
		true
	);

	zoa_global_for_vartiation_gallery();
}


/*! THEME STATIC
------------------------------------------------->*/
add_action( 'wp_enqueue_scripts', 'zoa_static' );
function zoa_static(){
	/*MAIN STYLESHEET*/
	wp_enqueue_style(
		'zoa-theme-style',
		get_stylesheet_uri()
	);

	/*COMMENT REPLY SCRIPT*/
	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}

	/*PRODUCT ZOOM*/
	wp_register_script(
		'easyzoom',
		get_template_directory_uri() . '/js/easyzoom.js',
		array( 'jquery' ),
		null,
		true
	);

	wp_register_script(
		'easyzoom-handle',
		get_template_directory_uri() . '/js/easyzoom-handle.js',
		array( 'jquery', 'easyzoom' ),
		null,
		true
	);

	/*PLYR: SUPPORT FOR IE*/
	wp_register_script(
		'plyr-polyfill',
		get_template_directory_uri() . '/js/plyr-polyfill.js',
		array(),
		null,
		true
	);

	wp_register_script(
		'plyr-script',
		get_template_directory_uri() . '/js/plyr.js',
		array(),
		null,
		true
	);

	wp_register_style(
		'plyr-style',
		get_template_directory_uri() . '/css/plyr.css'
	);

	/*STICKY SIDEBAR*/
	wp_register_script(
		'sticky-sidebar',
		get_template_directory_uri() . '/js/sticky-sidebar.js',
		array(),
		null,
		true
	);

	/*PHOTO SWIPE*/
	wp_register_script(
		'photoswipe-init',
		get_template_directory_uri() . '/js/photoswipe-init.js',
		array( 'photoswipe', 'photoswipe-ui-default' ),
		null,
		true
	);

	/*TINY SLIDER*/
	wp_enqueue_script(
		'tiny-slider',
		get_template_directory_uri() . '/js/tiny-slider.js',
		array(),
		null,
		true
	);

	/*TINY SLIDER*/
	wp_enqueue_script(
		'product-images',
		get_template_directory_uri() . '/js/product-images.js',
		array( 'jquery', 'wc-add-to-cart-variation', 'tiny-slider' ),
		null,
		true
	);

	/*LITY LIGHBOX*/
	wp_register_script(
		'lity-script',
		get_template_directory_uri() . '/js/lity.js',
		array(),
		null,
		true
	);

	wp_register_style(
		'lity-style',
		get_template_directory_uri() . '/css/lity.css'
	);

	/*CPUNTDOWN*/
	wp_register_script(
		'countdown',
		get_template_directory_uri() . '/js/countdown.js',
		array(),
		null,
		true
	);

	/*SMOOTH SCROLL*/
	if( true == get_theme_mod( 'smooth', false ) ){
		wp_enqueue_script(
			'smoothscroll',
			get_template_directory_uri() . '/js/smoothscroll.js',
			array(),
			null,
			true
		);
	}

	/*GLOBAL WC CART VARIATION*/
	if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) && ! wp_script_is( 'wc-add-to-cart-variation', 'enqueued' ) ) {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}

	/*CLASS LIST ADD MULTI CLASS FOR IE*/
	if( true == zoa_ie() ){
		wp_enqueue_script(
			'polyfill-class-list',
			get_template_directory_uri() . '/js/polyfill-class-list.js',
			array(),
			null,
			true
		);

		wp_enqueue_script(
			'polyfill-fetch-api',
			get_template_directory_uri() . '/js/polyfill-fetch-api.js',
			array(),
			null,
			true
		);
	}

	/*PRELOADER*/
	if ( true == get_theme_mod( 'loading', false ) ) {
		wp_enqueue_script(
			'nprogress',
			get_template_directory_uri() . '/js/nprogress.js',
			array( 'jquery' ),
			false,
			true
		);
	}

	/* jQuery Autocomplete */
	wp_enqueue_script(
		'zoa-autocomplete-script',
		get_template_directory_uri() . '/js/autocomplete.min.js',
		array(),
		null,
		true
	);

	wp_localize_script(
		'zoa-autocomplete-script',
		'global',
		array(
			'url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'search_nonce' ),
		)
	);

	// Slick.
	wp_register_style(
		'slick',
		get_template_directory_uri() . '/css/slick.css'
	);
	wp_register_script(
		'slick',
		get_template_directory_uri() . '/js/slick.min.js',
		array( 'jquery', ),
		null,
		true
	);

	// disable auto zoom on mobile.
	wp_enqueue_script(
		'zoa-disable-auto-zoom-on-ios',
		get_template_directory_uri() . '/js/disable-auto-zoom-on-mobile.js',
		array(),
		null,
		true
	);

	/*CUSTOM SCRIPT*/
	wp_enqueue_script(
		'zoa-custom',
		get_template_directory_uri() . '/js/custom.js',
		array( 'jquery' ),
		null,
		true
	);
}


// Register Elementor locations.
add_action( 'elementor/theme/register_locations', 'zoa_theme_register_elementor_locations' );
/**
 * { function_description }
 *
 * @param      array $elementor_theme_manager  The elementor theme manager.
 */
function zoa_theme_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location(
		'header',
		[
			'hook'         => 'zoa_theme_header',
			'remove_hooks' => [ 'zoa_theme_print_elementor_header' ],
		]
	);
	$elementor_theme_manager->register_location(
		'footer',
		[
			'hook'         => 'zoa_theme_footer',
			'remove_hooks' => [ 'zoa_theme_print_elementor_footer' ],
		]
	);
	$elementor_theme_manager->register_location(
		'single',
		[
			'hook'         => 'zoa_theme_single',
			'remove_hooks' => [ 'zoa_theme_print_elementor_single' ],
		]
	);
	$elementor_theme_manager->register_location(
		'product_archive',
		[
			'hook'         => 'zoa_theme_archive',
			'remove_hooks' => [ 'zoa_theme_print_elementor_archive' ],
		]
	);
}

/**
 * Header
 */
function zoa_theme_print_elementor_header() {
	get_template_part( 'template-parts/header' );
}
add_action( 'zoa_theme_header', 'zoa_theme_print_elementor_header' );

/**
 * Footer
 */
function zoa_theme_print_elementor_footer() {
	get_template_part( 'template-parts/footer' );
}
add_action( 'zoa_theme_footer', 'zoa_theme_print_elementor_footer' );

/**
 * Single
 */
function zoa_theme_print_elementor_single() {
	get_template_part( 'template-parts/single' );
}
add_action( 'zoa_theme_single', 'zoa_theme_print_elementor_single' );

/**
 * Archive
 */
function zoa_theme_print_elementor_archive() {
	get_template_part( 'template-parts/archive' );
}
add_action( 'zoa_theme_archive', 'zoa_theme_print_elementor_archive' );
