<?php

namespace BookPlugin;

/**
 * book post type to share book information
 */
class BookPostType extends Singleton
{
    const POST_TYPE = 'book';

    protected static $instance;

    protected function __construct()
    {
        add_action( 'init', [$this, 'registerBookPostType'], 0 );

        add_filter('the_content', [$this, 'bookInformationTemplate']);
    }

    // Register Custom Post Type
    public function registerBookPostType() {

        $labels = array(
            'name'                  => _x( 'Books', 'Post Type General Name', TEXT_DOMAIN ),
            'singular_name'         => _x( 'Book', 'Post Type Singular Name', TEXT_DOMAIN ),
            'menu_name'             => __( 'Book', TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Books', TEXT_DOMAIN ),
            'archives'              => __( 'Book Archives', TEXT_DOMAIN ),
            'attributes'            => __( 'Book Attributes', TEXT_DOMAIN ),
            'parent_item_colon'     => __( 'Parent book:', TEXT_DOMAIN ),
            'all_items'             => __( 'All books', TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New book', TEXT_DOMAIN ),
            'add_new'               => __( 'Add New', TEXT_DOMAIN ),
            'new_item'              => __( 'New Book', TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Book', TEXT_DOMAIN ),
            'update_item'           => __( 'Update Book', TEXT_DOMAIN ),
            'view_item'             => __( 'View Book', TEXT_DOMAIN ),
            'view_items'            => __( 'View Books', TEXT_DOMAIN ),
            'search_items'          => __( 'Search Book', TEXT_DOMAIN ),
            'not_found'             => __( 'Not found', TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'Not found in Trash', TEXT_DOMAIN ),
            'featured_image'        => __( 'Featured Image', TEXT_DOMAIN ),
            'set_featured_image'    => __( 'Set featured image', TEXT_DOMAIN ),
            'remove_featured_image' => __( 'Remove featured image', TEXT_DOMAIN ),
            'use_featured_image'    => __( 'Use as featured image', TEXT_DOMAIN ),
            'insert_into_item'      => __( 'Insert into book', TEXT_DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this book', TEXT_DOMAIN ),
            'items_list'            => __( 'Books list', TEXT_DOMAIN ),
            'items_list_navigation' => __( 'Books list navigation', TEXT_DOMAIN ),
            'filter_items_list'     => __( 'Filter Books list', TEXT_DOMAIN ),
        );
        $args = array(
            'label'                 => __( 'Book', TEXT_DOMAIN ),
            'description'           => __( 'Book Information', TEXT_DOMAIN ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-book',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'books',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( static::POST_TYPE, $args );

    }

    public function bookInformationTemplate($content){
        $post = get_post();
        if($post->post_type == self::POST_TYPE){
            $publisher = get_post_meta($post->ID, BookMeta::PUBLISHER, true);
            $publishedDate = get_post_meta($post->ID, BookMeta::PUBLISHED_DATE, true);
            $pageCount = get_post_meta($post->ID, BookMeta::PAGE_COUNT, true);
            $price = get_post_meta($post->ID, BookMeta::PRICE, true);
            $series = get_post_meta($post->ID, BookMeta::SERIES, true);
            $readingAge = get_post_meta($post->ID, BookMeta::READING_AGE, true);
            $content = "<div class='row bookContent'>
                       <div class='col-12 col-md-9'>
                    <h3>Book Description</h3>
                  <div>$content</div>
                  <h3>Book Information</h3>
                  <p>Publisher: $publisher</p>
                  <p>Published Date: $publishedDate</p>
                  <p>Page Count: $pageCount</p>
                  <p>Price: $price</p>
                  <p>Series: $series</p>
                  <p>Reading Age: $readingAge</p> 
                  </div>";
            $content .= '
                    <div class="col-12 col-md-3">
                            <h3>Reviews</h3>';
            $query = new \WP_Query([
                //find posts by the same author
                'meta_key' => ReviewMeta::BOOK_ID,
                'meta_value' => [$post->ID],
                //filter to just recipes
                'post_type' => ReviewPostType::POST_TYPE,
                //limit to 5
                'posts_per_page' => 5,
            ]);
            if ( $query->have_posts() ) {
                $content .= '<ul>';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $content .= '<li>
                    <a href="' . get_the_permalink() . '">' . esc_html( get_the_title() ) . ' </a>
                    </li>';
                }
                $content .= '</ul>';
            } else {
                $content .= __( 'Sorry, there are no reviews for this book.' );
            }

            wp_reset_postdata();
            $content .= '</div>';
            $content .= '</div>';
        }
        return $content;
    }
}