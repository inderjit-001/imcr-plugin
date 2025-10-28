<?php

function frontend_html()
{
    $rating_labels = [];

    for ($i = 1; $i <= 5; $i++) {
        $label = get_option("imcr_rating_label_$i");
        if (!empty($label)) {
            $rating_labels[] = $label;
        }
    }

    ob_start();
?>

    <form method="post">
        <div id="imcr-rating-box" data-post-id="<?php echo get_the_ID(); ?>">
            <h3>Rate this post</h3>

            <?php foreach ($rating_labels as $index => $label): ?>
                <div class="imcr-criteria">
                    <label><?php echo esc_html($label); ?></label>
                    <select name="rating_<?php echo esc_attr($index + 1); ?>">
                        <option value="">Select</option>
                        <?php for ($star = 1; $star <= 5; $star++): ?>
                            <option value="<?php echo $star; ?>"><?php echo $star; ?> ★</option>
                        <?php endfor; ?>
                    </select>
                </div>
            <?php endforeach; ?>

            <div class="imcr-review">
                <label>Write a review</label>
                <textarea name="imcr_review" placeholder="Your thoughts..."></textarea>
            </div>

            <input type="hidden" name="imcr_post_id" value="<?php echo get_the_ID(); ?>">
            <input type="submit" name="imcr_submit" value="Submit Rating">
        </div>
    </form>

<?php
    // Handle form submission
    if (isset($_POST['imcr_submit'])) {
        global $wpdb;
        $table = $wpdb->prefix . 'imcr_post_ratings'; // your custom table name

        $post_id = intval($_POST['imcr_post_id']);
        $review = sanitize_textarea_field($_POST['imcr_review']);
        $user_id = get_current_user_id();

        // Collect ratings
        $ratings = [];
        foreach ($rating_labels as $index => $label) {
            $field = 'rating_' . ($index + 1);
            if (!empty($_POST[$field])) {
                $ratings[$label] = intval($_POST[$field]);
                print_r($ratings[$label]);
            }
        }



        // Insert each criterion rating
        $jsonData = "";

        $jsonData = json_encode($ratings);


        print_r($jsonData);

        $wpdb->insert(
            $table,
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'ratings' => $jsonData,
                'review' => $review,
            ],
            ['%d', '%d', '%s', '%s']
        );

        if ($wpdb->last_error) {
            echo 'Database error: ' . $wpdb->last_error;
        }

        echo '<div id="imcr-response">✅ Rating submitted successfully!</div>';
    }

    return ob_get_clean();
}


// Append the rating box to the content
add_action('template_redirect', 'imcr_add_custom_content');
function imcr_add_custom_content()
{
    $selected_post_type = get_option('imcr_selected_post_type');
    if (empty($selected_post_type)) return;

    add_filter('the_content', 'imcr_append_message_to_content');
}

function imcr_append_message_to_content($content)
{
    $selected_post_type = get_option('imcr_selected_post_type');
    if (is_singular($selected_post_type)) {
        $content .= frontend_html();
    }
    return $content;
}
