<?php
require_once(WP_PLUGIN_DIR . '/wp-odm_profile_pages/utils/profile-spreadsheet-post-meta.php');

$full_width_content     = get_post_meta(get_the_ID(), '_full_width_middle_content', true);
$full_width_position    = get_post_meta(get_the_ID(), '_full_width_content_position', true);
?>

<div class="container">
    <!-- Main content in WYSIWYG -->
    <div class="row">
        <div class="twelve columns">
            <section class="content section-content">
                <section class="post-content">
                    <?php the_content(); ?>
                </section>
            </section>
        </div>
        <div class="four columns">
            <aside id="sidebar">
                <ul class="widgets">
                    <li class="widget">
                        <?php odm_summary(); ?>
                    </li>
                    <?php dynamic_sidebar('profile-right-sidebar'); ?>
                </ul>
            </aside>
        </div>
    </div>

    <?php if ($full_width_content && $full_width_position) : ?>
        <!-- Full width middle content [above map] -->
        <div class="row">
            <div class="sixteen columns">
                <div class='full-width-content below-map'>
                    <?php _e($full_width_content); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Embedded Map -->
    <div class="row">
        <div class="sixteen columns">
            <?php
            if (function_exists('display_embedded_map')) :
                display_embedded_map(get_the_ID());
            endif;
            ?>
        </div>
    </div>

    <?php if ($full_width_content && !$full_width_position) : ?>
        <!-- Full width middle content [below map] -->
        <div class="row">
            <div class="sixteen columns">
                <div class='full-width-content below-map'>
                    <?php _e($full_width_content); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
    if ($profiles) :
        require_once(dirname(__FILE__) . '/../template-parts/total-records.php');

        require_once(dirname(__FILE__) . '/../template-parts/filter.php');

        require_once(dirname(__FILE__) . '/../template-parts/table-view.php');

        require_once(dirname(__FILE__) . '/../template-parts/profile-jquery.php');
    endif;
    ?>
</div>