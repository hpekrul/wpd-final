<?php

namespace BookPlugin;

/**
 * review meta to hold information about the books
 */
class ReviewMeta extends Singleton
{
    const NAME = 'final_books_name';
    const LOCATION = 'final_books_location';

    const RATING = 'final_books_rating';

    const BOOK_ID = 'final_books_bookId';

    protected function __construct()
    {
        add_action('admin_init', [$this, 'registerMetaBox']);

        add_action('save_post_' . ReviewPostType::POST_TYPE, [$this, 'saveInformation']);
    }

    public function registerMetaBox(){
        add_meta_box('review_comment_meta',
        'Review Comment',
        [$this, 'outputComment'],
        ReviewPostType::POST_TYPE,
        'normal'
        );
    }

    public function outputComment(){
        $post = get_post();
        $name = get_post_meta($post->ID, self::NAME, true);
        $location = get_post_meta($post->ID, self::LOCATION, true);
        $rating = get_post_meta($post->ID, self::RATING, true);
        $bookId = get_post_meta($post->ID, self::BOOK_ID, true);
        ?>
        <p>
                <label>Name: <input type="text" name="name" value="<?= $name ?>"></label>
            </p>
        <p>
            <label>Location: <input type="text" name="location" value="<?= $location ?>"</label>
        </p>
        <p>
            <label for="rating">Rating: </label>
            <select name="rating" id="rating" value="<?= $rating ?>">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </p>
        <?php
        $dropdown_args = array(
            'post_type'        => BookPostType::POST_TYPE,
            'selected'         => $bookId,
            'name'             => 'bookId',
            'sort_column'      => 'menu_order, post_title',
            'echo'             => 0,
        );
    echo wp_dropdown_pages( $dropdown_args );
    }
    public function saveInformation(){
        $name = sanitize_text_field($_POST['name']);
        $location = sanitize_text_field($_POST['location']);
        $rating = sanitize_text_field($_POST['rating']);
        $bookId = sanitize_text_field($_POST['bookId']);


        $post = get_post();
        update_post_meta($post->ID, self::NAME, $name);
        update_post_meta($post->ID, self::LOCATION, $location);
        update_post_meta($post->ID, self::RATING, $rating);
        update_post_meta($post->ID, self::BOOK_ID, $bookId);

    }
}