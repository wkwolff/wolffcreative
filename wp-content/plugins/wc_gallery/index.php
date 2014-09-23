<?php
/**
 * Plugin Name: Wolff Creative Image Gallery
 * Plugin URI: http://wolffcreative.com
 * Description: A simple plugin that adds custom post types and taxonomies
 * Version: 0.1
 * Author: W. Kevin Wolff
 * Author URI: http://wolffcreative.com
 * License: GPL2
 */

/*  Copyright 2014  W. Kevin Wolff  (email : kwolff@wolffcreative.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
                
function wc_gallery() {
    
    $labels = array(
        'name'               => 'Gallery',
        'singular_name'      => 'Gallery',
        'menu_name'          => 'Gallery',
        'name_admin_bar'     => 'Gallery',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Gallery',
        'new_item'           => 'New Gallery',
        'edit_item'          => 'Edit Gallery',
        'view_item'          => 'View Gallery',
        'all_items'          => 'All Gallerys',
        'search_items'       => 'Search Gallerys',
        'parent_item_colon'  => 'Parent Gallerys:',
        'not_found'          => 'No gallerys found.',
        'not_found_in_trash' => 'No gallerys found in Trash.',
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-format-image',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'gallerys' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'wc_gallery', $args );
	$tax_args = array(
		'label' => 'Gallery Categories',
		'hierarchical' => true
	);
	register_taxonomy( 'gallery-cat', 'wc_gallery', $tax_args );
}
add_action( 'init', 'wc_gallery' );

// Flush rewrite rules to add "review" as a permalink slug
function my_rewrite_flush() {
    wc_gallery();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

// Little function to return a custom field value
function wpshed_get_custom_field( $value ) {
    global $post;
 
    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
        return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );
 
    return false;
}

// Register the Metabox
function wpshed_add_custom_meta_box() {
    add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'textdomain' ), 'wpshed_meta_box_output', 'wc_gallery', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wpshed_add_custom_meta_box' );

 
// Output the Metabox
function wpshed_meta_box_output( $post ) {
    // create a nonce field
    wp_nonce_field( 'my_wpshed_meta_box_nonce', 'wpshed_meta_box_nonce' ); ?>
    
    <p>
        <label for="wpshed_textfield"><?php _e( 'Textfield', 'textdomain' ); ?>:</label>
        <input type="text" name="wpshed_textfield" id="wpshed_textfield" value="<?php echo wpshed_get_custom_field( 'wpshed_textfield' ); ?>" size="50" />
    </p>
    
    <p>
        <label for="wpshed_textarea"><?php _e( 'Textarea', 'textdomain' ); ?>:</label><br />
        <textarea name="wpshed_textarea" id="wpshed_textarea" cols="60" rows="4"><?php echo wpshed_get_custom_field( 'wpshed_textarea' ); ?></textarea>
    </p>
    
    <?php
    
	$taxonomies=get_terms('gallery-cat', array('hide_empty' => false));
	print_r($taxonomies);
	echo '
	<select>
		';
		foreach ($taxonomies as $taxonomy ) {
		echo '<option value="'.$taxonomy->term_id.'">'. $taxonomy->name. '</option>';
		}
		echo '
	</select>
	';
}
 
// Save the Metabox values
function wpshed_meta_box_save( $post_id ) {
    // Stop the script when doing autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
    // Verify the nonce. If insn't there, stop the script
    if( !isset( $_POST['wpshed_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpshed_meta_box_nonce'], 'my_wpshed_meta_box_nonce' ) ) return;
 
    // Stop the script if the user does not have edit permissions
    if( !current_user_can( 'edit_post' ) ) return;
 
    // Save the textfield
    if( isset( $_POST['wpshed_textfield'] ) )
        update_post_meta( $post_id, 'wpshed_textfield', esc_attr( $_POST['wpshed_textfield'] ) );
 
    // Save the textarea
    if( isset( $_POST['wpshed_textarea'] ) )
        update_post_meta( $post_id, 'wpshed_textarea', esc_attr( $_POST['wpshed_textarea'] ) );
}
add_action( 'save_post', 'wpshed_meta_box_save' );
