<?php
/**
 * Asset links template.
 *
 * Generates HTML for links that instruct the browser to pre-load assets.
 *
 * @package SoulPrecache
 */

/**
 * A list of entries representing images.
 *
 * @since [*next-version*]
 * @see https://docs.metabox.io/fields/image-advanced/#template-usage
 *
 * @var array<int, array<string, mixed>>
 */
$images = $c( 'images' );
?>
<?php foreach ( $images as $attachment_id => $image_data ) : ?>
	<link rel="prefetch" href="<?php echo esc_attr( $image_data['url'] ); ?>" />
	<link rel="prefetch" href="<?php echo esc_attr( $image_data['full_url'] ); ?>" />
<?php endforeach; ?>
