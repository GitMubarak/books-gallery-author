<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/*
Template Name: Books Author
Template Post Type: book_author
*/

get_header();

$wbg_author_slug = isset( get_queried_object()->slug ) ? get_queried_object()->slug : '';
  
if( $wbg_author_slug != '' ) {
    $wbg_author = get_term_by('slug', $wbg_author_slug, 'book_author');

    $books_author_image_id = get_term_meta ( $wbg_author->term_id, 'books_author_image_id', true );
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
                <img src="<?php echo esc_url( $books_author_image_id ); ?>" style="width: 150px"/>
            </div>

            <div class="hmcabw-info-container">

                <h3 class="hmcabw-name"><?php echo $wbg_author->name; ?></h3>

                <div class="hmcab-name-border-main"></div>

                <p class="hmcabw-bio-info"><?php echo nl2br( $wbg_author->description ); ?></p>

            </div>
        
        </div>

    </div>
    <?php

    echo do_shortcode('[wp_books_gallery author="' . $wbg_author->name . '" search=0 display-total=0]');
}

get_footer(); 
?>