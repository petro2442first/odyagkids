<?php
/**
 * Index
 *
 * @package zoa
 */

get_header();

if ( is_archive() || is_home() || is_search() ) {
	get_template_part( 'template-parts/archive' );
} elseif ( is_singular() ) {
	get_template_part( 'template-parts/single' );
} else {
	get_template_part( 'template-parts/404' );
}

get_footer();
