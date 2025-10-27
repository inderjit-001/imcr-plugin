<?php

function frontend_html() {
    // Collect dynamic rating labels
    $rating_labels = [];
    for ($i = 1; $i <= 5; $i++) {
        $label = get_option("imcr_rating_label_$i");
        if (!empty($label)) {
            $rating_labels[] = $label;
        }
    }

    // Start output buffering
    ob_start();
    ?>
    <div id="imcr-rating-box" data-post-id="<?php echo get_the_ID(); ?>">
        <h3>Rate this post</h3>

        <?php foreach ($rating_labels as $index => $label): ?>
            <div class="imcr-criteria" data-field="<?php echo esc_attr($index + 1); ?>">
                <label><?php echo esc_html($label); ?></label>
                <div class="imcr-stars">
                    <?php for ($star = 1; $star <= 5; $star++): ?>
                        <span data-value="<?php echo $star; ?>">★</span>
                    <?php endfor; ?>
                </div>
                <div class="imcr-average"><small>Average: <span class="avg">0</span>/5</small></div>
            </div>
        <?php endforeach; ?>

        <div class="imcr-review">
            <label>Write a review</label>
            <textarea placeholder="Your thoughts..."></textarea>
        </div>

        <button id="imcr-submit">Submit Rating</button>
        <div id="imcr-response"></div>
    </div>
    <?php
    // Return the buffered content as a string
    return ob_get_clean();
}

// Append the rating box to the content
add_action('template_redirect', 'imcr_add_custom_content');
function imcr_add_custom_content() {
    $selected_post_type = get_option('imcr_selected_post_type');
    if (empty($selected_post_type)) return;

    add_filter('the_content', 'imcr_append_message_to_content');
}

function imcr_append_message_to_content($content) {
    $selected_post_type = get_option('imcr_selected_post_type');
    if (is_singular($selected_post_type)) {
        $content .= frontend_html();
    }
    return $content;
}
