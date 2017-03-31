<?php
/**
 * @package Make
 */

global $ttfmake_section_data, $ttfmake_gallery_id;

$section_name = "ttfmake-section[{{ get('parentID') }}][gallery-items][{{ id }}]";
$combined_id = "{{ get('parentID') }}-{{ id }}";
$overlay_id  = "ttfmake-overlay-" . $combined_id;
?>

<div class="ttfmake-gallery-item" id="ttfmake-gallery-item-{{ id }}" data-id="{{ id }}" data-section-type="gallery-item">

	<div title="<?php esc_attr_e( 'Drag-and-drop this item into place', 'make' ); ?>" class="ttfmake-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<?php echo ttfmake_get_builder_base()->add_uploader( $section_name, 0, __( 'Set gallery image', 'make' ), 'image-url' ); ?>

	<a href="#" class="configure-gallery-item-link ttfmake-overlay-open" title="<?php esc_attr_e( 'Configure item', 'make' ); ?>" data-overlay="#<?php echo $overlay_id; ?>">
		<span>
			<?php esc_html_e( 'Configure item', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="edit-content-link edit-gallery-item-link{{ get('description') && ' item-has-content' || ''}}" data-textarea="ttfmake-content-<?php echo $combined_id; ?>" title="<?php esc_attr_e( 'Edit content', 'make' ); ?>">
		<span>
			<?php esc_html_e( 'Edit content', 'make' ); ?>
		</span>
	</a>
	<a href="#" class="remove-gallery-item-link ttfmake-gallery-item-remove" title="<?php esc_attr_e( 'Delete item', 'make' ); ?>">
		<span>
			<?php esc_html_e( 'Delete item', 'make' ); ?>
		</span>
	</a>

	<?php ttfmake_get_builder_base()->add_frame( $combined_id, 'description', '', '', false ); ?>

	<?php
	global $ttfmake_overlay_class, $ttfmake_overlay_id, $ttfmake_overlay_title;
	$ttfmake_overlay_class = 'ttfmake-configuration-overlay';
	$ttfmake_overlay_id    = $overlay_id;
	$ttfmake_overlay_title = __( 'Configure item', 'make' );

	get_template_part( '/inc/builder/core/templates/overlay', 'header' );

	// Print the inputs
	$inputs = $ttfmake_section_data['section']['item'];
	$output = '';

	foreach ( $inputs as $input ) {
		if ( isset( $input['type'] ) && isset( $input['name'] ) ) {
			$output .= ttfmake_create_input( $section_name, $input, array() );
		}
	}

	echo $output;

	get_template_part( '/inc/builder/core/templates/overlay', 'footer' );
	?>
</div>
