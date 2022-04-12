<?php // @codingStandardsIgnoreStart

/*PRODUCT IMAGE*/
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'zoa_product_gallery', 20 );
if ( ! function_exists( 'zoa_product_gallery' ) ) {
	function zoa_product_gallery() {

		/*PRODUCT ATTRIBUTE*/
		global $product;

		if ( ! is_object( $product ) ) {
			$id = zoa_get_last_product_id();
			if ( ! $id ) {
				return;
			}

			$product = wc_get_product( $id );
		}

		$product_id   = $product->get_id();
		$image_id     = $product->get_image_id();
		$image_alt    = zoa_img_alt( $image_id, esc_attr__( 'Product image', 'zoa' ) );
		$get_img_size = wc_get_image_size( 'woocommerce_single' );
		$image_size   = $get_img_size['width'] . 'x' . ! empty( $get_img_size['height'] ) ? $get_img_size['height'] : $get_img_size['width'];

		if ( $image_id ) {
			$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
			$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
			$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
			$image_size       = $image_full_src[1] . 'x' . $image_full_src[2];
		} else {
			$image_small_src[0]  = wc_placeholder_img_src();
			$image_medium_src[0] = wc_placeholder_img_src();
			$image_full_src[0]   = wc_placeholder_img_src();
		}

		$gallery_id = $product->get_gallery_image_ids();
		$layout     = get_theme_mod( 'shop_gallery_layout', 'vertical' );
		$video_url  = '';

		/*PRODUCT OPTION*/
		if ( function_exists( 'FW' ) ) {
			$video_url = fw_get_db_post_option( $product_id, 'video' );
			$p_layout  = fw_get_db_post_option( $product_id, 'layout' );
			if ( isset( $p_layout ) && 'default' != $p_layout ) {
				$layout = $p_layout;
			}

			wp_enqueue_style( 'lity-style' );
			wp_enqueue_script( 'lity-script' );
		}
		$classes[]  = $layout . '-style';
		if ( ! empty( $gallery_id ) ) {
			$classes[] = 'has-product-thumbnails';
		}

		if ( 'vertical' == $layout || 'horizontal' == $layout ) {
			$classes[] = 'has-slider-style';
		}

		if ( 'list' == $layout || 'grid' == $layout ) {
			$classes[] = 'has-col-style';
		}

		/*ZOOM JS*/
		if ( true == get_theme_mod( 'gallery_zoom', true ) ) {
			wp_enqueue_script( 'easyzoom-handle' );
		}

		if ( true == get_theme_mod( 'gallery_lightbox', false ) ) {
			// Photoswipe.
			wp_enqueue_script( 'photoswipe-init' );

			// Photoswipe markup html.
			?>
				<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

					<!-- Background of PhotoSwipe. 
						 It's a separate element, as animating opacity is faster than rgba(). -->
					<div class="pswp__bg"></div>

					<!-- Slides wrapper with overflow:hidden. -->
					<div class="pswp__scroll-wrap">

						<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
						<!-- don't modify these 3 pswp__item elements, data is added later on. -->
						<div class="pswp__container">
							<div class="pswp__item"></div>
							<div class="pswp__item"></div>
							<div class="pswp__item"></div>
						</div>

						<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
						<div class="pswp__ui pswp__ui--hidden">

							<div class="pswp__top-bar">

								<!--  Controls are self-explanatory. Order can be changed. -->

								<div class="pswp__counter"></div>

								<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

								<button class="pswp__button pswp__button--share" title="Share"></button>

								<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

								<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

								<!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
								<!-- element will get class pswp__preloader--active when preloader is running -->
								<div class="pswp__preloader">
									<div class="pswp__preloader__icn">
										<div class="pswp__preloader__cut">
											<div class="pswp__preloader__donut"></div>
										</div>
									</div>
								</div>
							</div>

							<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
								<div class="pswp__share-tooltip"></div> 
							</div>

							<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
							</button>

							<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
							</button>

							<div class="pswp__caption">
								<div class="pswp__caption__center"></div>
							</div>
						</div>
					</div>
				</div>
			<?php
		}

		/*SLIDER FOR `vertical` AND `horizontal` LAYOUT*/
		wp_enqueue_script( 'product-images' );
		zoa_global_for_vartiation_gallery();

		/*STICKY PRODUCT SUMMARY FOR `list` AND `grid` LAYOUT*/
		if ( ! empty( $gallery_id ) && ( 'list' == $layout || 'grid' == $layout ) ) {
			$class_name = '';

			wp_enqueue_script( 'sticky-sidebar' );
			wp_add_inline_script(
				'sticky-sidebar',
				"document.addEventListener( 'DOMContentLoaded', function() {

					if ( window.matchMedia( '( max-width: 767px )' ).matches ) {
						return;
					}

					var window_width = window.innerWidth;

					function sticky_summary() {
						if ( window_width < 992 ) {
							jQuery( '.summary.entry-summary' ).trigger( 'sticky_kit:detach' );
						} else {
							jQuery( '.summary.entry-summary' ).stick_in_parent({
								offset_top: 15
							});
						}
					}

					window.addEventListener( 'load', function() {
						sticky_summary();
					});

					window.addEventListener( 'resize', function() {
						sticky_summary();
					});

				} );",
				'after'
			);

			// Rebuild slider on mobile device.
			wp_add_inline_script(
				'tiny-slider',
				"document.addEventListener( 'DOMContentLoaded', function(){

					if ( window.matchMedia( '( min-width: 768px )' ).matches ) {
						return;
					}

					var image_carousel = tns({
						container: '#gallery-image',
						items: 1,
						autoHeight: true,
						mouseDrag: true,
						loop: false
					});

					var reset_slider = function(){
						image_carousel.goTo( 'first' );
					}

					jQuery( document.body ).on( 'found_variation', 'form.variations_form', function( event, variation ){
						reset_slider();
					});

					jQuery( '.reset_variations' ).on( 'click', function(){
						reset_slider();
					});
				});",
				'after'
			);
		}

		?>
		<div class="single-product-gallery <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php /*MAIN CAROUSEL*/ ?>
			<div class="pro-carousel-image">
				<div id="gallery-image">
					<figure class="pro-img-item ez-zoom" data-zoom="<?php echo esc_attr( $image_full_src[0] ); ?>">
						<?php if ( true == get_theme_mod( 'gallery_lightbox', false ) ) : ?>
							<a href="<?php echo esc_url( $image_full_src[0] ); ?>" data-size="<?php echo esc_attr( $image_size ); ?>" data-elementor-open-lightbox="no">
								<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
							</a>
						<?php else : ?>
							<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
						<?php endif; ?>
					</figure>

					<?php
					if ( ! empty( $gallery_id ) ) :
						foreach ( $gallery_id as $key ) :
							$g_full_img_src   = wp_get_attachment_image_src( $key, 'full' );
							$g_medium_img_src = wp_get_attachment_image_src( $key, 'woocommerce_single' );
							$g_img_alt        = zoa_img_alt( $key, esc_attr__( 'Product image', 'zoa' ) );
							$g_image_size     = $g_medium_img_src[1] . 'x' . $g_medium_img_src[2];
							?>
						<figure class="pro-img-item ez-zoom" data-zoom="<?php echo esc_attr( $g_full_img_src[0] ); ?>">
							<?php if ( true == get_theme_mod( 'gallery_lightbox', false ) ) : ?>
								<a href="<?php echo esc_url( $g_full_img_src[0] ); ?>" data-size="<?php echo esc_attr( $g_image_size ); ?>" data-elementor-open-lightbox="no">
									<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>">
								</a>
							<?php else : ?>
								<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>">
							<?php endif; ?>
						</figure>
							<?php
							endforeach;
						endif;
					?>
				</div>
			</div>

			<?php /*THUMB CAROUSEL*/ ?>
			<div class="pro-carousel-thumb">
				<?php if ( ! empty( $gallery_id ) && ( 'vertical' == $layout || 'horizontal' == $layout ) ) : ?>			
					<div id="gallery-thumb">
						<div class="pro-thumb">
							<img src="<?php echo esc_url( $image_small_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
						</div>

						<?php
						foreach ( $gallery_id as $key ) :
							$g_thumb_src = wp_get_attachment_image_src( $key, 'thumbnail' );
							$g_thumb_alt = zoa_img_alt( $key, esc_attr__( 'Product image', 'zoa' ) );
							?>
							<div class="pro-thumb">
								<img src="<?php echo esc_url( $g_thumb_src[0] ); ?>" alt="<?php echo esc_attr( $g_thumb_alt ); ?>">
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $video_url ) ) { ?>
				<a class="video-popup-btn zoa-icon-play" data-lity href="<?php echo esc_url( $video_url ); ?>"><?php esc_html_e( 'Video', 'zoa' ); ?></a>
			<?php } ?>

			<?php /* PRODUCT LABEL SINGLE PRODUCT */ ?>
			<?php
				echo zoa_product_label( $product ); // WPCS: XSS ok.
			?>
		</div>
		<?php
	}
}

