<?php

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
        'version'                                => '[*next-version*]',
        'base_path'                              => $base_path,
        'base_dir'                               => function ( ContainerInterface $c ) {
            return dirname( $c->get( 'base_path' ) );
        },
        'base_url'                               => $base_url,
        'js_path'                                => '/assets/js',
        'templates_dir'                          => '/templates',
        'translations_dir'                       => '/languages',
        'text_domain'                            => 'soulprecache',

        'plugin'                                 => function ( ContainerInterface $c ) {
            return new Plugin( $c );
        },

        'template_path_factory'                  => function ( ContainerInterface $c ) {
            $baseDir      = rtrim( $c->get( 'base_dir' ), '\\/' );
            $templatesDir = trim( $c->get( 'templates_dir' ), '\\/' );

            return function ( $name ) use ( $baseDir, $templatesDir ) {
                $name = trim( $name, '\\/' );

                return "$baseDir/$templatesDir/$name";
            };
        },

        /*
         * Makes templates.
         *
         * @since [*next-version*]
         */
        'template_factory'                       => function ( ContainerInterface $c ) {
            return function ( $path ) {
                return new PHP_Template( $path );
            };
        },

        /*
         * Makes blocs.
         *
         * @since [*next-version*]
         */
        'block_factory'                          => function ( ContainerInterface $c ) {
            return function ( PHP_Template $template, $context ) {
                return new Template_Block( $template, $context );
            };
        },

        /*
         * List of handlers to run.
         *
         * @since [*next-version*]
         */
        'handlers'                               => function ( ContainerInterface $c ) {
            return [
            ];
        },
    ];
};
