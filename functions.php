<?php
/**
 * Register/enqueue custom scripts and styles
 */
add_action('wp_enqueue_scripts', function() {
    // Enqueue your files on the canvas & frontend, not the builder panel.
    // Otherwise, custom CSS might affect the builder)
    if (!bricks_is_builder_main()) {
        wp_enqueue_style(
            'bricks-child',
            get_stylesheet_uri(),
            ['bricks-frontend'],
            filemtime(get_stylesheet_directory() . '/style.css')
        );
    }
});

/**
 * Register custom elements
 */
add_action('init', function() {
    $element_files = [
        __DIR__ . '/elements/title.php',
        __DIR__ . '/elements/swb-element.php',
				__DIR__ . '/elements/element-two-column.php',

    ];

    foreach ($element_files as $file) {
        // Only register the file if it exists to prevent errors
        if (file_exists($file)) {
            \Bricks\Elements::register_element($file);
        }
    }
}, 11);

/**
 * Add text strings to builder
 */
add_filter('bricks/builder/i18n', function($i18n) {
    // For element category 'custom'
    $i18n['custom'] = esc_html__('Custom', 'bricks');

    return $i18n;
});

add_filter('bricks/builder/elements', function($elements) {
    // Check if the user has 'editor' role but not 'administrator' role
    if (current_user_can('editor') && !current_user_can('administrator')) {
        // Filter elements for roles except 'administrator'
        $not_needed = [
            'map',
            'alert',
            'countdown'
        ];

        // Use array_diff_key instead of array_diff for associative arrays
        // It assumes $elements is an associative array where keys are element names
        foreach ($not_needed as $element) {
            unset($elements[$element]);
        }
    }
    return $elements;
});
