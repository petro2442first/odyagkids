<?php
/**
 * Only search enable
 *
 * @package zoa
 */

$post_type = 'product';
if ( isset( $post_type ) && locate_template( 'search-' . $post_type . '.php' ) && true == get_theme_mod( 'product_search', false ) ) {
	get_template_part( 'search', $post_type );
	exit;
}

get_header();
$sidebar = get_theme_mod( 'blog_sidebar', 'right' );
?>

<div class="container">
	<div class="row">
		<?php
			switch( $sidebar ):
			case 'left':
			/*! sidebar in left
			------------------------------------------------->*/
		?>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>

			<main id="main" class="col-md-9 col-lg-9">
				<?php
				if ( have_posts() ):
					while ( have_posts() ): the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					zoa_paging();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</main>
			<?php
				break;
				case 'right':
				/*! sidebar in right
				------------------------------------------------->*/
			?>
			<main id="main" class="col-md-9 col-lg-9">
				<?php
				if ( have_posts() ):
					while ( have_posts() ): the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					zoa_paging();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</main>

			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
			<?php
				break;
				case 'full':
				/*! no sidebar
				------------------------------------------------->*/
			?>
			<main id="main" class="col-md-12 col-lg-12">
				<?php
				if ( have_posts() ):
					while ( have_posts() ): the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					zoa_paging();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</main>
		<?php
			break;
			endswitch;
		?>
	</div>
</div>

<?php
	get_footer();