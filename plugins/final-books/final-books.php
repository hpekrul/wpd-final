<?php
/**
Plugin Name: Books
Description: Displays Books
Version: 1.0.0
Author: Holly Pekrul
Text Domain: final-books
 */
namespace BookPlugin;

const TEXT_DOMAIN = 'final-books';

require_once __DIR__ . '/classes/Singleton.php';
require_once __DIR__ . '/classes/BookPostType.php';
require_once __DIR__ . '/classes/BookGenreTaxonomy.php';
require_once __DIR__ . '/classes/BookMeta.php';
require_once __DIR__ . '/classes/ReviewPostType.php';
require_once __DIR__ . '/classes/ReviewMeta.php';
require_once __DIR__ . '/classes/RandomReview.php';
require_once __DIR__ . '/classes/RegisterPlugin.php';

RegisterPlugin::getInstance();










