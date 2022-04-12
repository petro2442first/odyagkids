<?php
/**
 * Only search product
 *
 * @package zoa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// sidebar.
$shop_sidebar = ! is_active_sidebar( 'shop-widget' ) ? 'full' : get_theme_mod( 'shop_sidebar', 'full' );
$shop_class   = '';
$shop_class   .= is_product() ? 'with-full-sidebar' : 'with-' . $shop_sidebar . '-sidebar';

// Sidebar on mobile.
if ( get_theme_mod( 'flexible_sidebar' ) ) {
	$shop_class .= ' has-flexible-sidebar';
}

// query.
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}

$ppp     = (int) get_theme_mod( 'c_shop_ppp', 12 );
$key     = isset( $_GET['s'] ) ? sanitize_key( $_GET['s'] ) : 'product';
$columns = wc_get_default_products_per_row();

$args = array(
	'post_type'           => 'product',
	's'                   => $key,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'paged'               => $paged,
	'posts_per_page'      => $ppp,
);

$search_query = new WP_Query( $args );

get_header();
?>

<div class="shop-container container <?php echo esc_attr( $shop_class ); ?>">
	<main id="main" class="shop-content">
		<?php
		do_action( 'zoa_product_search_shop_content_start' );

		if ( $search_query->have_posts() ) {
			?>
			<ul class="products columns-<?php echo esc_attr( $columns ); ?>">
				<?php
				while ( $search_query->have_posts() ) :
					$search_query->the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				?>
			</ul>
			<?php

			zoa_paging( $search_query );
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</main>
	<?php get_sidebar( 'shop' ); ?>
</div>

<?php
	get_footer();
