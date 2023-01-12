<section class="container">
    <?php
    $full_width_content = get_post_meta(get_the_ID(), '_full_width_middle_content', true);
    $full_width_position = get_post_meta(get_the_ID(), '_full_width_content_position', true);

    if ($full_width_content && $full_width_position) : ?>
        <div class="row">
            <div class="sixteen columns">
                <div class="full-width-content above-map">
                    <?php _e($full_width_content); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="twelve columns post-title">
            <section class="content section-content">
                <?php
                if (function_exists('display_embedded_map')) {
                    display_embedded_map(get_the_ID());
                }
                ?>

                <section id="post-content">
                    <?php the_content(); ?>
                </section>
            </section>
        </div>

        <div class="four columns">
            <aside id="sidebar">
                <ul class="widgets">
                    <?php dynamic_sidebar('profile-area-1'); ?>
                </ul>
            </aside>
        </div>
    </div>
</section>

<?php if ($full_width_content && !$full_width_position) : ?>
    <div class="row">
        <div class="sixteen columns">
            <?php echo "<div class='full-width-content below-map'>" . $full_width_content . "</div>"; ?>
        </div>
    </div>
<?php endif; ?>

<section id="profile-area-bottom" class="page-section">
    <div class="container">
        <div class="row">
            <div class="eight columns">
                <?php dynamic_sidebar('profile-area-2'); ?>
            </div>
            <div class="eight columns">
                <?php dynamic_sidebar('profile-area-3'); ?>
            </div>
        </div>
    </div>
</section>