<?php

class SaleJunction_Customizer {

    public static function SaleJunction_Register($wp_customize) {
        self::SaleJunction_Sections($wp_customize);
        self::SaleJunction_Controls($wp_customize);
    }

    public static function SaleJunction_Sections($wp_customize) {
        /**
         * General Section
         */
        $wp_customize->add_section('general_setting_section', array(
            'title' => __('General Settings', 'salejunction'),
            'description' => __('Allows you to customize header logo, favicon, background etc settings for SaleJunction Theme.', 'salejunction'), //Descriptive tooltip
            'panel' => '',
            'priority' => '10',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page Top Feature Area
         */
        $wp_customize->add_section('home_top_feature_area', array(
            'title' => __('Top Feature Area', 'salejunction'),
            'description' => __('Allows you to setup Top feature area section for SaleJunction Theme.', 'salejunction'), //Descriptive tooltip
            'panel' => '',
            'priority' => '11',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Add panel for home page feature area
         */
        $wp_customize->add_panel('home_page_feature_area_panel', array(
            'title' => __('Home Page Feature Area', 'salejunction'),
            'description' => __('Allows you to setup home page feature area section for SaleJunction Theme.', 'salejunction'),
            'priority' => '12',
            'capability' => 'edit_theme_options'
        ));
        /**
         * Home Page feature area 1
         */
        $wp_customize->add_section('home_feature_area_section1', array(
            'title' => __('First Feature Area', 'salejunction'),
            'description' => __('Allows you to setup first feature area section for SaleJunction Theme.', 'salejunction'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page feature area 2
         */
        $wp_customize->add_section('home_feature_area_section2', array(
            'title' => __('Second Feature Area', 'salejunction'),
            'description' => __('Allows you to setup second feature area section for SaleJunction Theme.', 'salejunction'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page feature area 3
         */
        $wp_customize->add_section('home_feature_area_section3', array(
            'title' => __('Third Feature Area', 'salejunction'),
            'description' => __('Allows you to setup third feature area section for SaleJunction Theme.', 'salejunction'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page Feature area setting
         */
        $wp_customize->add_section('home_page_blog_headings', array(
            'title' => __('Home Page Blog Headings', 'salejunction'),
            'description' => __('Allows you to setup Blog heading Section for SaleJunction Theme.', 'salejunction'),
            'panel' => '',
            'priority' => '13',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Social Icon Section
         */
        $wp_customize->add_section('social_icon_section', array(
            'title' => __('Social Icons', 'salejunction'),
            'description' => __('Allows you to setup social site link for SaleJunction Theme.', 'salejunction'),
            'panel' => '',
            'priority' => '14',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Style Section
         */
        $wp_customize->add_section('style_section', array(
            'title' => __('Style Setting', 'salejunction'),
            'description' => __('Allows you to setup Top Footer Section Text for SaleJunction Theme.', 'salejunction'),
            'panel' => '',
            'priority' => '15',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Footer Section
         */
        $wp_customize->add_section('footer_settings', array(
            'title' => __('Footer Settings', 'salejunction'),
            'description' => __('Allows you to change style using custom css for SaleJunction Theme.', 'salejunction'),
            'panel' => '',
            'priority' => '16',
            'capability' => 'edit_theme_options'
                )
        );
    }

    public static function SaleJunction_Section_Content() {

        $section_content = array(
            'general_setting_section' => array(
                'salejunction_logo',
                'salejunction_favicon',
            ),
            'home_top_feature_area' => array(
                'salejunction_slideimage1',
                'salejunction_sliderheading1',
                'salejunction_Sliderlink1',
                'salejunction_sliderdes1',
                'salejunction_slider_button1'
            ),
            'home_page_blog_headings' => array(
                'salejunction_blog_heading',
                'salejunction_blog_desc'
            ),
            'style_section' => array(
                'salejunction_customcss'
            )
        );
        return $section_content;
    }

    public static function SaleJunction_Settings() {
        $salejunction_settings = array(
            'salejunction_logo' => array(
                'id' => 'salejunction_options[salejunction_logo]',
                'label' => __('Custom Logo', 'salejunction'),
                'description' => __('Choose your own logo. Optimal Size: 221px Wide by 84px Height.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/logo.png'
            ),
            'salejunction_favicon' => array(
                'id' => 'salejunction_options[salejunction_favicon]',
                'label' => __('Custom Favicon', 'salejunction'),
                'description' => __('Here you can upload a Favicon for your Website. Specified size is 16px x 16px.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => ''
            ),
            'salejunction_slideimage1' => array(
                'id' => 'salejunction_options[salejunction_slideimage1]',
                'label' => __('Top Feature Image', 'salejunction'),
                'description' => __('The optimal size of the image is 1600px wide x 455px height, but it can be varied as per your requirement.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/2.jpg'
            ),
            'salejunction_sliderheading1' => array(
                'id' => 'salejunction_options[salejunction_sliderheading1]',
                'label' => __('Top Feature Heading', 'salejunction'),
                'description' => __('Mention the heading for the Top Feature.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Create Exciting E-commerce Website', 'salejunction')
            ),
            'salejunction_Sliderlink1' => array(
                'id' => 'salejunction_options[salejunction_Sliderlink1]',
                'label' => __('Link for Top Feature Image', 'salejunction'),
                'description' => __('Mention the URL for first image.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            'salejunction_sliderdes1' => array(
                'id' => 'salejunction_options[salejunction_sliderdes1]',
                'label' => __('Top Feature Description', 'salejunction'),
                'description' => __('Here mention a short description for the Top Feature heading.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Sell your digital and tangible products with salejunction and earn money.', 'salejunction')
            ),
            'salejunction_slider_button1' => array(
                'id' => 'salejunction_options[salejunction_slider_button1]',
                'label' => __('Link Text for Top Feature', 'salejunction'),
                'description' => __('Mention the link text for top Feature Image', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Buy Now', 'salejunction')
            ),
            'salejunction_blog_heading' => array(
                'id' => 'salejunction_options[salejunction_blog_heading]',
                'label' => __('Home Page Main Heading', 'salejunction'),
                'description' => __('Mention the punch line for your business here.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Show Your Latest Posts.', 'salejunction')
            ),
            'salejunction_blog_desc' => array(
                'id' => 'salejunction_options[salejunction_blog_desc]',
                'label' => __('Home Page Main Heading', 'salejunction'),
                'description' => __('Mention the punch line for your business here.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Here you can showcase your latest blog and let users know about your recent activities.', 'salejunction')
            ),
            'salejunction_customcss' => array(
                'id' => 'salejunction_options[salejunction_customcss]',
                'label' => __('Custom CSS', 'salejunction'),
                'description' => __('Quickly add your custom CSS code to your theme by writing the code in this block.', 'salejunction'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => ''
            )
        );
        return $salejunction_settings;
    }

    public static function SaleJunction_Controls($wp_customize) {
        $sections = self::SaleJunction_Section_Content();
        $settings = self::SaleJunction_Settings();
        foreach ($sections as $section_id => $section_content) {
            foreach ($section_content as $section_content_id) {
                switch ($settings[$section_content_id]['setting_type']) {
                    case 'image':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'salejunction_sanitize_url');
                        $wp_customize->add_control(new WP_Customize_Image_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id']
                                )
                        ));
                        break;
                    case 'text':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'salejunction_sanitize_text');
                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));
                        break;
                    case 'textarea':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'salejunction_sanitize_textarea');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'textarea'
                                )
                        ));
                        break;
                    case 'link':

                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'salejunction_sanitize_url');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));

                        break;
                    default:
                        break;
                }
            }
        }
    }

    public static function add_setting($wp_customize, $setting_id, $default, $type, $sanitize_callback) {
        $wp_customize->add_setting($setting_id, array(
            'default' => $default,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => array('SaleJunction_Customizer', $sanitize_callback),
            'type' => $type
                )
        );
    }

    /**
     * adds sanitization callback funtion : textarea
     * @package SaleJunction
     */
    public static function salejunction_sanitize_textarea($value) {
        $array = wp_kses_allowed_html('post');
        $allowedtags = array(
            'iframe' => array(
                'width' => array(),
                'height' => array(),
                'frameborder' => array(),
                'scrolling' => array(),
                'src' => array(),
                'marginwidth' => array(),
                'marginheight' => array()
            )
        );
        $data = array_merge($allowedtags, $array);
        $value = wp_kses($value, $data);
        return $value;
    }

    /**
     * adds sanitization callback funtion : url
     * @package SaleJunction
     */
    public static function salejunction_sanitize_url($value) {
        $value = esc_url($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : text
     * @package SaleJunction
     */
    public static function salejunction_sanitize_text($value) {
        $value = sanitize_text_field($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : email
     * @package SaleJunction
     */
    public static function salejunction_sanitize_email($value) {
        $value = sanitize_email($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : number
     * @package SaleJunction
     */
    public static function salejunction_sanitize_number($value) {
        $value = preg_replace("/[^0-9+ ]/", "", $value);
        return $value;
    }

}

// Setup the Theme Customizer settings and controls...
add_action('customize_register', array('SaleJunction_Customizer', 'SaleJunction_Register'));

function inkthemes_registers() {
    wp_register_script('inkthemes_jquery_ui', '//code.jquery.com/ui/1.11.0/jquery-ui.js', array("jquery"), true);
    wp_register_script('inkthemes_customizer_script', get_template_directory_uri() . '/functions/js/inkthemes_customizer.js', array("jquery", "inkthemes_jquery_ui"), true);
    wp_enqueue_script('inkthemes_customizer_script');
    wp_localize_script('inkthemes_customizer_script', 'ink_advert', array(
        'pro' => __('View PRO version', 'salejunction'),
        'url' => esc_url('http://www.inkthemes.com/wp-themes/wordpress-marketplace-theme/'),
        'support_text' => __('Need Help!', 'salejunction'),
        'support_url' => esc_url('http://www.inkthemes.com/lets-connect/')
            )
    );
}

add_action('customize_controls_enqueue_scripts', 'inkthemes_registers');
