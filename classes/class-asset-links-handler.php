<?php
/**
 * Asset_Links_Handler class.
 *
 * @package SoulPrecache
 */

namespace GingerSoul\SoulPrecache;

use WP_Post;

/**
 * Responsible for registering questions and answers related types and relationships between them.
 *
 * @since [*next-version*]
 *
 * @package SoulPrecache
 */
class Asset_Links_Handler extends Handler {
	public function hook() {
		add_action(
			'wp_head',
			function () {
				echo $this->get_head_htmL();
			}
		);
	}

	protected function get_head_htmL() {
		$post = get_post();

		// No current post
		if ( is_null( $post ) ) {
			return '';
		}

		// Pre-caching not enabled for post
		if ( ! $this->is_precaching_enabled_for_post( $post ) ) {
			return '';
		}

		$images = $this->get_precache_images( $post );
		return $this->get_template( 'asset-links' )->render(
			[
				'images' => $images,
			]
		);
	}

	protected function get_precache_images( WP_Post $post ) {
		return rwmb_meta( 'precache_post_images', [ 'size' => 'thumbnail' ], $post->ID );
	}

	protected function is_precaching_enabled_for_post( WP_Post $post ) {
		$type    = $post->post_type;
		$allowed = $this->get_allowed_post_types();

		return in_array( $type, $allowed );
	}

	protected function get_allowed_post_types() {
		return $this->get_config( 'precache_for_post_types' );
	}
}
