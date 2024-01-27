<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Setup Framework Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'TAF_Welcome' ) ) {
  class TAF_Welcome{

    private static $instance = null;

    public function __construct() {

      if ( TAF::$premium && ( ! TAF::is_active_plugin( 'codestar-framework/codestar-framework.php' ) || apply_filters( 'taf_welcome_page', true ) === false ) ) { return; }

      add_action( 'admin_menu', array( $this, 'add_about_menu' ), 0 );
      add_filter( 'plugin_action_links', array( $this, 'add_plugin_action_links' ), 10, 5 );
      add_filter( 'plugin_row_meta', array( $this, 'add_plugin_row_meta' ), 10, 2 );

      $this->set_demo_mode();

    }

    // instance
    public static function instance() {
      if ( is_null( self::$instance ) ) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    public function add_about_menu() {
      add_management_page( 'Codestar Framework', 'Codestar Framework', 'manage_options', 'taf-welcome', array( $this, 'add_page_welcome' ) );
    }

    public function add_page_welcome() {

      $section = ( ! empty( $_GET['section'] ) ) ? sanitize_text_field( wp_unslash( $_GET['section'] ) ) : '';

      TAF::include_plugin_file( 'views/header.php' );

      // safely include pages
      switch ( $section ) {

        case 'quickstart':
          TAF::include_plugin_file( 'views/quickstart.php' );
        break;

        case 'documentation':
          TAF::include_plugin_file( 'views/documentation.php' );
        break;

        case 'relnotes':
          TAF::include_plugin_file( 'views/relnotes.php' );
        break;

        case 'support':
          TAF::include_plugin_file( 'views/support.php' );
        break;

        case 'free-vs-premium':
          TAF::include_plugin_file( 'views/free-vs-premium.php' );
        break;

        default:
          TAF::include_plugin_file( 'views/about.php' );
        break;

      }

      TAF::include_plugin_file( 'views/footer.php' );

    }

    public static function add_plugin_action_links( $links, $plugin_file ) {

      if ( $plugin_file === 'codestar-framework/codestar-framework.php' && ! empty( $links ) ) {
        $links['taf--welcome'] = '<a href="'. esc_url( admin_url( 'tools.php?page=taf-welcome' ) ) .'">Settings</a>';
        if ( ! TAF::$premium ) {
          $links['taf--upgrade'] = '<a href="http://codestarframework.com/">Upgrade</a>';
        }
      }

      return $links;

    }

    public static function add_plugin_row_meta( $links, $plugin_file ) {

      if ( $plugin_file === 'codestar-framework/codestar-framework.php' && ! empty( $links ) ) {
        $links['taf--docs'] = '<a href="http://codestarframework.com/documentation/" target="_blank">Documentation</a>';
      }

      return $links;

    }

    public function set_demo_mode() {

      $demo_mode = get_option( 'taf_demo_mode', false );

      $demo_activate = ( ! empty( $_GET[ 'taf-demo' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'taf-demo' ] ) ) : '';

      if ( ! empty( $demo_activate ) ) {

        $demo_mode = ( $demo_activate === 'activate' ) ? true : false;

        update_option( 'taf_demo_mode', $demo_mode );

      }

      if ( ! empty( $demo_mode ) ) {

        TAF::include_plugin_file( 'samples/admin-options.php' );

        if ( TAF::$premium ) {

          TAF::include_plugin_file( 'samples/customize-options.php' );
          TAF::include_plugin_file( 'samples/metabox-options.php'   );
          TAF::include_plugin_file( 'samples/nav-menu-options.php'  );
          TAF::include_plugin_file( 'samples/profile-options.php'   );
          TAF::include_plugin_file( 'samples/shortcode-options.php' );
          TAF::include_plugin_file( 'samples/taxonomy-options.php'  );
          TAF::include_plugin_file( 'samples/widget-options.php'    );
          TAF::include_plugin_file( 'samples/comment-options.php'   );

        }

      }

    }

  }

  TAF_Welcome::instance();
}
