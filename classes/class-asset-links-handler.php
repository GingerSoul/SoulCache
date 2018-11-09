<?php
/**
 * Asset_Links_Handler class.
 *
 * @package SoulPrecache
 */

namespace GingerSoul\SoulPrecache;

use Exception;
use WP_Post;

/**
 * Responsible for registering questions and answers related types and relationships between them.
 *
 * @since [*next-version*]
 *
 * @package SoulPrecache
 */
class Asset_Links_Handler extends Handler {

	/* @since [*next-version*] */
	use Index_List_Capable_Trait;

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function hook() {
		add_action(
			'wp_head',
			function () {
				echo $this->get_head_htmL(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped WordPress.XSS.EscapeOutput.OutputNotEscaped .
			}
		);
	}

	/**
	 * Retrieves the HTML that should be injected in the document head.
	 *
	 * @since [*next-version*]
	 *
	 * @return string The HTML of links to go into the document head.
	 *
	 * @throws Exception If problem retrieving.
	 */
	protected function get_head_htmL() {
		$post = get_post();

		// No current post.
		if ( is_null( $post ) ) {
			return '';
		}

		// Pre-caching not enabled for post.
		if ( ! $this->is_precaching_enabled_for_post( $post ) ) {
			return '';
		}

		$images = $this->get_precache_images( $post );
		$pages = $this->get_precache_post_urls( $post );

		return $this->get_template( 'asset-links' )->render(
			[
				'images' => $images,
				'pages'  => $pages,
			]
		);
	}

	/**
	 * Retrieves data about images which should be pre-cached for the given post.
	 *
	 * @since [*next-version*]
	 *
	 * @param WP_Post $post The post to get the images for.
	 *
	 * @return array[] See {@link https://docs.metabox.io/fields/image-advanced/#template-usage}.
	 */
	protected function get_precache_images( WP_Post $post ) {
		return rwmb_meta( 'precache_post_images', [
			'size' => 'thumbnail',
		], $post->ID );
	}

	/**
	 * Retrieves URLs to pre-fetch for the given post.
	 *
	 * @since [*next-version*]
	 *
	 * @param WP_Post $post The post to get the pre-fetch URLs for.
	 *
	 * @return string[] List of post URLs to pre-fetch.
	 */
	protected function get_precache_post_urls( WP_Post $post ) {
		$post_ids = $this->get_precache_post_ids( $post );
		$post_urls = $this->index_list(
			$post_ids,
			function ( $value ) {
				return get_permalink( $value );
			},
			function ( $value ) {
				return $value;
			}
		);

		return $post_urls;
	}

	/**
	 * Retrieves IDs of posts to pre-fetch.
	 *
	 * @since [*next-version*]
	 *
	 * @param WP_Post $post The post to pre-fetch the pages for.
	 *
	 * @return int[] The list of IDs of posts to pre-fetch the URLs for.
	 */
	protected function get_precache_post_ids( WP_Post $post ) {
		return rwmb_meta( 'precache_posts_page', [], $post->ID );
	}

	/**
	 * Determines whether pre-caching is enabled for the given post.
	 *
	 * @since [*next-version*]
	 *
	 * @param WP_Post $post The post to check pre-caching status for.
	 *
	 * @throws Exception If problem determining.
	 *
	 * @return bool True if pre-caching is enabled for the post; false otherwise.
	 */
	protected function is_precaching_enabled_for_post( WP_Post $post ) {
		$type    = $post->post_type;
		$allowed = $this->get_allowed_post_types();

		return in_array( $type, $allowed );
	}

	/**
	 * Retrieves post types for which pre-caching is enabled.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return string[] A list of post type codes.
	 */
	protected function get_allowed_post_types() {
		return $this->get_config( 'precache_for_post_types' );
	}
}
