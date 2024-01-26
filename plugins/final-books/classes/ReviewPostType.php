<?php

namespace BookPlugin;

/**
 * review post type to create reviews for the books
 */
class ReviewPostType extends Singleton
{
    const POST_TYPE = 'review'; 
    
    protected static $instance;
    protected function __construct()
        {
            add_action( 'init', [$this, 'registerReviewPostType'], 0 );

            add_filter('the_content', [$this, 'reviewInformationTemplate']);
        }
    // Register Custom Post Type
    function registerReviewPostType() {

        $labels = array(
            'name'                  => _x( 'Reviews', 'Post Type General Name', TEXT_DOMAIN ),
            'singular_name'         => _x( 'Review', 'Post Type Singular Name', TEXT_DOMAIN ),
            'menu_name'             => __( 'Reviews', TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Review', TEXT_DOMAIN ),
            'archives'              => __( 'Review Archives', TEXT_DOMAIN ),
            'attributes'            => __( 'Review Attributes', TEXT_DOMAIN ),
            'parent_item_colon'     => __( 'Parent Review:', TEXT_DOMAIN ),
            'all_items'             => __( 'All Reviews', TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New Review', TEXT_DOMAIN ),
            'add_new'               => __( 'Add New', TEXT_DOMAIN ),
            'new_item'              => __( 'New Review', TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Review', TEXT_DOMAIN ),
            'update_item'           => __( 'Update Review', TEXT_DOMAIN ),
            'view_item'             => __( 'View Review', TEXT_DOMAIN ),
            'view_items'            => __( 'View Reviews', TEXT_DOMAIN ),
            'search_items'          => __( 'Search Review', TEXT_DOMAIN ),
            'not_found'             => __( 'Not found', TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'Not found in Trash', TEXT_DOMAIN ),
            'featured_image'        => __( 'Featured Image', TEXT_DOMAIN ),
            'set_featured_image'    => __( 'Set featured image', TEXT_DOMAIN ),
            'remove_featured_image' => __( 'Remove featured image', TEXT_DOMAIN ),
            'use_featured_image'    => __( 'Use as featured image', TEXT_DOMAIN ),
            'insert_into_item'      => __( 'Insert into Review', TEXT_DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this review', TEXT_DOMAIN ),
            'items_list'            => __( 'Reviews list', TEXT_DOMAIN ),
            'items_list_navigation' => __( 'Reviews list navigation', TEXT_DOMAIN ),
            'filter_items_list'     => __( 'Filter reviews list', TEXT_DOMAIN ),
        );
        $args = array(
            'label'                 => __( 'Review', TEXT_DOMAIN ),
            'description'           => __( 'Reviews of Books', TEXT_DOMAIN ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-admin-comments',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'reviews',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( static::POST_TYPE, $args );

    }

    public function reviewInformationTemplate($content)
    {
        $post = get_post();
        if ($post->post_type == self::POST_TYPE) {
            $name = get_post_meta($post->ID, ReviewMeta::NAME, true);
            $location = get_post_meta($post->ID, ReviewMeta::LOCATION, true);
            $rating = get_post_meta($post->ID, ReviewMeta::RATING, true);
            $content = "<h3>Review Comment</h3>
                  <div>$content</div>
                  <h3>Review Information</h3>
                  <p>Name: $name</p>
                  <p>Location: $location</p>
                  <p>Rating: $rating</p>
                  ";
        }
        return $content;

    }



}