<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'ig_grit_register_nav_menus' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	function ig_grit_register_nav_menus() {
		// This is where you register the custom menu locations.
		register_nav_menus(
			array(
				'primary_menu' => __( 'Primary Menu', 'ig-grit' ),
				'footer_menu'  => __( 'First Footer Menu', 'ig-grit' ),
				'second_footer_menu'  => __( 'Second Footer Menu', 'ig-grit' ),
				'third_footer_menu'  => __( 'Third Footer Menu', 'ig-grit' ),
				'fourth_footer_menu'  => __( 'Fourth Footer Menu', 'ig-grit' ),
				'social_menu'  => __( 'Social Footer Menu', 'ig-grit' ),
			)
		);
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['primary_menu'] = new TimberMenu('primary_menu');
		if( has_nav_menu( 'footer_menu' ) ) {
			$context['footer_menu'] = new TimberMenu('footer_menu');
		}
		if( has_nav_menu( 'second_footer_menu' ) ) {
			$context['second_footer_menu'] = new TimberMenu('second_footer_menu');
		}
		if( has_nav_menu( 'third_footer_menu' ) ) {
			$context['third_footer_menu'] = new TimberMenu('third_footer_menu');
		}
		if( has_nav_menu( 'fourth_footer_menu' ) ) {
			$context['fourth_footer_menu'] = new TimberMenu('fourth_footer_menu');
		}
		if( has_nav_menu( 'social_menu' ) ) {
			$context['social_menu'] = new TimberMenu('social_menu');
		}
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();

// Functions
require_once __DIR__ . '/functions/custom-post-types.php';
require_once __DIR__ . '/functions/custom-roles.php';
require_once __DIR__ . '/functions/disable-comments.php';
require_once __DIR__ . '/functions/enqueue.php';
require_once __DIR__ . '/functions/gutenberg.php';
require_once __DIR__ . '/functions/taxonomy-functions.php';
require_once __DIR__ . '/functions/optimize-wp.php';
require_once __DIR__ . '/functions/shortcodes.php';
require_once __DIR__ . '/functions/sidebars.php';
require_once __DIR__ . '/functions/timber-context.php';
require_once __DIR__ . '/functions/timber-filters.php';
require_once __DIR__ . '/functions/timber-functions.php';
require_once __DIR__ . '/functions/theme-filters.php';

// After WordPress is Loaded
add_action(
	'wp_loaded',
	function () {
		require_once( __DIR__ . '/functions/acf.php' );
	},
	11
);

// Removes editor from Appearance and Plugin menu
function ig_grit_hide_editors() {
	remove_action( 'admin_menu', '_add_themes_utility_last', 101 );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
};
add_action( '_admin_menu', 'ig_grit_hide_editors' );

