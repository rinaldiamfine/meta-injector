<?php

class MetaInjectorSettingPage {
    // General meta tags
    public $description = '';
    public $keywords = '';
    public $author = '';
    public $robots = '';

    // Open graph meta tags
    public $ogTitle = '';
    public $ogDescription = '';
    public $ogImage = '';
    public $ogUrl = '';
    public $ogType = '';
    public $ogSiteName = '';
    public $ogLocale = '';

    // Twitter meta tags
    public $tCard = '';
    public $tSite = '';
    public $tTitle = '';
    public $tDescription = '';
    public $tImage = '';

    public function __construct() {
        // General meta tags
        $this->description = get_option( 'meta_injector_description', 'This is a custom meta description.' );
        $this->keywords = get_option( 'meta_injector_keywords', 'This is a custom meta description.' );
        $this->author = get_option( 'meta_injector_author', 'Author website' );
        $this->robots = get_option( 'meta_injector_robots', 'index, follow' );

        // Open graph meta tags
        $this->ogTitle = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogDescription = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogImage = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogUrl = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogType = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogSiteName = get_option( 'meta_injector_robots', 'index, follow' );
        $this->ogLocale = get_option( 'meta_injector_robots', 'index, follow' );

        // Twitter meta tags
        $this->tCard = get_option( 'meta_injector_robots', 'index, follow' );
        $this->tSite = get_option( 'meta_injector_robots', 'index, follow' );
        $this->tTitle = get_option( 'meta_injector_robots', 'index, follow' );
        $this->tDescription = get_option( 'meta_injector_robots', 'index, follow' );
        $this->tImage = get_option( 'meta_injector_robots', 'index, follow' );
    }

    public function setup_hooks() {
        add_action( 'wp_head', array( $this, 'inject_tags' ) );
        add_action( 'admin_menu', array( $this, 'build_menu' ) );
        add_action( 'admin_init', array( $this, 'build_content' ) );
    }

    public function inject_tags() {
        // General meta tags
        echo '<meta name="description" content="' . esc_attr( $this->description ) . '">';
        echo '<meta name="keywords" content="' . esc_attr( $this->keywords ) . '">';
        echo '<meta name="author" content="' . esc_attr( $this->author ) . '">';
        echo '<meta name="robots" content="' . esc_attr( $this->robots ) . '">';

        // Open graph meta tags
        echo '<meta property="og:title" content="' . esc_attr( $this->ogTitle ) . '">';
        echo '<meta property="og:type" content="' . esc_attr( $this->ogType ) . '">';
        echo '<meta property="og:url" content="' . esc_attr( $this->ogUrl ) . '">';
        echo '<meta property="og:image" content="' . esc_attr( $this->ogImage ) . '">';
        echo '<meta property="og:description" content="' . esc_attr( $this->ogDescription ) . '">';
        echo '<meta property="og:site_name" content="' . esc_attr( $this->ogSiteName ) . '">';
        echo '<meta property="og:locale" content="' . esc_attr( $this->ogLocale ) . '">';
        
        // Twitter meta tags
        echo '<meta name="twitter:card" content="' . esc_attr( $this->tCard ) . '">';
        echo '<meta name="twitter:site" content="' . esc_attr( $this->tSite ) . '">';
        echo '<meta name="twitter:title" content="' . esc_attr( $this->tTitle ) . '">';
        echo '<meta name="twitter:description" content="' . esc_attr( $this->tDescription ) . '">';
        echo '<meta name="twitter:image" content="' . esc_attr( $this->tImage ) . '">';
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
            array( 'name' => '' )
        );
        add_settings_section(
            'open_graph_meta_tag_section', 
            'Open Graph Meta Tags', 
            array( $this, 'section_callback' ), 
            'meta-injector',
            array( 'name' => '' )
        );
        add_settings_section(
            'twitter_meta_tag_section', 
            'Twitter Card Meta Tags', 
            array( $this, 'section_callback' ), 
            'meta-injector',
            array( 'name' => '' )
        );

        // Field setting
        add_settings_field(
            'meta_injector_description',
            'Description',
            array( $this, 'field_callback' ),
            'meta-injector',
            'general_meta_tag_section',
            array( 'key' => 'meta_injector_description' )
        );
        add_settings_field(
            'meta_injector_keywords',
            'Keywords',
            array( $this, 'field_callback' ),
            'meta-injector',
            'general_meta_tag_section',
            array( 'key' => 'meta_injector_keywords' )
        );
        add_settings_field(
            'meta_injector_author',
            'Author',
            array( $this, 'field_callback' ),
            'meta-injector',
            'general_meta_tag_section',
            array( 'key' => 'meta_injector_author' )
        );
        add_settings_field(
            'meta_injector_robots',
            'Robots',
            array( $this, 'field_callback' ),
            'meta-injector',
            'general_meta_tag_section',
            array( 'key' => 'meta_injector_robots' )
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
