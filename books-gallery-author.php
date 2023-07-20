<?php
/**
 * Plugin Name:	Books Gallery Author
 * Plugin URI:	https://wordpress.org/plugins/hm-multiple-roles/
 * Description:	Add custom fields to the Books Gallery author panel.
 * Author:		HM Plugin
 * Author URI:	https://hmplugin.com/
 * Version:		1.0
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * Tested up to:        6.2.2
 * License:             GPLv2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('WBGA_PATH', plugin_dir_path(__FILE__));
define('WBGA_ASSETS', plugins_url('/assets/', __FILE__));
define('WBGA_TXT_DOMAIN', 'books-gallery-author');
define('WBGA_VERSION', '1.0');

add_action( 'plugins_loaded', 'wbga_extension_initialize' );

function wbga_extension_initialize() {

	if ( class_exists( 'WBG_Master' ) ) {
		
		add_action( 'book_author_add_form_fields', 'wbga_book_author_add_form_fields', 10, 2 );

	}
}

// Step1: Add the Image Field
function wbga_book_author_add_form_fields( $taxonomy ) {
?>
	<div class="form-field term-group">

        <label for="books_author_image_id"><?php _e('Author Image'); ?></label>
        <input type="hidden" id="books_author_image_id" name="books_author_image_id" class="books_author_image_id" value="">

        <div id="books_author_image_wrapper"></div>

        <p>
            <input type="button" class="button button-secondary books_author_media_button" id="books_author_media_button" name="books_author_media_button" value="<?php _e( 'Add Image' ); ?>">
            <input type="button" class="button button-secondary books_author_media_remove" id="books_author_media_remove" name="books_author_media_remove" value="<?php _e( 'Remove Image' ); ?>">
        </p>

    </div>
<?php
}

// Step2: Save the Image Field
add_action( 'created_book_author', 'wbga_save_book_author_image', 10, 2 );
function wbga_save_book_author_image ( $term_id, $tt_id ) {
	
	if( isset( $_POST['books_author_image_id'] ) && '' !== $_POST['books_author_image_id'] ){
		
		$image = $_POST['books_author_image_id'];
		add_term_meta( $term_id, 'books_author_image_id', esc_url( $image ), true );
	}
}

// Step3: Add the Image Field in Edit Form
add_action( 'book_author_edit_form_fields', 'wbga_update_book_author_image', 10, 2 );
function wbga_update_book_author_image ( $term, $taxonomy ) { ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="books_author_image_id"><?php _e( 'Image' ); ?></label>
        </th>
        <td>
            <?php
            $books_author_image_id = get_term_meta ( $term->term_id, 'books_author_image_id', true );
            ?>
            <input type="hidden" id="books_author_image_id" name="books_author_image_id" value="<?php esc_attr_e( $books_author_image_id ); ?>">

            <div id="books_author_image_wrapper">
                <img src="<?php echo esc_url( $books_author_image_id ); ?>" style="width: 200px"/>
            </div>

            <p>
                <input type="button" class="button button-secondary books_author_media_button" id="books_author_media_button" name="books_author_media_button" value="<?php _e( 'Change Image', 'taxt-domain' ); ?>">
                <input type="button" class="button button-secondary books_author_media_remove" id="books_author_media_remove" name="books_author_media_remove" value="<?php _e( 'Remove Image', 'taxt-domain' ); ?>">
            </p>

        </div></td>
    </tr>
<?php
}

// Step4: Update the Image Field
add_action( 'edited_book_author', 'wbga_updated_book_author_image', 10, 2 );
function wbga_updated_book_author_image ( $term_id, $tt_id ) {
    if( isset( $_POST['books_author_image_id'] ) && '' !== $_POST['books_author_image_id'] ){
        $image = $_POST['books_author_image_id'];
        update_term_meta ( $term_id, 'books_author_image_id', esc_url( $image ) );
    } else {
        update_term_meta ( $term_id, 'books_author_image_id', '' );
    }
}

// Step5: Enqueue Media Library
add_action( 'admin_enqueue_scripts', 'wbga_load_admin_scripts' );
function wbga_load_admin_scripts() {
	
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
    }

	wp_enqueue_script('wbga-admin', WBGA_ASSETS . 'wbga-admin.js', array(), WBGA_VERSION, true);
}

add_action( 'wp_enqueue_scripts', 'wbga_load_front_scripts' );
function wbga_load_front_scripts() {
    wp_enqueue_style(
        'wbga-front',
        WBGA_ASSETS . 'author.css',
        array(),
        WBGA_VERSION,
        FALSE
    );
}

// Step6: Display the Image in Column
add_filter( 'manage_edit-book_author_columns', 'wbga_display_image_column_heading' );
function wbga_display_image_column_heading( $columns ) {
    $columns['book_author_image'] = __( 'Image' );
    return $columns;
}

add_action( 'manage_book_author_custom_column', 'wbga_display_image_to_author_column', 10, 3);
function wbga_display_image_to_author_column( $string, $columns, $term_id ) {
    
    $books_author_image_id = get_term_meta ( $term_id, 'books_author_image_id', true );

    switch ( $columns ) {
        case 'book_author_image' :
            ?>
            <img src="<?php echo esc_url( $books_author_image_id ); ?>" style="width: 40px"/>
            <?php
        break;
    }
}

add_shortcode( 'books_gallery_author', 'wbga_load_author_view' );
function wbga_load_author_view( $attr ) {
    
    $output = '';
    ob_start();
    include WBGA_PATH . 'author.php';
    $output .= ob_get_clean();
    
    return $output;
}

add_filter('taxonomy_template', 'wbga_load_author_template');
function wbga_load_author_template( $template ) {
    
    if (is_tax('book_author')) {
        return WBGA_PATH . 'taxonomy-book-author.php';
    }

    return $template;
}

// Step7: Display the Image on Frontend
//$image_id = get_term_meta ( $term_id, 'image_id', true );
//echo wp_get_attachment_image ( $image_id, 'full' );