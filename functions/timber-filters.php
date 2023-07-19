<?php

function ig_grit_timber_blocks() {
	return ['blocks'];
}
add_filter( 'timber/acf-gutenberg-blocks-templates', 'ig_grit_timber_blocks' );

function ig_get_author_image( $post_id ) {

	$author = get_the_author_meta( 'display_name' );
	$author_id = get_post_field( 'post_author' );

	// Getting author profile image
	$author_img_field = get_field( 'author_photo', 'user_' . $author_id );
	if ( $author_img_field ) {
		$author_img = $author_img_field['sizes']['thumbnail'];
	}
	// Get default from options
	$default_photo_id = get_option( 'options_default_author_image' );
	$default_photo = wp_get_attachment_image_src( $default_photo_id, 'thumbnail' )[0];

	$author_photo = isset( $author_img ) ? $author_img : $default_photo;

	return $author_photo;

}

// Returns empty description for nav menu
add_filter('wp_get_nav_menu_items', 'ig_grit_empty_nav_descriptions', 10, 3);
function ig_grit_empty_nav_descriptions($items, $menu, $args) {
		foreach($items as $key => $item)
				$items[$key]->description = '';

		return $items;
}