/*REMOVE DESCRIPTION HEADING*/
add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );

/*AFTER ADD TO CART BUTTON*/
add_action( 'woocommerce_after_add_to_cart_button', 'additional_simple_add_to_cart', 20 );
if ( ! function_exists( 'additional_simple_add_to_cart' ) ) {
	function additional_simple_add_to_cart() {

		/*AJAX SINGLE ADD TO CART VALUE===*/
		global $product;
		$pid               = $product->get_id();
		$in_stock          = get_post_meta( $pid, '_manage_stock', true ); // RETURN `yes` || `no`
		$stock_qty         = $product->get_stock_quantity(); // RETUNR `INT` VALUE
		$sold_individually = $product->get_sold_individually();

		/*CHECK PRODUCT IN CART && CHECK QUANTITY IF IT ALREADY IN CART*/
		$already_in_cart     = zoa_product_check_in( $pid, $in_cart = true, $qty_in_cart = false );
		$in_cart_qty         = $already_in_cart ? zoa_product_check_in( $pid, $in_cart = false, $qty_in_cart = true ) : 0;
		$already_in_cart     = $already_in_cart ? 'yes' : 'no';

		/*WARNING TEXT*/
		$not_enough             = esc_html__( 'You cannot add that amount of this product to the cart because there is not enough stock.', 'zoa' );
		$out_of_stock           = sprintf( esc_html__( 'You cannot add that amount to the cart - we have %1$s in stock and you already have %1$s in your cart', 'zoa' ), $stock_qty );
		$valid_qty              = esc_html__( 'Please enter a valid quantity for this product', 'zoa' );

		$sold_individually_text = '';
		if ( $sold_individually ) {
			$sold_individually_text = 'data-sold_individually="' . esc_attr__( 'You can only purchase a product individually. View cart?', 'zoa' ) . '" data-sold_individually_status="' . $already_in_cart . '"';
		}
		?>
		<input class="in-cart-qty" type="hidden" value="<?php echo esc_attr( $in_cart_qty ); ?>"
		data-in_stock="<?php echo esc_attr( $in_stock ); ?>"
		data-out_of_stock="<?php echo esc_attr( $out_of_stock ); ?>"
		data-valid_qty="<?php echo esc_attr( $valid_qty ); ?>"
		data-not_enough="<?php echo esc_attr( $not_enough ); ?>"
		<?php echo wp_kses_post( $sold_individually_text ); ?>
		>
		<?php

		/*ADD TO WISHLIST BUTTON===*/
		$position = get_option( 'yith_wcwl_button_position' );
		if ( 'shortcode' == $position ) {
			echo class_exists( 'YITH_WCWL' ) ? do_shortcode( '[yith_wcwl_add_to_wishlist]' ) : '';
		}
	}
}

