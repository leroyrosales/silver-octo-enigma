<?php
/**
 * Functions to enhance Gutenberg in WordPress
 *
 * @package Insight Gloabl Compass
 *
 **/

// Add branded colors to palette/color selectors
function ig_grit_editor_color_palette() {
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Primary', 'ig-grit' ),
			'slug'  => 'primary',
			'color' => '#00283c',
		),
		array(
			'name'  => __( 'Secondary', 'ig-grit' ),
			'slug'  => 'secondary',
			'color' => '#ff0069',
		),
		array(
			'name'  => __( 'Tertiary', 'ig-grit' ),
			'slug'  => 'tertiary',
			'color' => '#ffd602',
		),
		array(
			'name'  => __( 'Accent', 'ig-grit' ),
			'slug'  => 'accent',
			'color' => '#00d6e6',
		),
		array(
			'name'  => __( 'Grey', 'ig-grit' ),
			'slug'  => 'grey',
			'color' => '#f2f2f2',
		),
		array(
			'name'  => __( 'Grey Dark', 'ig-grit' ),
			'slug'  => 'grey-dark',
			'color' => '#555',
		),
		array(
			'name'  => __( 'Black', 'ig-grit' ),
			'slug'  => 'black',
			'color' => '#172021',
		),
		array(
			'name'  => __( 'White', 'ig-grit' ),
			'slug'  => 'white',
			'color' => '#FFFFFF',
		),
		array(
			'name'  => __( 'Light Blue', 'ig-grit' ),
			'slug'  => 'light-blue',
			'color' => '#b4e3e5',
		),
	) );
}
add_action( 'after_setup_theme', 'ig_grit_editor_color_palette' );

// Disable custom color picker
add_theme_support( 'disable-custom-colors' );

// -- Disable Gradients
add_theme_support( 'disable-custom-gradients' );
add_theme_support('editor-gradient-presets', array(
	array(
		'name' => __('Fade out', 'ig-grit'),
		'gradient' => 'linear-gradient(180deg, rgba(255,255,0,1) 0%, rgba(255,255,0,0) 100%)',
		'slug' => 'fade-out'
	),
		array(
		'name' => __('Purple to Orange', 'ig-grit'),
		'gradient' => 'linear-gradient(83.26deg, #8D6465 19.68%, #6F42B5 100.68%)',
		'slug' => 'purple'
	),
));

add_theme_support( 'align-wide' );

// Custom Blocks category
function ig_grit_register_block_categories( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'compass',
				'title' => __( 'Compass', 'ig-grit' ),
			),
		)
	);
}
add_action( 'block_categories_all', 'ig_grit_register_block_categories', 10, 2 );

// Register ACF blocks via PHP templating

add_action( 'acf/init', 'register_acf_ig_grit_blocks' );
function register_acf_ig_grit_blocks() {
	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// Register blog carousel block
		acf_register_block_type( array(
			'name'              => 'acf/blog-carousel',
			'title'             => __( 'Compass Blog Carousel' ),
			'description'       => __( 'Displays recent or selected post query.' ),
			'render_template'   => './blocks/blog-carousel/block.php',
			'category'          => 'formatting',
		));

		// Register events carousel block
		acf_register_block_type( array(
			'name'              => 'acf/events-carousel',
			'title'             => __( 'Compass Events Carousel' ),
			'description'       => __( 'Displays a carousel of events.' ),
			'render_template'   => './blocks/events-carousel/block.php',
			'category'          => 'formatting',
			'supports'		=> array(
				'align'			=> false,
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
			)
		));

		acf_register_block_type( array(
					'name'            => 'acf/culture-tap-card',
					'title'           => 'Culture Tap Card',
					'description'     => 'Card view for Culture Tap blogroll',
					'render_template' => '/blocks/culture-tap-card/block.php',
					'category'        => 'formatting',
					'icon'            => 'admin-comments',
					'api_version'     => 2,
					'keywords'        => array( 'culture tap', 'cards' ),
					'mode'            => 'preview',
		));

		acf_register_block_type( array(
			'name'            => 'acf/promo-gate',
			'title'           => 'Promo Gate',
			'description'     => 'Content & Form for gated content',
			'render_template' => '/blocks/promo-gate/block.php',
			'category'        => 'formatting',
			'icon'            => 'lock',
			'api_version'     => 2,
			'keywords'        => array( 'promo gate', 'promo', 'gate', 'compass' ),
			'supports'        => array(
					'align'           => false,
					'anchor'          => true,
					'customClassName' => true,
					'jsx'             => true,
			),
			'mode'            => 'preview',

		));

	}
}

/*
 * Blacklist specific Gutenberg blocks
 *
 * @author Misha Rudrastyh
 * @link https://rudrastyh.com/gutenberg/remove-default-blocks.html#blacklist-blocks
 */
add_filter( 'allowed_block_types_all', 'ig_grit_blacklist_blocks' );

function ig_grit_blacklist_blocks( $allowed_blocks ) {
	// get all the registered blocks
	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// then disable some of them
	unset( $blocks[ 'core/video' ] );
	unset( $blocks[ 'core/embed' ] );

	// return the new list of allowed blocks
	return array_keys( $blocks );

}
