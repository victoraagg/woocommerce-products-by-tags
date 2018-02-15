<?php
/**
 * Plugin Name: WooCommerce - List Products by Tags
 * Description: List WooCommerce products by tags using a shortcode. Example: [woo_products_by_tags tags="shoes,socks" count="4"]
 * Author: Víctor Alonso
 * Version: 1.0
 * Requires at least: 3.5
 * Tested up to: 3.5
 * Text Domain: -
 * Domain Path: -
 */
function woo_products_by_tags_shortcode( $atts, $content = null ) {
  
	// Attributes
	extract(shortcode_atts(array(
		"tags" => '',
		"count" => ''
	), $atts));
	
	ob_start();

	$args = array( 
		'post_type' => 'product', 
		'posts_per_page' => $count, 
		'product_tag' => $tags 
	);
	$loop = new WP_Query( $args );
	$product_count = $loop->post_count;
	
	if( $product_count > 0 ) :
		while ( $loop->have_posts() ) : $loop->the_post();
			echo '<div class="product">'; 
			echo '<div class="product-image">'; 
			echo '<a href="'.get_the_permalink().'">'; 
			if (has_post_thumbnail()) {
				echo the_post_thumbnail('shop_catalog'); 
			}
			echo '</a>'; 
			echo '</div>'; 
			echo '<div class="product-desc">'; 
			echo '<div class="product-title">'; 
			echo '<a href="'.get_the_permalink().'">'; 
			echo the_title('<h3>','</h3>'); 
			echo '</a>'; 
			echo '</div>';
			echo '<p>'.the_excerpt().'</p>'; 
			echo '</div>';
			echo '</div>';
		endwhile;
	else :
		_e('No product matching your criteria.');
	endif;
	
	return ob_get_clean();
	
}
add_shortcode("woo_products_by_tags", "woo_products_by_tags_shortcode");