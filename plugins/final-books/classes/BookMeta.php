<?php

namespace BookPlugin;


/**
 * book meta to hold specific information on a book
 */
class BookMeta extends Singleton
{
    const PUBLISHER = 'final_books_publisher';
    const PUBLISHED_DATE = 'final_books_publishedDate';
    const PAGE_COUNT = 'final_books_pageCount';
    const PRICE = 'final_books_price';
    const SERIES = 'final_books_series';
    const READING_AGE = 'final_books_readingAge';
    protected static $instance;

    protected function __construct()
    {
        add_action('admin_init', [$this, 'registerMetaBox']);
        add_action('save_post_' . BookPostType::POST_TYPE, [$this, 'saveInformation']);
    }

    public function registerMetaBox(){
        add_meta_box('book_information_meta',
            'Information',
            [$this, 'outputInformation'],
            BookPostType::POST_TYPE,
            'normal'
        );
    }

    public function outputInformation(){
        $post = get_post();
        $publisher = get_post_meta($post->ID, self::PUBLISHER, true);
        $publishedDate = get_post_meta($post->ID, self::PUBLISHED_DATE, true);
        $pageCount = get_post_meta($post->ID, self::PAGE_COUNT, true);
        $price = get_post_meta($post->ID, self::PRICE, true);
        $series = get_post_meta($post->ID, self::SERIES, true);
        $readingAge = get_post_meta($post->ID, self::READING_AGE, true);
        ?>
            <p>
                <label>Publisher: <input type="text" name="publisher" value="<?= $publisher ?>"></label>
            </p>
        <p>
            <label>Published Date: <input type="date" name="publishedDate" value="<?= $publishedDate ?>"</label>
        </p>
        <p>
            <label>Page Count: <input type="number" name="pageCount" value="<?= $pageCount ?>"</label>
        </p>
        <p>
            <label>Price: <input type="text" name="price" value="<?= $price ?>"</label>
        </p>
        <p>
            <label>Series: <input type="text" name="series" value="<?= $series ?>"</label>
        </p>
        <p>
            <label>Reading Age: <input type="text" name="readingAge" value="<?= $readingAge ?>"</label>
        </p>


        <?php

    }

    public function saveInformation(){
        $publisher = sanitize_text_field($_POST['publisher']);
        $publishedDate = sanitize_text_field($_POST['publishedDate']);
        $pageCount = sanitize_text_field($_POST['pageCount']);
        $price = sanitize_text_field($_POST['price']);
        $series = sanitize_text_field($_POST['series']);
        $readingAge = sanitize_text_field($_POST['readingAge']);

        $post = get_post();
        update_post_meta($post->ID, self::PUBLISHER, $publisher);
        update_post_meta($post->ID, self::PUBLISHED_DATE, $publishedDate);
        update_post_meta($post->ID, self::PAGE_COUNT, $pageCount);
        update_post_meta($post->ID, self::PRICE, $price);
        update_post_meta($post->ID, self::SERIES, $series);
        update_post_meta($post->ID, self::READING_AGE, $readingAge);


    }
}