<div class="row no-margin-buttom">
    <div class="sixteen columns table-column-container">
        <table id="profiles" class="data-table">
            <thead>
                <tr>
                    <th>
                        <div class='th-value'>
                            <?php _e('Map ID', 'wp-odm_profile_pages'); ?>
                        </div>
                    </th>

                    <?php
                    if ($DATASET_ATTRIBUTE) :
                        foreach ($DATASET_ATTRIBUTE as $key => $value) : ?>
                            <th>
                                <div class='th-value'>
                                    <?php _e($DATASET_ATTRIBUTE[$key], 'wp-odm_profile_pages'); ?>
                                </div>
                            </th>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($profiles) :
                    foreach ($profiles as $profile) : ?>
                        <tr>
                            <td class="td-value-id">
                                <?php echo trim($profile[$id]); ?>
                            </td>
                            <?php
                            if ($DATASET_ATTRIBUTE) :
                                foreach ($DATASET_ATTRIBUTE as $key => $value) :
                                    $link_to_detail_column_array = explode(',', $link_to_detail_column);

                                    if (array_key_exists($key, $profile)) :
                                        if (in_array($key, $link_to_detail_column_array)) :
                                        ?>
                                            <td class="entry_title">
                                                <div class="td-value">
                                                    <?php 
                                                    if ($link_to_detail_page) :
                                                        if ( $profile[$link_to_detail_page] ) :
                                                        ?>
                                                            <a target="_blank" href="<?php echo $profile[$link_to_detail_page]; ?>">
                                                                <?php echo $profile[$key]; ?>
                                                            </a>
                                                        <?php 
                                                        else :
                                                            echo $profile[$key];
                                                        endif;
                                                    else : ?>
                                                        <a target="_blank" href="?feature_id=<?php echo $profile[$id]; ?>">
                                                            <?php echo $profile[$key]; ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        <?php elseif (in_array($key, array('data_class', 'adjustment_classification', 'adjustment'))) : ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php
                                                    if (odm_language_manager()->get_current_language() == 'en') :
                                                        echo ucwords(trim($profile[$key]));
                                                    else :
                                                        echo trim($profile[$key]);
                                                    endif;

                                                    odm_data_classification_definition($profile[$key]);
                                                    ?>
                                                </div>
                                            </td>
                                        <?php elseif ($key == 'reference') : ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php
                                                    $ref_docs_profile = explode(';', $profile['reference']);
                                                    $ref_docs = array_unique(array_merge($ref_docs_profile, $ref_docs_tracking));
                                                    odm_list_reference_documents($ref_docs, 1);
                                                    ?>
                                                </div>
                                            </td>
                                        <?php elseif ($key == 'issuedate') : ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php
                                                    $issuedate = str_replace('T00:00:00', '', $profile[$key]);
                                                    echo $profile[$key] == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($issuedate));
                                                    ?>
                                                </div>
                                            </td>
                                        <?php elseif (in_array($key, array('cdc_num', 'sub-decree', 'year'))) :
                                            if (odm_language_manager()->get_current_language() == 'km') :
                                                $profile_value = convert_to_kh_number($profile[$key]);
                                            else :
                                                $profile_value = $profile[$key];
                                            endif; ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php echo $profile_value == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($profile_value)); ?>
                                                </div>
                                            </td>
                                        <?php elseif ( in_array( $key, array( 'eia_l', 'eia_link' ) ) ) : ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php if ( $profile[$key] ) : ?>
                                                        <a target="_blank" href="<?php echo $profile[$key]; ?>">
                                                            <?php _e( 'EIA report', 'wp-odm_profile_pages' ); ?>
                                                        </a>
                                                    <?php
                                                    else :
                                                        _e( 'Not found', 'wp-odm_profile_pages' );
                                                    endif;
                                                    ?>
                                                </div>
                                            </td>
                                        <?php
                                        else :
                                            $profile_val = str_replace('T00:00:00', '', $profile[$key]);

                                            if (odm_language_manager()->get_current_language() == 'km') :
                                                if (is_numeric($profile_val)) :
                                                    $profile_value = convert_to_kh_number(str_replace('.00', '', number_format($profile_val, 2, '.', ',')));
                                                else :
                                                    $profile_value = str_replace('__', ' ', $profile_val);
                                                endif;
                                            else :
                                                if (is_numeric($profile_val)) :
                                                    $profile_value = str_replace('.00', '', number_format($profile_val, 2, '.', ','));
                                                else :
                                                    $profile_value = str_replace('__', ', ', $profile_val);
                                                endif;
                                            endif;

                                            $profile_value = str_replace(';', '<br/>', trim($profile_value)); ?>
                                            <td>
                                                <div class="td-value">
                                                    <?php echo $profile[$key] == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($profile_value)); ?>
                                                </div>
                                            </td>
                                        <?php
                                        endif;
                                    else : ?>
                                        <td>
                                            <div class="td-value">
                                                <?php _e('Unknown', 'wp-odm_profile_pages'); ?>
                                            </div>
                                        </td>
                                    <?php
                                    endif;
                                endforeach; 
                            endif;
                            ?>
                        </tr>
                    <?php
                    endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>