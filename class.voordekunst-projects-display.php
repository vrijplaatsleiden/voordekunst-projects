<?php

wp_enqueue_style('voordekunst-projects', plugins_url('css/voordekunst-projects.css', __FILE__),false,'1.0','all');

class voordekunst_projects_display
{
    public function register_shortcodes() {
        add_shortcode('vdk_project_percentage_donated', [ 'voordekunst_projects_display', 'sc_percentage_donated' ]);
        add_shortcode('vdk_project_donated_amount', [ 'voordekunst_projects_display', 'sc_donated_amount' ]);
        add_shortcode('vdk_project_num_donors', [ 'voordekunst_projects_display', 'sc_num_donors' ]);
        add_shortcode('vdk_project_num_days_left', [ 'voordekunst_projects_display', 'sc_num_days_left' ]);
        add_shortcode('vdk_project_goal_amount', [ 'voordekunst_projects_display', 'sc_goal_amount' ]);
    }

    public function sc_percentage_donated($attr) {
        if (isset($attr['id'])) {
            $percentage = self::get_project_data($attr['id'], 'percentage_donated');
            if ($percentage || $percentage == '0') {
                return $percentage . '%';
            }
        }
    }

    public function sc_donated_amount($attr) {
        if (isset($attr['id'])) {
            return self::get_project_data($attr['id'], 'donated_amount');
        }
    }

    public function sc_num_donors($attr) {
        if (isset($attr['id'])) {
            return self::get_project_data($attr['id'], 'num_donors');
        }
    }

    public function sc_num_days_left($attr) {
        if (isset($attr['id'])) {
            return self::get_project_data($attr['id'], 'num_days_left');
        }
    }

    public function sc_goal_amount($attr) {
        if (isset($attr['id'])) {
            return self::get_project_data($attr['id'], 'goal_amount');
        }
    }

    /**
     * widget html
     * @param int $project_id
     * @return string $html
     */
    public static function display_widget($project_id) {
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

        return $template_html;
    }

    private function get_project_data($project_id, $key) {
        $score = voordekunst_projects_db::get_latest_score($project_id);
        if ($score) {
            if (property_exists($score, $key)) {
                return $score->$key;
            }
        }
    }
}
