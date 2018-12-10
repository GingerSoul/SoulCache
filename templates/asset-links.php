<?php
/**
 * Asset links template.
 *
 * Generates HTML for links that instruct the browser to pre-load assets.
 *
 * @package SoulCache
 */

/**
 * A list of entries representing images.
 *
 * @since 0.1
 * @see https://docs.metabox.io/fields/image-advanced/#template-usage
 *
 * @var array<int, array<string, mixed>>
 */
$images = $c( 'images' );

/**
 * A list of URLs of pages.
 *
 * @since 0.1
 *
 * @var string[]
 */
$page_urls = $c( 'pages' );
?>
<?php foreach ( $images as $attachment_id => $image_data ) : ?>
	<link rel="prefetch" href="<?php echo esc_attr( $image_data['full_url'] ); ?>" />
<?php endforeach; ?>

<?php foreach ( $page_urls as $page_url ) : ?>
	<link rel="prerender" href="<?php echo esc_attr( $page_url ); ?>" />
<?php endforeach; ?>
