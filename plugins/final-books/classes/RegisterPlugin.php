<?php

namespace BookPlugin;

/**
 * getting instance of all classes, activating the plugin and deactivation for plugin
 */
class RegisterPlugin extends Singleton
{

    protected static $instance;


    protected function __construct()
    {
        BookPostType::getInstance();
        BookGenreTaxonomy::getInstance();
        BookMeta::getInstance();
        ReviewPostType::getInstance();
        ReviewMeta::getInstance();
        RandomReview::getInstance();
        register_activation_hook(__FILE__,'BookPlugin\activate_plugin');
        register_deactivation_hook( __FILE__, 'wpd_final_deactivate' );
    }

    function activate_plugin(){
        BookPostType::getInstance()->registerBookPostType();
        BookGenreTaxonomy::getInstance()->registerTaxonomy();
        ReviewPostType::getInstance()->registerReviewPostType();

        flush_rewrite_rules();
    }

    function wpd_final_deactivate() {
        // Unregister the post type, so the rules are no longer in memory.
        unregister_post_type( 'book' );
        // Clear the permalinks to remove our post type's rules from the database.
        flush_rewrite_rules();
    }

}