<?php

namespace BookPlugin;

/**
 * class to generate a random review short code
 */
class RandomReview extends Singleton
{
    protected static $instance;

    protected function __construct()
    {
        add_shortcode('random-review', [$this, 'randomReviewShortcode'] );
    }

    function randomReviewShortcode(){
        $args = array(
            'post_type' => ReviewPostType::POST_TYPE,
            'posts_per_page' => 1,
            'orderby' => 'rand',
        );
        $output = "<div class='reviewShortcode'> <h2> <p>See what people are saying about Dr. Seuss books...</p>";

        $query = new \WP_Query($args);
        if($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $output .= '</h2>' .
                    '<h3>' .
                    '<a href="' . get_the_permalink() . '">' . esc_html(get_the_title()  ) . ' </a>' .
                    '</h3>';
                $output .= '<div>' . get_the_content() . '</div>';

                $output .= '<div>' . get_post_meta(get_the_ID(), ReviewMeta::NAME, true) . ', ' .
                    get_post_meta(get_the_ID(), ReviewMeta::LOCATION, true) . '</div> </div>';
            }
        }
        wp_reset_postdata();

        return $output;
    }
}