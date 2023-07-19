<?php
/**
 * Block Name: Promo Gate Block
 *
 * Description: Content & Form for gated content
 */

// Dynamic block ID
$block_id = 'promo-gate-block-' . $block['id'];

// Check if a custom ID is set in the block editor
if( !empty($block['anchor']) ) {
	$block_id = $block['anchor'];
}

// Block classes
$class_name = 'promo-gate-block';
if( !empty($block['class_name']) ) {
	$class_name .= ' ' . $block['class_name'];
}

// Create id attribute allowing for custom "anchor" value.
$id = 'promo-gate-' . $block['id'];
if( !empty($block['anchor']) ) {
		$id = $block['anchor'];
}

$className = 'promo-gate';
if( !empty($block['className']) ) {
		$className .= ' ' . $block['className'];
}

$promo_gate = get_field( 'promo_gate' );
$form_headline = $promo_gate['form']['headline'];
$form_subtitle = $promo_gate['form']['subtitle'];
$form_id = $promo_gate['form']['form_id'];
$promo_bg_overlay = $promo_gate['background_overlay'];


if ( ! empty( $promo_gate['background_image'] ) ) {
	$promo_gate_bg_image = wp_get_attachment_image_srcset( $promo_gate['background_image']['ID'] );
}

$allowed_blocks = array(
	'core/heading',
	'core/paragraph',
	'core/list',
	'core/column',
);

$template = array(
	array('core/paragraph', array(
		'content' => 'On-demand webinar',
		'className' => 'h4 tracking-normal text-base mb-2',
	)),
	array('core/heading',
		array(
			'level' => 2,
			'content' => 'The Future of Culture Change',
			'className' => 'text-secondary font-harriet-display-regular mb-0',
		)
	),
	array( 'core/paragraph', array(
			'content' => 'Organizations have been trying to change culture for decades. It\'s never been more important than now. With challenges like the great resignation, DE&I, the war on talent, and ESG, this webinar will provide a different way to think about culture and how to be more effective as a culture change leader.',
			'className' => 'font-poppins',
	) ),
	array('core/heading', array(
		'level' => 3,
		'content' => 'What you\'ll learn:',
		'className' => 'text-[24px] tracking-normal normal-case font-harriet-display-regular text-secondary',
	)),
	array('core/list', array(
		'values' => '
		<ul>
			<li>The definition of \'culture\' and how to connect it to performance.</li>
			<li>Our proven 5-step framework for leaders to improve company culture</li>
			<li>How to leverage your company culture to drive the results of your business</li>
			<li>How to create an environment that eliminates burnout, lack of engagement, and leadership gaps</li>
		</ul>',
		'className' => 'promo-gate-list',
	)),
	array('core/heading', array(
		'level' => 3,
		'content' => 'Hosted by Compass, The Culture Division of Insight Global:',
		'className' => 'text-[24px] tracking-normal normal-case font-harriet-display-regular text-secondary',
	)),
);
?>

<section id="<?php echo esc_attr( $id ); ?>" class="grid isolate <?php echo esc_attr( $className ); ?>">
	<?php if ( ! empty( $promo_gate['background_image'] ) ) { ?>
		<picture class="col-span-full row-span-full">
			<img class="w-full h-full object-cover" srcset="<?php echo $promo_gate_bg_image; ?>" alt="" role="presentation">
		</picture>
	<?php } ?>
	<article class="col-span-full row-span-full flex flex-col lg:grid lg:grid-cols-[50%_auto]">
		<div class="lg:pl-[6.25rem] bg-<?php echo $promo_bg_overlay; ?> bg-opacity-90 py-[8vw] text-white px-4 lg:px-0">
			<div class="w-[90%]">
				<InnerBlocks
					allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"
				/>
			</div>
		</div>
		<div class="px-4 lg:px-0 py-[8vw]">
			<div class="two-col-content-copy center bg-[#FAFAFA] p-8 rounded-[10px] max-w-[484px] shadow-[0_0px_10px_rgba(0,40,60,0.13)] mx-auto">
				<?php if( $form_headline )  { ?>
					<h3 class="mb-0 font-bold font-harriet-display-regular text-[24px]"><?php echo $form_headline; ?></h3>
				<?php } ?>
				<?php if ( $form_subtitle ) { ?>
					<p class="text-xl"><?php echo $form_subtitle; ?></p>
				<?php } ?>
				<?php if ( $form_id ) : ?>
					<div class="two-col-content-intro">
						<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
						<script>
							hbspt.forms.create({
								region: "na1",
								portalId: "<?php echo get_field( 'hubspot_portal_id', 'option' ); ?>",
								css: "",
								formId: "<?php echo $form_id; ?>"
							});
						</script>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</section>
