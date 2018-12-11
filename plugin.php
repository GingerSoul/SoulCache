<?php
/**
 * SoulCache.
 *
 * @package SoulCache
 * @wordpress-plugin
 *
 * Plugin Name: SoulCache
 * Description: A plugin for pre-cognitive browser caching of assets.
 * Version: 0.1
 * Author: GingerSoul
 * Author URI: https://github.com/GingerSoul
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: soulcache
 * Domain Path: /languages
 */

namespace GingerSoul\SoulCache;

define( 'SOULCACHE_BASE_PATH', __FILE__ );
define( 'SOULCACHE_BASE_DIR', dirname( SOULCACHE_BASE_PATH ) );


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
		$bootstrap = require SOULCACHE_BASE_DIR . '/bootstrap.php';

		$instance = $bootstrap( SOULCACHE_BASE_PATH, plugins_url( '', SOULCACHE_BASE_PATH ) );
	}

	return $instance;
}

plugin()->run();
