<?php
/**
 * Asset_Links_Handler class.
 *
 * @package SoulPrecache
 */

use GingerSoul\SoulPrecache\Asset_Links_Handler;
use GingerSoul\SoulPrecache\Fields_Types_Handler;
use Psr\Container\ContainerInterface;
use GingerSoul\SoulPrecache\Plugin;
use GingerSoul\SoulPrecache\PHP_Template;
use GingerSoul\SoulPrecache\Template_Block;

/**
 * Factory of the service map.
 *
 * @since [*next-version*]
 *
 * @param string $base_path The root directory of the application.
 * @param string $base_url The root URL of the application.
 *
 * @return array<string, mixed> The map of service names to definitions.
 */
return function ( $base_path, $base_url ) {
	return [
		'version'                    => '[*next-version*]',
		'base_path'                  => $base_path,
		'base_dir'                   => function ( ContainerInterface $c ) {
			return dirname( $c->get( 'base_path' ) );
		},
		'base_url'                   => $base_url,
		'js_path'                    => '/assets/js',
		'templates_dir'              => '/templates',
		'translations_dir'           => '/languages',
		'text_domain'                => 'soulprecache',

		'plugin'                     => function ( ContainerInterface $c ) {
			return new Plugin( $c );
		},

		'template_path_factory'      => function ( ContainerInterface $c ) {
			$base_dir      = rtrim( $c->get( 'base_dir' ), '\\/' );
			$templates_dir = trim( $c->get( 'templates_dir' ), '\\/' );

			return function ( $name ) use ( $base_dir, $templates_dir ) {
				$name = trim( $name, '\\/' );

				return "$base_dir/$templates_dir/$name";
			};
		},

		/*
		 * Makes templates.
		 *
		 * @since [*next-version*]
		 */
		'template_factory'           => function ( ContainerInterface $c ) {
			return function ( $path ) {
				return new PHP_Template( $path );
			};
		},

		/*
		 * Makes blocs.
		 *
		 * @since [*next-version*]
		 */
		'block_factory'              => function ( ContainerInterface $c ) {
			return function ( PHP_Template $template, $context ) {
				return new Template_Block( $template, $context );
			};
		},

		/*
		 * List of handlers to run.
		 *
		 * @since [*next-version*]
		 */
		'handlers'                   => function ( ContainerInterface $c ) {
			return [
				$c->get( 'handler_fields_types' ),
				$c->get( 'handler_asset_links' ),
			];
		},

		'metaboxes'                  => function ( ContainerInterface $c ) {
			return [
				[
					'title'      => __( 'Pre-Cache Assets' ),
					'post_types' => $c->get( 'precache_images_post_types' ),
					'fields'     => [
						[
							'name'              => __( 'Images' ),
							'id'                => 'precache_post_images',
							'label_description' => __( 'Images that should be pre-cached when viewing this post' ),
							'std'               => '',
							'type'              => 'image_advanced',
						],
					],
				],
			];
		},

		'precache_images_post_types' => function ( ContainerInterface $c ) {
			return [
				'page',
			];
		},

		'precache_for_post_types'    => function ( ContainerInterface $c ) {
			$types = [];

			foreach ( [ 'precache_images_post_types' ] as $service_id ) {
				$list  = $c->get( $service_id );
				$types = array_flip(
					array_merge(
						array_flip( $types ),
						array_flip( $list )
					)
				);
			}

			return $types;
		},

		'handler_fields_types'       => function ( ContainerInterface $c ) {
			return new Fields_Types_Handler( $c );
		},

		'handler_asset_links'        => function ( ContainerInterface $c ) {
			return new Asset_Links_Handler( $c );
		},
	];
};
