<?php

class voordekunst_projects_options {

    const OPTIONS_KEY = 'voordekunst_projects_options';

    public static function get_options() {

        $currentOptions = get_option(self::OPTIONS_KEY);

        $project_ids = voordekunst_projects_db::get_project_ids();
        return  self::add_possible_new_options($currentOptions, $project_ids);
    }

    public static function get_options_by_project($project_id) {
        $options = self::get_options();
        $options_by_project = [];

        foreach($options as $optionKey => $optionValue) {
            $parts = explode('_', $optionKey);
            if ($parts[1] == $project_id) {
                $options_by_project[$parts[2]] = $optionValue;
            }
        }

        if (count($options)) {
            return $options_by_project;
        }

        return false;
    }

    public static function get_option_key($project_id, $type) {

        return sprintf('option_%d_%s', $project_id, $type);
    }

    private static function add_possible_new_options($options, $project_ids) {

        $option_added = false;
        $option_types = [
            'image' => plugins_url('img/logo-vdk.svg', __FILE__),
            'description' => 'short description of your project'
        ];

        foreach($project_ids as $project_id) {
            foreach($option_types as $type => $default_value) {
                $option_key = self::get_option_key($project_id, $type);
                if (!isset($options[$option_key])) {
                    $option_added = true;
                    $options[$option_key] = $default_value;
                }
            }
        }
        if ($option_added) {
            update_option(self::OPTIONS_KEY, $options);
        }
        return $options;
    }

    public static function delete_options() {
        delete_option(self::OPTIONS_KEY);
    }
}

