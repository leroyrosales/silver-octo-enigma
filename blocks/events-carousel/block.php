<?php
/**
 * Block Name: IG Events Carousel Block
 *
 * Description: Displays a carousel of events.
 */

// Dynamic block ID
$block_id = 'events-carousel-block-' . $block['id'];

// Check if a custom ID is set in the block editor
if( !empty($block['anchor']) ) {
	$block_id = $block['anchor'];
}

// Block classes
$class_name = 'events-carousel-block';
if( !empty($block['class_name']) ) {
	$class_name .= ' ' . $block['class_name'];
}

// WP Query Args
$query_args = array(
	'post__in' => array('155', '153', '145', '158', '1191' ),
	'post_type' => 'events',
	'posts_per_page' => -1,
	'post_status' => 'publish',
);

// Create a new WP_Query instance
$events_query = new WP_Query( $query_args );

// Create id attribute allowing for custom "anchor" value.
$id = 'events-carousel-' . $block['id'];
if( !empty($block['anchor']) ) {
		$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'events-loop';
if( !empty($block['className']) ) {
		$className .= ' ' . $block['className'];
}

$allowed_blocks = array(
	'core/heading',
	'core/paragraph'
);

$template = array(
	array('core/heading', array(
		'level' => 2,
		'content' => 'What you\'ll do',
	)),
	array('core/heading', array(
		'level' => 3,
		'content' => 'Curate a workshop series',
		'className' => 'h4'
	)),
	array( 'core/paragraph', array(
			'content' => 'From one to all five, choose which workshops make sense for your team. Then dive in, working interactively to learn concepts, create dialogue and make decisions your team can implement right away.',
	) )
);
?>

<section id="<?php echo esc_attr( $id ); ?>" class="px-4 lg:px-0 py-16 <?php echo esc_attr( $className ); ?>">
	<article class="flex flex-col lg:grid lg:grid-cols-[55%_45%] md:gap-4 lg:gap-24">
		<div class="lg:pl-[6.25rem]">
			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
		</div>
		<div>
		<?php
		if( $events_query->have_posts() ) { ?>
			<div class="events-carousel-slider">
				<div class="blaze-container">
					<div class="blaze-track-container">
						<div class="blaze-track">
							<?php
							while( $events_query->have_posts() ) {
								$events_query->the_post();
								?>
								<article class="flex flex-col">
									<picture class="">
										<?php echo get_the_post_thumbnail( '', 'medium', array( 'class' => 'w-full h-[180px] md:h-[220px] object-cover' ) ); ?>
									</picture>
									<div class="pl-4 pt-6 lg:p-8 bg-off-white flex-1">
										<div class="">
											<h3 class="text-[1.875rem] mb-2"><a class="not-italic no-underline" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<p><?php the_excerpt(); ?></p>
										</div>
									</div>
								</article>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="blaze-pagination py-8"></div>
			</div>
		<?php } ?>
		</div>
	</article>
</section>
