<?php
/**
 * Pre_Requisites_Handler class.
 *
 * @package SoulCache
 */

namespace GingerSoul\SoulCache;

use Exception;
use TGM_Plugin_Activation;
use WP_Post;

/**
 * Responsible for registering WP-related pre-requisites.
 *
 * @since [*next-version*]
 *
 * @package SoulCache
 */
class Pre_Requisites_Handler extends Handler {

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function hook() {
		add_action(
			'plugins_loaded',
			function () {
			    $plugins = $this->get_plugins();
			    $this->register_plugins( $plugins );
			}
		);
	}

    /**
     * Retrieves the list of plugins to depend on.
     *
     * @since [*next-version*]
     *
     * @return array[] A list of data about plugins. See {@link docs http://tgmpluginactivation.com/configuration/}.
     */
	protected function get_plugins() {
        return $this->get_config( 'required_plugins' );
    }

    /**
     * Retrieves the TGMPA instance.
     *
     * @since [*next-version*]
     *
     * @return TGM_Plugin_Activation The TGMPA instance.
     */
    protected function get_tgmpa() {
        return $this->get_config( 'tgmpa' );
    }

    /**
     * Registers plugin dependencies.
     *
     * @since [*next-version*]
     *
     * @param array[] $plugins A list of plugin info structures to register. See {@link docs http://tgmpluginactivation.com/configuration/}.
     */
	protected function register_plugins( $plugins ) {
        $tgmpa = $this->get_tgmpa();

        foreach ( $plugins as $plugin_info ) {
            $tgmpa->register( $plugin_info );
        }
    }

}