/*REMOVE ADDITIONAL INFORMATION HEADING*/
add_filter( 'woocommerce_product_additional_information_heading', 'zoa_remove_additional_information_heading' );
if ( ! function_exists( 'zoa_remove_additional_information_heading' ) ) {
	function zoa_remove_additional_information_heading() {
		return '';
	}
}

/*SET COLUMN FOR RELATED || UPSELL PRODUCT*/
add_filter( 'woocommerce_upsell_display_args', 'zoa_column_related' );
add_filter( 'woocommerce_output_related_products_args', 'zoa_column_related' );
if ( ! function_exists( 'zoa_column_related' ) ) {
	function zoa_column_related( $args ) {
		$number = (int) get_theme_mod( 'related_product_item', 5 );
		$column = (int) get_theme_mod( 'related_column', 5 );

		$args['posts_per_page'] = $number;
		$args['columns']        = $column;
		return $args;
	}
}

/*AJAX SINGLE ADD TO CART*/
add_action( 'wp_ajax_single_add_to_cart', 'zoa_single_add_to_cart' );
add_action( 'wp_ajax_nopriv_single_add_to_cart', 'zoa_single_add_to_cart' );
if ( ! function_exists( 'zoa_single_add_to_cart' ) ) {
	function zoa_single_add_to_cart() {

		check_ajax_referer( 'zoa_product_nonce', 'nonce' );

		$response = array(
			'status'  => 500,
			'message' => esc_html__( 'Something is wrong, please try again later...', 'zoa' ),
			'content' => false,
		);

		if (
			! isset( $_POST['product_id'] ) ||
			! isset( $_POST['product_qty'] ) ||
			! isset( $_POST['nonce'] )
		) {
			echo json_encode( $response );
			exit();
		}

		$product_id        = absint( sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) );
		$product_qty       = absint( sanitize_text_field( wp_unslash( $_POST['product_qty'] ) ) );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $product_qty );

		if ( isset( $_POST['variation_id'] ) ) {
			$variation_id = sanitize_key( wp_unslash( $_POST['variation_id'] ) );
		}

		if ( isset( $_POST['variations'] ) ) {
			$variations = (array) json_decode( sanitize_text_field( wp_unslash( $_POST['variations'] ) ), true );
		}

		if ( $variation_id && $passed_validation ) {
			WC()->cart->add_to_cart( $product_id, $product_qty, $variation_id, $variations );
		} else {
			WC()->cart->add_to_cart( $product_id, $product_qty );
		}

		$count = WC()->cart->get_cart_contents_count();

		ob_start();

		$response = array(
			'status' => 200,
			'item'   => $count,
		);

		woocommerce_mini_cart();

		$response['content'] = ob_get_clean();

		echo json_encode( $response );
		exit();
	}
}

