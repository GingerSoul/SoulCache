<?php
/**
 * Handler class.
 *
 * @package SoulPrecache
 */

namespace GingerSoul\SoulPrecache;

use Exception;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * A base class for all handlers.
 *
 * @package SoulPrecache
 *
 * @since [*next-version*]
 */
abstract class Handler {

	/* @since [*next-version*] */
	use Config_Aware_Trait;

	/* @since [*next-version*] */
	use Get_Template_Capable_Trait;

	/**
	 * Handler constructor.
	 *
     * @since [*next-version*]
	 *
	 * @param ContainerInterface $config The configuration of this plugin.
	 */
	public function __construct( ContainerInterface $config ) {
		$this->_set_config_container( $config );
	}

	/**
	 * Runs the plugin.
	 *
     * @since [*next-version*]
	 *
	 * @return mixed
	 */
	public function run() {
		$this->hook();

		return null;
	}

	/**
	 * Procedural way to run the handler.
	 *
     * @since [*next-version*]
	 *
	 * @return mixed The result of handling.
	 */
	public function __invoke() {
		return $this->run();
	}

	/**
	 * Retrieves a URL to the JS directory of the handler.
	 *
     * @since [*next-version*]
	 *
	 * @param string $path The path relative to the JS directory.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return string The absolute URL to the JS directory.
	 */
	protected function get_js_url( $path = '' ) {
		$base_url = $this->get_config( 'base_url' );

		return "$base_url/assets/js/$path";
	}

	/**
	 * Retrieves a URL to the CSS directory of the handler.
	 *
     * @since [*next-version*]
	 *
	 * @param string $path The path relative to the CSS directory.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return string The absolute URL to the CSS directory.
	 */
	protected function get_css_url( $path = '' ) {
		$base_url = $this->get_config( 'base_url' );

		return "$base_url/assets/css/$path";
	}

	/**
	 * Creates a new template block.
	 *
     * @since [*next-version*]
	 *
	 * @param PHP_Template|string $template The template or template key.
	 * @param array               $context The context for the template.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return Template_Block The new block.
	 */
	protected function create_template_block( $template, $context ) {
		if ( ! ( $template instanceof PHP_Template ) ) {
			$template = $this->get_template( (string) $template );
		}

		$factory = $this->get_config( 'block_factory' );

		return $factory( $template, $context );
	}

	/**
	 * Adds handler hooks.
	 *
     * @since [*next-version*]
	 *
	 * @return void
	 */
	abstract protected function hook();
}