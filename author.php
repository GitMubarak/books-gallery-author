<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$wbg_author_name = isset( $attr['author'] ) ? $attr['author'] : '';

$wbg_author = get_term_by('name', $wbg_author_name, 'book_author');

//print_r( $wbg_author );
if ( ! empty( $wbg_author ) ) {
    $books_author_image_id = get_term_meta ( $wbg_author->term_id, 'books_author_image_id', true );
    ?>
    <div class="hmcabw-main-wrapper">

        <div class="hmcabw-parent-container">

            <div class="hmcabw-image-container circle">
                <img src="<?php echo esc_url( $books_author_image_id ); ?>" style="width: 150px" alt="<?php esc_attr_e( $wbg_author->name ); ?>"/>
            </div>

            <div class="hmcabw-info-container">

                <h3 class="hmcabw-name"><a href="<?php echo esc_url( home_url( '/book-author/' . $wbg_author->slug ) ); ?>"><?php esc_html_e( $wbg_author->name ); ?></a></h3>

                <div class="hmcab-name-border-main"></div>

                <p class="hmcabw-bio-info"><?php echo wp_trim_words( nl2br( $wbg_author->description ), 40, '...' ); ?></p>
				
				<a href="<?php echo esc_url( home_url( '/book-author/' . $wbg_author->slug ) ); ?>" class="more-about"><?php echo __('More About', 'books-gallery-author') . '&nbsp;' . esc_html( $wbg_author->name ); ?></a>

            </div>
        </div>
    </div>
    <?php
}
?>