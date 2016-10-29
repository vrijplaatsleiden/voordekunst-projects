<?php

class voordekunst_projects_db {

    private static $project_ids;

    private static function get_wpdb() {

        return $GLOBALS['wpdb'];
    }

    /**
     * @return string tableName
     */
    private static function get_table_name() {

        return self::get_wpdb()->prefix . 'vdk_projects';
    }

    /**
     * Create MySql table
     */
    public static function create_tables() {
        $table_name = self::get_table_name();
        $sql = sprintf("CREATE TABLE IF NOT EXISTS %s (
                            id INT AUTO_INCREMENT NOT NULL,
                            project_id INT NOT NULL,
                            created_at DATETIME NOT NULL,
                            title VARCHAR(255) NOT NULL,
                            donated_amount VARCHAR(25) DEFAULT '0',
                            goal_amount VARCHAR(25) DEFAULT '0',
                            num_donors INT DEFAULT 0,
                            percentage_donated INT DEFAULT 0,
                            num_days_left VARCHAR(25) NOT NULL,
                            url VARCHAR(255) NOT NULL,
                            PRIMARY KEY(id),
                            INDEX vdk_project_idx_1 (project_id, created_at DESC)
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;", $table_name);

        self::get_wpdb()->query($sql);
    }

    public static function delete_tables() {
        $table_name = self::get_table_name();
        $sql = sprintf('DROP TABLE IF EXISTS %s', $table_name);
        self::get_wpdb()->query($sql);
    }

    /**
     * @return array
     */
    public static function get_project_ids() {
        if (is_null(self::$project_ids)) {
            $sql = sprintf('SELECT DISTINCT project_id FROM %s', self::get_table_name());

            $rows = self::get_wpdb()->get_results($sql, OBJECT);
            self::$project_ids = [];
            foreach ($rows as $row) {
                self::$project_ids[] = $row->project_id;
            }
        }

        return self::$project_ids;
    }

    public static function get_latest_score($project_id) {
        $project_id = intval($project_id);

        $sql = sprintf(
            'SELECT *  FROM %s WHERE project_id = %d ORDER BY created_at DESC LIMIT 1',
            self::get_table_name(),
            $project_id);

        $results = self::get_wpdb()->get_results($sql, OBJECT);
        if (count($results)) {
            return $results[0];
        }
        return false;
    }
}
