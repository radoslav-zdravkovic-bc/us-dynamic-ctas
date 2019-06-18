<?php

/**
 * Class UDCAdmin
 * @author Radoslav Zdravkovic BC
 */

 namespace USDynamicCTAs\Admin;

 class UDCAdmin {

   public function __construct() {

     $this->init();

   }

   public function init() {

     /* Add Admin menu item and register settings for US Dynamic CTAs */
     if (is_admin()){ // admin actions
       add_action( 'admin_menu', array($this, 'usDynamicCtasMenu') );
     } else {
       // non-admin enqueues, actions, and filters
     }

     /* Enqueue US Dynamic CTAs JS and CSS */
     if ( isset($_GET['page']) && ($_GET['page'] == 'us-dynamic-ctas') ) {
       add_action( 'admin_enqueue_scripts', array($this, 'usDynamicCtasCssAndJsAdminLoad'));
     }

     /* Shortcodes Settings Page */
     acf_add_options_page(array(
        'page_title'    => 'Shortcodes Settings',
        'menu_title'    => 'Shortcodes Settings',
        'menu_slug'     => 'shortcodes-settings',
        'redirect'      => false,
        'parent_slug'   => 'us-dynamic-ctas',
     ));

     add_filter('acf/settings/save_json', array($this, 'my_acf_json_save_point'));

     add_filter('acf/settings/load_json', array($this, 'my_acf_json_load_point'));
   }

   public function usDynamicCtasMenu() {
     add_menu_page( 'US Dynamic CTAs', 'Dynamic CTAs', 'manage_options', 'us-dynamic-ctas', array($this, 'usDynamicCtasOptions'), plugins_url( 'us-dynamic-ctas/src/Admin/assets/icons/ctas.png' )  );
   }

   public function usDynamicCtasOptions() {
     include 'templates/template-hero.php';
   }

   public function usDynamicCtasCssAndJsAdminLoad() {
     wp_register_style('bootstrap_us_dynamic_ctas', plugins_url('assets/css/bootstrap.min.css', __FILE__));
     wp_enqueue_style('bootstrap_us_dynamic_ctas');
     wp_register_style('admin_us_dynamic_ctas_styles', plugins_url('assets/css/admin-us-dynamic-ctas.css', __FILE__));
     wp_enqueue_style('admin_us_dynamic_ctas_styles');

     wp_register_script('bootstrap_us_dynamic_ctas', plugins_url('assets/js/bootstrap.min.js', __FILE__), array('jquery'), true);
     wp_enqueue_script('bootstrap_us_dynamic_ctas');
     wp_register_script('admin_us_dynamic_ctas_js', plugins_url('assets/js/admin-us-dynamic-cta.js', __FILE__), array('jquery'), true);
     wp_enqueue_script('admin_us_dynamic_ctas_js');
   }

   public function my_acf_json_save_point( $path ) {
     $path = USDCM_PATH . 'src/Admin/acf-json';
     return $path;
   }

   public function my_acf_json_load_point( $paths ) {
       unset($paths[0]);
       $paths[] = USDCM_PATH . 'src/Admin/acf-json';
       return $paths;
   }

 }
