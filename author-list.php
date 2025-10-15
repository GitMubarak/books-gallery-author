<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$description_length = isset( $attr['description_length'] ) ? $attr['description_length'] : 20;

$book_authors  = get_terms( array( 'taxonomy' => 'book_author', 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC' ) );

if ( ! empty( $book_authors ) ) {
    ?>
    <div class="wbga-author-list-wrapper">
        <?php
        foreach ( $book_authors as $author ) {
            $books_author_image_id = get_term_meta ( $author->term_id, 'books_author_image_id', true );
            ?>
            <div class="wbga-author-items">

                <div class="hmcabw-image-container circle">
                    <img src="<?php echo esc_url( $books_author_image_id ); ?>" alt="<?php esc_attr_e( $author->name ); ?>" />
                </div>

                <div class="hmcabw-info-container">

                    <h3 class="hmcabw-name"><a href="<?php echo esc_url( home_url( '/book-author/' . $author->slug ) ); ?>"><?php echo $author->name; ?>&nbsp;(<?php esc_html_e($author->count); ?>)</a></h3>
                    <p class="hmcabw-bio-info">
                        <?php //echo wp_trim_words( nl2br( $author->description ), 20, '...' ); ?>
                        <?php echo force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop( $author->description ) ), $description_length, '...' ) ) ); ?>
                    </p>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php 
}
?>