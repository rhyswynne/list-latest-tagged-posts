<?php

/**
 *
 *
 * @package
 * @version
 */
/*
Plugin Name: List Latest Tagged Posts
Plugin URI: http://winwar.co.uk/plugins/list-latest-tagged-posts/
Description: Lists the latest posts associated with a tag, accessible via a shortcode.
Version: 1.0.2
Author: Winwar Media
Author URI: http://winwar.co.uk
Tags: list, tags, tagged, wpquery
License: GPLv2 or later
Text Domain: 
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/**
 * Get the latest posts associated with a tag.
 *
 * @param string  $tag the tag you wish to search for.
 * @param int     $int the amount of posts to return.
 * @return string  $lttpstring the HTML String with the latest posts associated with it.
 */
function lltp_get_latest_posts( $tag = "", $limit = -1 ) {

	$lttpstring = "";

	/**
	 * The WordPress Query class.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/WP_Query
	 *
	 */
	$lttpargs = array(
		'tag'           => $tag,
		'posts_per_page' => $limit
	);

	$lttpquery = new WP_Query( $lttpargs );

	if ( $lttpquery->have_posts() ) {

		$lttpstring = '<ul class="lttplist">';

		while ( $lttpquery->have_posts() ) {

			$lttpquery->the_post();

			$lttpstring .= '<li><a href="' . get_the_permalink() . '" title="'. the_title_attribute( array( 'echo' => FALSE ) ) .'">' . get_the_title() . '</a></li>';

		}

		$lttpstring .= '</ul>';

	}

	wp_reset_postdata();

	return $lttpstring;

}


/**
 * Parses the shortcode & attributes.
 * @param  string $atts 					The string listed of all the attributes.
 * @return string $shortcodereturnstring	The returned shortcode string from lltp_get_latest_posts()
 */
function lltp_shortcode( $atts ) {
	$atts = shortcode_atts( array(
			'tag' => '',
			'limit' => ''
		), $atts );

	$shortcodereturnstring = "";
	$shortcodereturnstring = lltp_get_latest_posts( $atts['tag'], $atts['limit'] );

	return $shortcodereturnstring;
}
add_shortcode( 'latest_tag_posts', 'lltp_shortcode' );
