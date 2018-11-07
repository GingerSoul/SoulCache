<?php
/**
 * Config_Aware_Trait trait.
 *
 * @package SoulPrecache
 */

namespace GingerSoul\SoulPrecache;

use Exception;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 *
 * @package SoulPrecache
 */
trait Config_Aware_Trait {

	/**
	 * The container of services and configuration used by the plugin.
	 *
	 * @since [*next-version*]
	 *
	 * @var ContainerInterface
	 */
	protected $config;

	/**
	 * Retrieves a config value.
	 *
	 * @since [*next-version*]
	 *
	 * @param string $key The key of the config value to retrieve.
	 *
	 * @throws Exception If problem retrieving.
	 *
	 * @return mixed The config value.
	 */
	public function get_config( $key ) {
		return $this->_get_config_container()->get( $key );
	}

	/**
	 * @param $key
	 *
	 * @throws Exception If problem checking.
	 *
	 * @return bool
	 */
	public function has_config( $key ) {
		return $this->_get_config_container()->has( $key );
	}

	/**
	 * Assigns a configuration container for this instance.
	 *
	 * @since [*next-version*]
	 *
	 * @param ContainerInterface $ccontainer The container that holds configuration.
	 */
	protected function _set_config_container( ContainerInterface $ccontainer ) {
		$this->config = $ccontainer;
	}

	/**
	 * Retrieves the configuration container for this instance.
	 *
	 * @since [*next-version*]
	 *
	 * @return ContainerInterface The container that holds configuration.
	 */
	protected function _get_config_container() {
		return $this->config;
	}
}
