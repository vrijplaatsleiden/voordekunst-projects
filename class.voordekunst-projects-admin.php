<?php

class voordekunst_projects_admin {

    private static $initiated = false;

    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {

        add_action('admin_menu', ['voordekunst_projects_admin', 'create_menu']);
        add_action('admin_init', ['voordekunst_projects_admin', 'admin_init']);

        self::$initiated = true;
    }

    public static function create_menu() {
        add_options_page(
            'Voor de Kunst Projects settings',
            'Voor de Kunst',
            'manage_options',
            __FILE__,
            ['voordekunst_projects_admin', 'option_page']
        );
    }

    public static function option_page() {
        $htmlPre = '<h1>Voor de Kunst Projects</h1>'
              . '<div class="wrap">'
              . '  <form action="options.php" method="POST">';

        $htmlPost = '     <input class="button-primary" name="Submit" type="submit" value="Save changes">'
              . '  </form>'
              . '</div>';

        echo $htmlPre;
        settings_fields(voordekunst_projects_options::OPTIONS_KEY);
        do_settings_sections('voordekunst_projects');
        echo $htmlPost;
    }

    public static function validate_options($input) {
        return $input;
    }

    public static function admin_init() {

        register_setting(
            'voordekunst_projects_options',
            voordekunst_projects_options::OPTIONS_KEY,
            ['voordekunst_projects_admin', 'validate_options']
        );

        add_settings_section(
            'voordekunst_projects_main',
            'settings',
            ['voordekunst_projects_admin', 'settings_text'],
            'voordekunst_projects'
        );

        $options = voordekunst_projects_options::get_options();

        foreach($options as $key => $value) {
            add_settings_field(
                $key,
                self::get_label($key),
                ['voordekunst_projects_admin', 'setting_input'],
                'voordekunst_projects',
                'voordekunst_projects_main',
                ['key' => $key, 'value' => $value ]
            );
        }
    }

    public static function settings_text() {
        echo '<p>Please add an image and a project description to your Voor de Kunst projects</p>';
    }

    public static function setting_input($args) {
        if (strpos($args['key'], 'description')) {
            echo sprintf(
                '<textarea id="%s" name="%s[%s]" class="widefat">%s</textarea>',
                $args['key'],
                voordekunst_projects_options::OPTIONS_KEY,
                $args['key'],
                esc_attr($args['value']));
        } else {
            // image
            echo sprintf(
                '<input id="%s" name="voordekunst_projects_options[%s]" type="text" class="regular-text ltr" value="%s" />',
                $args['key'],
                $args['key'],
                esc_url($args['value']));

        }
    }

    private static function get_label($option) {
        $parts = explode('_', $option);
        if ($parts[2] == 'image') {
            return sprintf('Image (project %d)', $parts[1]);
        } else {
            return sprintf('Description (project %d)', $parts[1]);
        }
    }
}
