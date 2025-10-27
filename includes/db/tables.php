<?php
/**
 * Create the custom table for storing post ratings
 */
function imcr_create_ratings_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'imcr_post_ratings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT UNSIGNED NOT NULL,
        user_id BIGINT UNSIGNED NOT NULL,
        ratings JSON NOT NULL,         -- stores criteria ratings like {\"Design\":5,\"Speed\":4}
        review TEXT DEFAULT NULL,      -- user written review
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_user_post (post_id, user_id),
        INDEX idx_post (post_id),
        INDEX idx_user (user_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}


