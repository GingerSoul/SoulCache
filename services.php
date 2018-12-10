<?php
/**
 * Asset_Links_Handler class.
 *
 * @package SoulCache
 */

use GingerSoul\SoulCache\Asset_Links_Handler;
use GingerSoul\SoulCache\Fields_Types_Handler;
use GingerSoul\SoulCache\Pre_Requisites_Handler;
use Psr\Container\ContainerInterface;
use GingerSoul\SoulCache\Plugin;
use GingerSoul\SoulCache\PHP_Template;
use GingerSoul\SoulCache\Template_Block;

/**
 * Factory of the service map.
 *
 * @since 0.1
 *
 * @param string $base_path The root directory of the application.
 * @param string $base_url The root URL of the application.
 *
 * @return array<string, mixed> The map of service names to definitions.
 */
return function ( $base_path, $base_url ) {
	return [
		'version'                    => '0.1',
		'base_path'                  => $base_path,
		'base_dir'                   => function ( ContainerInterface $c ) {
			return dirname( $c->get( 'base_path' ) );
		},
		'base_url'                   => $base_url,
		'js_path'                    => '/assets/js',
		'templates_dir'              => '/templates',
		'translations_dir'           => '/languages',
		'text_domain'                => 'soulcache',

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
		 * @since 0.1
		 */
		'template_factory'           => function ( ContainerInterface $c ) {
			return function ( $path ) {
				return new PHP_Template( $path );
			};
		},

		/*
		 * Makes blocs.
		 *
		 * @since 0.1
		 */
		'block_factory'              => function ( ContainerInterface $c ) {
			return function ( PHP_Template $template, $context ) {
				return new Template_Block( $template, $context );
			};
		},

		/*
		 * List of handlers to run.
		 *
		 * @since 0.1
		 */
		'handlers'                   => function ( ContainerInterface $c ) {
			return [
				$c->get( 'handler_fields_types' ),
				$c->get( 'handler_asset_links' ),
				$c->get( 'handler_pre_requisites' ),
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
						[
							'name'              => __( 'Pre-Render Page' ),
							'id'                => 'prerender_posts_page',
							'label_description' => __( 'A page that should be pre-rendered when viewing this post' ),
							'std'               => '',
							'type'              => 'post',
							'post_type'         => 'page',
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

		'tgmpa'                      => function ( ContainerInterface $c ) {
			$tgmpa = TGM_Plugin_Activation::get_instance();

			$tgmpa->config(
				[
					'id'           => $c->get( 'text_domain' ), // Unique ID for hashing notices for multiple instances of TGMPA.
					'menu'         => 'tgmpa-install-plugins',  // Menu slug.
					'parent_slug'  => 'plugins.php',            // Parent menu slug.
					'capability'   => 'manage_options',         // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
					'has_notices'  => true,                     // Show admin notices or not.
					'dismissable'  => true,                     // If false, a user cannot dismiss the nag message.
					'dismiss_msg'  => '',                       // If 'dismissable' is false, this message will be output at top of nag.
					'is_automatic' => false,                    // Automatically activate plugins after installation or not.
					'message'      => '',                       // Message to output right before the plugins table.
				]
			);

			return $tgmpa;
		},

		'required_plugins'           => function ( ContainerInterface $c ) {
			return [
				[
					'name'     => 'MetaBox',
					'slug'     => 'meta-box',
					'required' => false,
				],
			];
		},

		'handler_pre_requisites'     => function ( ContainerInterface $c ) {
			return new Pre_Requisites_Handler( $c );
		},
	];
};
