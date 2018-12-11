<?php
/**
 * Index_List_Capable_Trait class.
 *
 * @package SoulCache
 */

namespace GingerSoul\SoulCache;

use Traversable;

trait Index_List_Capable_Trait {

	/**
	 * Indexes a list of entities.
	 *
	 * @since 0.1
	 *
	 * @param array|Traversable $entities A list of entities to index.
	 * @param callable          $value_retriever The callback that will retrieve the value for each index.
	 * @param callable          $index_retriever The callback that will retrieve the index for each post.
	 *
	 * @return array The map of index to entity.
	 */
	protected function index_list( $entities, callable $value_retriever, callable $index_retriever ) {

		$map = [];

		foreach ( $entities as $_idx => $entity ) {
			$index         = call_user_func_array( $index_retriever, [ $entity ] );
			$value         = call_user_func_array( $value_retriever, [ $entity ] );
			$map[ $index ] = $value;
		}

		return $map;
	}
}
