<?php

add_action('widgets_init', 'voordekunst_projects_register_widgets');
wp_enqueue_style( 'voordekunst-projects', plugins_url('css/voordekunst-projects.css', __FILE__),false,'1.0','all');

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
        $options = voordekunst_projects_options::get_options_by_project($project_id);
        $score = voordekunst_projects_db::get_latest_score($project_id);

        if (!$score || !$options) {
           return;
        } else {
            $template_html = file_get_contents(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'templates/donation-box.html');
            $template_html = str_replace('%image%', $options['image'], $template_html);
            $template_html = str_replace('%description%', $options['description'], $template_html);
            $template_html = str_replace('%title%', $score->title, $template_html);
            $template_html = str_replace('%percentage_donated%', $score->percentage_donated, $template_html);
            $template_html = str_replace('%donated_amount%', $score->donated_amount, $template_html);
            $template_html = str_replace('%goal_amount%', $score->goal_amount, $template_html);
            $template_html = str_replace('%num_donors%', $score->num_donors, $template_html);
            $template_html = str_replace('%url%', $score->url, $template_html);
            if ($score->num_days_left == '0') {
                $num_day_left = 'afgerond';
            } else {
                $num_day_left = $score->num_days_left;
            }
            $template_html = str_replace('%num_days_left%', $num_day_left, $template_html);
        }
        echo($args['before_widget']);
        echo $template_html;
        echo($args['after_widget']);
    }
}
