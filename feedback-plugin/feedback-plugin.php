<?php

/**
 * @package feedback-plugin
 * /

/* 
 * Plugin Name: feedback
 * Plugin URI: http://abderrahmane.com/plugin
 * Version: 1.0.0
 * Author: DACHOUCHA Abderrahmane
 * Author URI: https://github.com/im-dachoucha
 * License: GPLv2 or later
 * Text Domain: feedback-plugin
 */

defined('ABSPATH') or die('you do not have access to this file');

class feedBackPlugin
{
   function __construct()
   {
      add_action('init', array($this, 'custom_post_type'));
      add_action('wp_enqueue_scripts', array($this, 'load_assets'));
      add_shortcode('feedback-form', array($this, 'load_shortcode'));
   }

   function activate()
   {
      $this->custom_post_type();

      flush_rewrite_rules();
   }
   function deactivate()
   {
      flush_rewrite_rules();
   }
   function uninstall()
   {
   }
   function custom_post_type()
   {
      $arr = array(
         'public' => true,
         'has_archive' => true,
         'supports' => array('title'),
         'exclude_from_search' => true,
         'publicly_queryable' => false,
         'capability' => 'manage_options',
         'labels' => array(
            'name' => 'feedback',
            'singular_name' => 'Contact Form Entry',
         ),
         'menu_icon' => 'dashicons-feedback',
      );
      register_post_type('feedBackPlugin', $arr);
   }
   public function load_assets()
   {
      wp_enqueue_style(
         'feedBackPlugin',
         plugin_dir_url(__FILE__) . 'css/style.css',
         array(),
         1,
         'all'
      );
      wp_enqueue_script(
         'cosmic-plugin',
         plugin_dir_url(__FILE__) . 'js/script.js',
         array(),
         1,
         'all'
      );
   }
   public function load_shortcode()
   {
?>
      <script src="https://cdn.tailwindcss.com"></script>
      <div class="flex justify-center  h-92">
         <form action="" method="POST">
            <div class="grid grid-cols-2 gap-4">
               <div class="form-group mb-6">
                  <input type="text" name="name" placeholder="Name" required class="form-control
          block
          w-full
          px-3
          py-1.5
          text-base
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput123" aria-describedby="emailHelp123" placeholder="First name">
               </div>
               <div class="form-group mb-6">
                  <input type="number" max="5" min="1" name="rating" id="Rating" placeholder="rating" class="form-control
          block
          w-full
          px-3
          py-1.5
          text-base
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" required>
               </div>
            </div>
            <div class="form-group mb-6">
               <textarea name="Review" id="Review" class="form-control block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput126" placeholder="Review" required></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo get_the_ID() ?> ">
            <button type="submit" name="submit" class="
      w-full
      px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out">Submit</button>
         </form>
      </div>
<?php
   }
}

if (class_exists('feedBackPlugin')) {
   $feedBackPlugin = new feedBackPlugin();
}

register_activation_hook(__FILE__, array($feedBackPlugin, 'activate'));

register_deactivation_hook(__FILE__, array($feedBackPlugin, 'deactivate'));

global $wpdb;
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $rating = $_POST['rating'];
   $review = $_POST['Review'];
   $id = $_POST['id'];
   $wpdb->insert('wp_1_feedback', array('Name' => $name, 'Rating' => $rating, 'Review' => $review, 'post_id' => $id));
   header('refresh:0', 'Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}
