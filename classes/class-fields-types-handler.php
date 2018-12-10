<?php
/**
 * Fields_Types_Handler class.
 *
 * @package SoulCache
 */

namespace GingerSoul\SoulCache;

use Exception;
use Psr\Container\ContainerInterface;

/**
 * Responsible for registering questions and answers related types and relationships between them.
 *
 * @since [*next-version*]
 *
 * @package SoulCache
 */
class Fields_Types_Handler extends Handler {

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	protected function hook() {
		add_filter(
			'rwmb_meta_boxes',
			function ( $metaboxes ) {
				return $this->add_metaboxes( $metaboxes );
			}
		);
	}

	/**
	 * Adds metabox entries to current list.
	 *
	 * Mostly intended to handle the `rwmb_meta_boxes` filter.
	 *
	 * @since [*next-version*]
	 * @see https://docs.metabox.io/extensions/mb-term-meta/#example
	 *
	 * @param int[] $metaboxes The current list of metabox entries.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return int[] The new list of metabox entries.
	 */
	protected function add_metaboxes( $metaboxes ) {
		return array_merge( $metaboxes, $this->get_metaboxes() );
	}

	/**
	 * Retrieves the metaboxes to create.
	 *
	 * @since [*next-version*]
	 *
	 * @see https://docs.metabox.io/extensions/mb-term-meta/
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return array[] An array of MetaBox entries, each describing a metabox.
	 */
	protected function get_metaboxes() {
		return (array) $this->get_config( 'metaboxes' );
	}
}
