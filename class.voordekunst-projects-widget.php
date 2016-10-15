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
        $widget_opts = ['id' => 1];
        $this->WP_Widget('voordekunst_projects_widget', 'Voor de Kunst widget', $widget_opts);
    }

    public function widget($args, $instance) {
        $project_id = 1;
        $options = voordekunst_projects_options::get_options_by_project($project_id);
        $score = voordekunst_projects_db::get_latest_score($project_id);
        $template_html = file_get_contents(VOORDEKUNST_PROJECTS__PLUGIN_DIR . 'templates/donation-box.html');
        $template_html = str_replace('%image%', $options['image'], $template_html);
        $template_html = str_replace('%description%', $options['description'], $template_html);
        $template_html = str_replace('%title%', '', $template_html);
        $template_html = str_replace('%percentage_donated%', '', $template_html);
        $template_html = str_replace('%donated_amount%', $score->donated_amount, $template_html);
        $template_html = str_replace('%goal_amount%', $score->goal_amount, $template_html);
        $template_html = str_replace('%num_donors%', $score->num_donors, $template_html);
        $template_html = str_replace('%url%', $score->url, $template_html);

        echo($args['before_widget']);
        echo $template_html;
        echo($args['after_widget']);
    }
}
