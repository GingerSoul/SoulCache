<?php
/**
 * SoulPrecache.
 *
 * @package SoulPrecache
 * @wordpress-plugin
 *
 * Plugin Name: SoulPrecache
 * Description: A plugin for pre-cognitive browser caching of assets.
 * Version: [*next-version*]
 * Author: Anton Ukhanev
 * Author URI: https://twitter.com/XedinUnknown
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: soulprecache
 * Domain Path: /languages
 */

namespace GingerSoul\SoulPrecache;

define( 'SOULPRECACHE_BASE_PATH', __FILE__ );
define( 'SOULPRECACHE_BASE_DIR', dirname( SOULPRECACHE_BASE_PATH ) );


/**
 * Retrieves the plugin singleton.
 *
 * @since 0.1
 *
 * @return null|Plugin
 */
function plugin() {
	static $instance = null;

	if ( is_null( $instance ) ) {
		$bootstrap = require SOULPRECACHE_BASE_DIR . '/bootstrap.php';

		$instance = $bootstrap( SOULPRECACHE_BASE_PATH, plugins_url( '', SOULPRECACHE_BASE_PATH ) );
	}

	return $instance;
}

plugin()->run();