/*GET NUMBER CURRENT PRODUCT IN CART*/
add_action( 'wp_ajax_get_count_product_already_in_cart', 'zoa_get_count_product_already_in_cart' );
add_action( 'wp_ajax_nopriv_get_count_product_already_in_cart', 'zoa_get_count_product_already_in_cart' );
if ( ! function_exists( 'zoa_get_count_product_already_in_cart' ) ) {
	function zoa_get_count_product_already_in_cart() {
		check_ajax_referer( 'zoa_product_nonce', 'nonce' );
		
		$response = array(
			'in_cart' => 0
		);

		if( ! isset( $_POST['product_id'] ) ){
			echo json_encode( $response );
			exit();
		}

		$product_id  = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );
		$in_cart_qty = zoa_product_check_in( $product_id, $in_cart = false, $qty_in_cart = true );

		ob_start();

		$response['in_cart'] = $in_cart_qty;

		ob_get_clean();

		echo json_encode( $response );
		exit();
	}
}

/**
 * Show or hide product categories and tags based on customizer option
 */

// Remove default single product meta template
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Create custom single product meta template
add_action( 'woocommerce_single_product_summary', 'zoa_template_single_meta', 40 );
if ( ! function_exists( 'zoa_template_single_meta' ) ) {
	function zoa_template_single_meta() {
		global $product;
	    ?>
	    <div class="product_meta">
	    <?php
	        do_action( 'woocommerce_product_meta_start' );

	        if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
	            ?>
	            <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'zoa' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'zoa' ); ?></span></span>
	            <?php
	        }

	        if ( get_theme_mod( 'show_product_category', 'true' ) ) {
	            echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'zoa' ) . ' ', '</span>' );
	        }

	        if ( get_theme_mod( 'show_product_tag' , 'true' ) ) {
	            echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'zoa' ) . ' ', '</span>' );
	        }

	        do_action( 'woocommerce_product_meta_end' );
	        ?>
	    </div>
	    <?php
	}
}
