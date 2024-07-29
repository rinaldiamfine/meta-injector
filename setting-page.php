<?php

class MetaInjectorSettingPage {
    public $description = '';
    public $keywords = '';
    public $author = '';
    public $robots = '';

    public function __construct() {
        $this->description = get_option( 'meta_injector_description', 'This is a custom meta description.' );
        $this->keywords = get_option( 'meta_injector_keywords', 'This is a custom meta description.' );
        $this->author = get_option( 'meta_injector_author', 'Author' );
        $this->robots = get_option( 'meta_injector_robots', 'index, follow' );
    }

    public function setup_hooks() {
        add_action( 'wp_head', array( $this, 'inject_tags' ) );
        add_action( 'admin_menu', array( $this, 'build_menu' ) );
        add_action( 'admin_init', array( $this, 'build_content' ) );
    }

    public function inject_tags() {
        echo '<meta name="description" content="' . esc_attr( $this->description ) . '">';
        echo '<meta name="keywords" content="' . esc_attr( $this->keywords ) . '">';
        echo '<meta name="author" content="' . esc_attr( $this->author ) . '">';
        echo '<meta name="robots" content="' . esc_attr( $this->robots ) . '">';
    }

    public function build_menu() {
        add_menu_page(
            'Meta Injector Settings', 
            'Meta Injector', 
            'manage_options', 
            'meta-injector', 
            array( $this, 'build_page' ), 
            'dashicons-admin-generic'
        );
    }

    public function build_content() {
        register_setting( 'meta_injector_settings_group', 'meta_injector_description' );
        register_setting( 'meta_injector_settings_group', 'meta_injector_keywords' );
        register_setting( 'meta_injector_settings_group', 'meta_injector_author' );
        register_setting( 'meta_injector_settings_group', 'meta_injector_robots' );

        // Section setting
        add_settings_section(
            'general_meta_tag_section', 
            'General Meta Tags', 
            array( $this, 'section_callback' ), 
            'meta-injector',
            array( 'name' => '' ) // Args
        );
        add_settings_section(
            'open_graph_meta_tag_section', 
            'Open Graph Meta Tags', 
            array( $this, 'section_callback' ), 
            'meta-injector',
            array( 'name' => '' ) // Args
        );
        add_settings_section(
            'twitter_meta_tag_section', 
            'Twitter Card Meta Tags', 
            array( $this, 'section_callback' ), 
            'meta-injector',
            array( 'name' => '' ) // Args
        );

        // Field setting
        add_settings_field(
            'meta_injector_description', // ID
            'Description', // Title
            array( $this, 'field_callback' ), // Callback
            'meta-injector', // Page
            'general_meta_tag_section', // Section
            array( 'key' => 'meta_injector_description' ) // Args
        );
        add_settings_field(
            'meta_injector_keywords', // ID
            'Keywords', // Title
            array( $this, 'field_callback' ), // Callback
            'meta-injector', // Page
            'general_meta_tag_section', // Section
            array( 'key' => 'meta_injector_keywords' ) // Args
        );
        add_settings_field(
            'meta_injector_author', // ID
            'Author', // Title
            array( $this, 'field_callback' ), // Callback
            'meta-injector', // Page
            'general_meta_tag_section', // Section
            array( 'key' => 'meta_injector_author' ) // Args
        );
        add_settings_field(
            'meta_injector_robots', // ID
            'Robots', // Title
            array( $this, 'field_callback' ), // Callback
            'meta-injector', // Page
            'general_meta_tag_section', // Section
            array( 'key' => 'meta_injector_robots' ) // Args
        );
    }

    public function section_callback($args) {
        echo '<p>'. $args['name'] .'</p>';
    }

    public function field_callback($args) {
        $option = get_option($args['key'], '');
        echo '<input type="text" name="' . esc_attr($args['key']) . '" value="' . esc_attr($option) . '" class="regular-text">';
    }

    public function build_page() {
        ?>
        <div class="wrap">
            <h1>Meta Injector Settings</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'meta_injector_settings_group' );
                    do_settings_sections( 'meta-injector' );
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
?>
