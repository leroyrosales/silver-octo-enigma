<?php

// Removes read more link
add_filter( 'excerpt_more', 'ig_grit_remove_excerpt_read_more_link' );
function ig_grit_remove_excerpt_read_more_link( $more ) {
	echo '';
}

// Trim excerpts to 140 characters
add_filter('wp_trim_excerpt', function( $text ){
	$max_length = 140;

	if(mb_strlen($text, 'UTF-8') > $max_length){
		$split_pos = mb_strpos(wordwrap($text, $max_length), "\n", 0, 'UTF-8');
		$text = mb_substr($text, 0, $split_pos, 'UTF-8');
	}

	return $text . '...';
});

// Post Thumb image size
// https://www.figma.com/file/m56p1QuNmw5P9UD4HUccsr/News%2FCompass?node-id=19%3A1247&t=2FiBHb1kBULTtU7t-0
add_image_size( 'post-thumb', 367, 367, true );

// Returns empty description for nav menu
// add_filter('wp_get_nav_menu_items', 'compass_empty_nav_descriptions', 10, 3);
// function compass_empty_nav_descriptions($items, $menu, $args) {
// 		foreach($items as $key => $item)
// 				$items[$key]->description = '';

// 		return $items;
// }

/* Move all blog posts to /culture-tap/post-title url structure */
function ig_grit_single_post_permalink( $args, $post_type ) {
	if ( 'post' == $post_type ) {
		$args['rewrite'] = array(
			'slug' => 'culture-tap'
		);
	}

	return $args;
}
add_filter( 'register_post_type_args', 'ig_grit_single_post_permalink', 20, 2 );

/* Fixes any existing permalinks */
function ig_grit_change_posts_permalink( $permalink, $post ) {
	if ( 'post' == get_post_type( $post ) ) {
		return "/culture-tap" . $permalink;
	}
	return $permalink;
}
add_filter( 'pre_post_link', 'ig_grit_change_posts_permalink', 10, 3 );

/*
 * Remove a link from the Yoast SEO breadcrumbs
 * Credit: https://timersys.com/remove-link-yoast-breadcrumbs/
 */
add_filter( 'wpseo_breadcrumb_single_link' ,'ig_wpseo_remove_breadcrumb_link', 10 ,2);

function ig_wpseo_remove_breadcrumb_link( $link_output , $link ){
		$text_to_remove = 'Home';

		if( $link['text'] == $text_to_remove ) {
			$link_output = '<a href="'. site_url() .'"><svg viewBox="0 0 14 12" class="home-breadcrumb" xmlns="http://www.w3.org/2000/svg">
			<path d="M5.66665 11.3333V7.33333H8.33331V11.3333H11.6666V6H13.6666L6.99998 0L0.333313 6H2.33331V11.3333H5.66665Z" />
			</svg></a>';
		}

		return $link_output;
}
