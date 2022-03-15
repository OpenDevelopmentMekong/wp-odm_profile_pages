<?php
// Filter section on non-desktop
if (!odm_screen_manager()->is_desktop()) : ?>
    <div class="row filter-container hideOnDesktop">
        <div class="sixteen columns mobile-filter-container">
            <input type="text" id="search_all" placeholder="<?php _e('Search data in profile page', 'wp-odm_profile_pages'); ?>">
            <a href="#" class="button filter open-mobile-dialog float-right" id="mobile-filter">
                <i class="fa fa-filter fa-lg"></i>
            </a>
        </div>
        <div class="fixed_datatable_tool_bar"></div>
    </div>

    <div class="row mobile-filter mobile-dialog hideOnDesktop">
        <div class="eight columns">
            <div class="close-mobile-dialog align-right">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>

        <div class="eight columns align-left">
            <?php _e("Filters", "wp-odm_profile_pages"); ?>
        </div>

        <div class="sixteen columns">
            <div class="panel panel_filter">
                <?php
                if (isset($related_profile_pages) && $related_profile_pages != '') :
                    $temp_related_profile_pages = preg_split('/\r\n|\r|\n/', $related_profile_pages);
                ?>
                    <div class="eight columns">
                        <?php if ($filtered_by_column_index) : ?>
                            <div id="filter_by_classification">
                                <p><?php _e('Filter by', 'wp-odm_profile_pages'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="eight columns">
                        <p><?php _e('Related profiles', 'wp-odm_profile_pages'); ?></p>
                        <ul class="related_profiles">
                            <?php foreach ($temp_related_profile_pages as $profile_pages_url) :
                                $split_title_and_url = explode('|', $profile_pages_url); ?>
                                <li>
                                    <a href="<?php echo $split_title_and_url[1]; ?>" target="_blank"><?php echo $split_title_and_url[0]; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else : ?>
                    <div class="sixteen columns">
                        <?php if ($filtered_by_column_index) : ?>
                            <div id="filter_by_classification">
                                <p><?php _e('Filter by', 'wp-odm_profile_pages'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <!-- Filter section on Desktop -->
    <div class="row hideOnMobileAndTablet sticky">
        <div class="sixteen columns">
            <div class="filter-container">
                <div class="panel_related_profile">
                    <?php if (odm_screen_manager()->is_desktop()) : ?>
                        <div class="filter_panel_toggle_icon">
                            <span><?php _e('Filters', 'wp-odm_profile_pages'); ?></span>
                            <i class="fa fa-times-circle"></i>
                        </div>
                    <?php endif ?>

                    <div class="panel panel_filter">
                        <!-- Search box -->
                        <div class="four columns">
                            <p><?php _e('Textual search', 'wp-odm_profile_pages'); ?></p>
                            <input type="text" id="search_all" placeholder="<?php _e('Search data in profile page', 'wp-odm_profile_pages'); ?>">
                        </div>

                        <!-- Filter and Related profile page -->
                        <?php
                        if (isset($related_profile_pages) && $related_profile_pages != '') :
                            $temp_related_profile_pages = preg_split('/\r\n|\r|\n/', $related_profile_pages);
                        ?>
                            <!-- Filter by Column  -->
                            <div class="seven columns">
                                <?php
                                if ($filtered_by_column_index) :
                                ?>
                                    <div id="filter_by_classification">
                                        <p>
                                            <?php _e('Filter by', 'wp-odm_profile_pages'); ?>
                                        </p>
                                    </div>
                                <?php
                                endif;
                                ?>
                            </div>
                            <!-- List of Related Profile -->
                            <div class="five columns">
                                <p><?php _e('Related profiles', 'wp-odm_profile_pages'); ?></p>
                                <ul class="related_profiles">
                                    <?php
                                    foreach ($temp_related_profile_pages as $temp_related_profile_page) :
                                        $split_title_and_url = explode('|', $temp_related_profile_page);
                                    ?>
                                        <il style="display: block;">
                                            <a href="<?php echo $split_title_and_url[1]; ?>" target="_blank">
                                                <?php echo $split_title_and_url[0]; ?>
                                            </a>
                                        </il>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <!-- Filter by Column Only-->
                            <div class="twelve columns">
                                <?php if ($filtered_by_column_index) : ?>
                                    <div id="filter_by_classification">
                                        <p><?php _e('Filter by', 'wp-odm_profile_pages'); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="fixed_datatable_tool_bar"></div>
                </div>
            </div>
        </div>
    </div>
<?php
endif;
