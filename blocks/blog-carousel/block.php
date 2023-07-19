<?php
/**
 * Block Name: IG Query Block
 *
 * Description: Displays recent or selected post query.
 */

// $data is what we're going to expose to our render template
$data = array(
	'selection_type' => get_field( 'selection_type' ),
	'category' => get_field( 'category' ),
	'select_posts' => get_field('select_posts')
);

// Dynamic block ID
$block_id = 'blog-carousel-block-' . $block['id'];

// Check if a custom ID is set in the block editor
if( !empty($block['anchor']) ) {
	$block_id = $block['anchor'];
}

// Block classes
$class_name = 'blog-carousel-block';
if( !empty($block['class_name']) ) {
	$class_name .= ' ' . $block['class_name'];
}

// WP Query Args
$query_args = array(
	'post_type' => 'post',
	'posts_per_page' => 9,
	'post_status' => 'publish',
);

// If the selection type is "recent", check  for categories and limit
if ( $data['selection_type'] == 'recent' ) {
	$query_args['category__in'] = $data['category'];
}

// If the selection type is "select", pass in the selected post IDs
if ( $data['selection_type'] == 'select' ) {
	$query_args['post__in'] = $data['select_posts'];
	$query_args['orderby']  = 'post__in';
}

// Create a new WP_Query instance
$carousel_query_posts = new WP_Query( $query_args );

// Create id attribute allowing for custom "anchor" value.
$id = 'posts-loop-' . $block['id'];
if( !empty($block['anchor']) ) {
		$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'posts-loop';
if( !empty($block['className']) ) {
		$className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
		$className .= ' align' . $block['align'];
}

?>

<section id="<?php echo esc_attr( $id ); ?>" class="blaze-slider carousel-slider py-16 <?php echo esc_attr( $className ); ?>">
		<?php
		if( $carousel_query_posts->have_posts() ) { ?>
		<div class="blaze-container">
			<div class="blaze-track-container">
				<div class="blaze-track">
					<?php
					while( $carousel_query_posts->have_posts() ) {
						$carousel_query_posts->the_post();
						?>
						<article class="grid isolate">
							<picture class="col-span-full row-span-full">
								<?php echo get_the_post_thumbnail( '', 'medium', array( 'class' => 'w-full h-full object-cover aspect-square' ) ); ?>
							</picture>
							<div class="col-span-full row-span-full px-12 pb-12 bg-black bg-opacity-40 flex flex-col justify-end">
								<div class="">
									<?php if ( has_category() ) { ?>
										<span class="text-base text-white font-din-light uppercase tracking-[.2em]"><?php echo get_the_category()[0]->cat_name; ?></span>
									<?php } ?>
									<h3 class="m-0 text-[3.125rem] <?php echo ( has_category() ) ? 'pt-4' : "pt-8"; ?>"><a class="text-white not-italic no-underline hover:text-primary lg:text-left" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
								</div>
							</div>
						</article>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="blaze-pagination p-8"></div>
</section>
