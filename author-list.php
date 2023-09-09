<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$book_authors  = get_terms( array( 'taxonomy' => 'book_author', 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC' ) );
//echo '<pre>';
//print_r( $book_authors );
if ( ! empty( $book_authors ) ) {
    ?>
    <div class="wbga-author-list-wrapper">
        <?php
        foreach ( $book_authors as $author ) {
            $books_author_image_id = get_term_meta ( $author->term_id, 'books_author_image_id', true );
            ?>
            <div class="wbga-author-items">

                <div class="hmcabw-image-container circle">
                    <img src="<?php echo esc_url( $books_author_image_id ); ?>" />
                </div>

                <div class="hmcabw-info-container">

                    <h3 class="hmcabw-name"><a href="<?php echo esc_url( home_url( '/book-author/' . $author->slug ) ); ?>"><?php echo $author->name; ?>&nbsp;(<?php esc_html_e($author->count); ?>)</a></h3>
                    <p class="hmcabw-bio-info"><?php echo wp_trim_words( nl2br( $author->description ), 20, '...' ); ?></p>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php 
}
?>