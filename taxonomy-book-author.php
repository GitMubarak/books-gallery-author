<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/*
Template Name: Books Author - Single
Template Post Type: book_author
*/

get_header();

$wbg_author_slug = isset( get_queried_object()->slug ) ? get_queried_object()->slug : '';
  
if( $wbg_author_slug != '' ) {
    
    $wbg_author = get_term_by('slug', $wbg_author_slug, 'book_author');

    $books_author_image_id = get_term_meta ( $wbg_author->term_id, 'books_author_image_id', true );

    $primary_author = get_posts( array(
        'post_type' => 'books',
        'meta_key'   => 'wbg_author',
        'meta_value' => $wbg_author->name,
        'post_status' => 'publish',
        'posts_per_page' => -1
    ) );

    $primary_author_count = count($primary_author);
    ?>
    <style type="text/css">
        .wbg-parent-wrapper {
            margin-top: 0px!important;
            max-width: 100%!important;
        }
    </style>
    <div class="hmcabw-main-wrapper" style="margin-top: 100px;">

        <div class="hmcabw-parent-container">

            <div class="hmcabw-image-container circle">
                <img src="<?php echo esc_url( $books_author_image_id ); ?>" style="width: 150px" alt="<?php esc_attr_e( $wbg_author->name ); ?>"/>
            </div>

            <div class="hmcabw-info-container">

                <h3 class="hmcabw-name"><?php echo $wbg_author->name; ?></h3>

                <div class="hmcab-name-border-main"></div>

                <p class="hmcabw-bio-info"><?php echo nl2br( $wbg_author->description ); ?></p>

            </div>
        
        </div>

    </div>
    <?php
    if ( $primary_author_count > 0 ) {
        echo do_shortcode('[wp_books_gallery author="' . $wbg_author->name . '" search=0 display-total=0 no-book-message="Hide"]');
    } else {
        echo do_shortcode('[wp_books_gallery co-author="' . $wbg_author->name . '" search=0 display-total=0 no-book-message="Hide"]');
    }
}

get_footer(); 
?>