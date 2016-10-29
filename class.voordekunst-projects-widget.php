<?php

add_action('widgets_init', 'voordekunst_projects_register_widgets');

function voordekunst_projects_register_widgets() {
    register_widget('voordekunst_projects_widget');
}

class voordekunst_projects_widget extends WP_widget {

    /**
     * voordekunst_projects_widget constructor.
     */
    public function voordekunst_projects_widget() {
        $widget_opts = [
            'classname' => 'voordekunst-widget',
            'description' => 'Box containing Voor de Kunst project donation status'
        ];

        $this->WP_Widget('voordekunst_projects_widget', 'Voor de Kunst widget', $widget_opts);
    }

    public function form($instance) {
        $defaults = ['project_id' => 0];
        $instance = wp_parse_args((array) $instance, $defaults);
        $project_id = $instance['project_id'];

        $formField = sprintf(
            '<p><input class="widefat" name="%s" type="text" value="%s" /></p>',
            $this->get_field_name('project_id'),
            $project_id
        );

        echo $formField;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['project_id'] = strip_tags($new_instance['project_id']);

        return $instance;
    }

    public function widget($args, $instance) {
        $project_id = $instance['project_id'];

        echo($args['before_widget']);
        echo voordekunst_projects_display::display_widget($project_id);
        echo($args['after_widget']);
    }
}
