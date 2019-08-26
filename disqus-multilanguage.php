<?php
/**
 * Plugin Name:     Disqus Multilanguage
 * Plugin URI:      https://webikon.eu
 * Description:     Add multilanguage compatibility with Polylang and WPML.
 * Version:         1.0.0
 * Author:          Pavol Caban
 * Author URI:      https://webikon.eu
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:     disqus-multilanguage
 * Domain Path:     /languages
 *
 * Disqus Multilanguage is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Disqus Multilanguage is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Disqus Multilanguage. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise the internationalisation domain.
 */
function disqus_multilanguage_load_plugin_textdomain() {
    load_plugin_textdomain( 'disqus-multilanguage', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'disqus_multilanguage_load_plugin_textdomain' );

/**
 * Enqueue needed script.
 */
function disqus_multilanguage_enqueue_script() {
	// Don't load anything when no multilanguage plugin is used.
	if ( ! function_exists( 'pll_current_language' ) && ! defined( 'ICL_LANGUAGE_CODE' ) ) {
		return;
	}
	
	wp_enqueue_script( 'disqus-multilanguage-js', plugin_dir_url( __FILE__ ) . '/assets/js/disqus-multilanguage.js', array(), '1.0.0', true );
	
	wp_localize_script( 'disqus-multilanguage-js', 'disqus_multilanguage', array(
		'language' => disqus_multilanguage_get_current_language(),
	) );
}
add_action( 'wp_enqueue_scripts', 'disqus_multilanguage_enqueue_script' );

/**
 * Get current language depending on used multilanguage plugin.
 * We need 2-letters code.
 */
function disqus_multilanguage_get_current_language() {
	$lang = '';

	// Polylang compatibility
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
	}

	// WPML compatibility
	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		$lang = ICL_LANGUAGE_CODE;
	}

	return $lang;
}