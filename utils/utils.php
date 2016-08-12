<?php

function odm_data_classification_definition($info)
{
    $info = trim($info);
    if ($info == 'កាត់បន្ថយ') {
        $info = 'Downsized';
    } elseif ($info == 'កាត់បន្ថយបន្ទាប់ពីដកហូត') {
        $info = 'Downsized after revocation';
    } elseif ($info == 'គ្មានភស្តុតាងនៃការផ្លាស់ប្តូរ') {
        $info = 'No evidence of adjustment';
    } elseif ($info == 'ដកហូត') {
        $info = 'Revoked';
    } elseif ($info == 'ទិន្នន័យរដ្ឋាភិបាលពេញលេញ') {
        $info = 'Government data complete';
    } elseif ($info == 'ទិន្នន័យរដ្ឋាភិបាលមិនពេញលេញ') {
        $info = 'Government data partial';
    } elseif ($info == 'ទិន្នន័យដទៃទៀត') {
        $info = 'Secondary source data';
    } elseif ($info == 'ទិន្នន័យបន្ទាប់បន្សំ') {
        $info = 'Other data';
    }

    $info = strtolower(str_replace(' ', '_', $info));
    echo '&nbsp; <div class="tooltip tooltip_definition ">';
    if ($info != '' && $info != __('Not found', 'odm')) {
        echo '<i class="fa fa-question-circle info-data-classification" title=""></i>';
    }
    if ($info == 'no_evidence_of_adjustment') {
        echo '<div class="tooltip-info tooltip-no_evidence_of_adjustment">';
        echo '<p>'.__('ODC is not aware of any adjustments to the concession since it was first granted.', 'odm');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'downsized') {
        echo '<div class="tooltip-info tooltip-downsized">';
        echo '<p>'.__('The concession has been subjected to additional reductions in size and has not been cancelled previously. Publicly available information on land area cut from ELCs does not include maps or spatial data of excisions. Thus, ODC cannot present land area cut in shapes. As a result, ELC projects that are visualized on the interactive map represent the original contract size.', 'odm');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'revoked') {
        echo '<div class="tooltip-info tooltip-revoked">';
        echo '<p>'.__('The concession has been cancelled with or without a history of reductions in size.', 'odm');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'downsized_after_revocation') {
        echo '<div class="tooltip-info tooltip-downsized_after_revocation">';
        echo '<p>'.__('The concession has been subjected to reduction(s) in size although it had been cancelled previously. Publicly available information on land area cut from ELCs does not include maps or spatial data of excisions. Thus, ODC cannot present land area cut in shapes. As a result, ELC projects that are visualized on the interactive map represent the original contract size.', 'odm');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'government_data_complete') {
        echo '<div class="tooltip-info tooltip-government_data_complete">';
        echo '<p>'.__('Information obtained from official Government sources, with official legal documentation, in the four identification fields: <br>a. Company name; <br>b. Location; <br>c. GPS coordinates and/or analog map; and <br>  d. Purpose (crop, ore, etc.)', 'odm').'</p>';
        echo '</div>';
    } elseif ($info == 'government_data_partial') {
        echo '<div class="tooltip-info tooltip-government_data_partial">';
        echo '<p>'.__('Information obtained from official Government sources, with legal documentation, but missing one or more of the following identification fields: <br>a. Company name; <br>b. Location; <br>c. GPS coordinates and/or analog map; and <br>d. Purpose (crop, ore, etc.)', 'odm').'</p>';
        echo '</div> ';
    } elseif ($info == 'other_data') {
        echo '<div class="tooltip-info tooltip-other_data">';
        echo '<p>'.__('Information obtained from any other source in public domain (including documentation from photographs, etc.)', 'odm').'</p>';
        echo '</div>';
    } elseif ($info == 'secondary_source_data') {
        echo '<div class="tooltip-info tooltip-secondary_source_data">';
        echo '<p>'.__('Information obtained from the concessionaire (company/entity) or from government source(s) without legal documentation.', 'odm').'</p>';
        echo '</div>';
    } elseif ($info == 'canceled_data') {
        echo '<div class="tooltip-info tooltip-canceled_data">';
        echo '<p>'.__('These concessions have been cancelled by the Royal Government of Cambodia.', 'odm').'</p>';
        echo '</div>';
    }
    echo '</div>';
}

function check_requirements_profile_pages()
{
    return function_exists('wpckan_get_ckan_domain') && function_exists('wpckan_validate_settings_read') && wpckan_validate_settings_read();
}

function odm_list_reference_documents($ref_docs, $only_title_url = 0)
{
    if ($only_title_url == 1) { ?>
    <ul>
      <?php
      foreach ($ref_docs as $key => $ref_doc):

        $split_old_address_and_filename = explode('?pdf=references/', $ref_doc);
        if (count($split_old_address_and_filename) > 1) {
            $ref_doc_name = $split_old_address_and_filename[1];
        } else {
            $ref_doc_name = $ref_doc;
        }

        $ref_doc_metadata = array();

        if (isset($ref_doc_name) && !empty($ref_doc_name)):
          $attrs = array('filter_fields' => '{"extras_odm_reference_document":"'.$ref_doc_name.'"}');
          $ref_doc_metadata = wpckan_api_package_search(wpckan_get_ckan_domain(), $attrs);
        endif;
        if (count($ref_doc_metadata['results']) > 0):

            foreach ($ref_doc_metadata['results'] as $key => $metadata):
                    $title = isset($metadata['title_translated']) ? $metadata['title_translated'] : $metadata['title']; ?>
                    <li><a target="_blank" href="<?php echo wpckan_get_link_to_dataset($metadata['name']); ?>"><?php echo getMultilingualValueOrFallback($title, odm_language_manager()->get_current_language(), $metadata['title']) ?></a>
                      <?php if ($metadata['type'] == 'laws_record' && (isset($metadata['odm_promulgation_date']))): ?>
                        <?php   if (odm_language_manager()->get_current_language() == 'km') {
      echo convert_date_to_kh_date(date('d/m/Y', strtotime($metadata['odm_promulgation_date'])), '/');
  } else {
      echo '('.$metadata['odm_promulgation_date'].')';
  }
        ?>
      <?php elseif ($metadata['type'] == 'library_records' && (isset($metadata['odm_publication_date']))):  ?>
                        <?php   if (odm_language_manager()->get_current_language() == 'km') {
      echo convert_date_to_kh_date(date('d/m/Y', strtotime($metadata['odm_publication_date'])), '/');
  } else {
      echo '('.$metadata['odm_publication_date'].')';
  }
        ?>
                      <?php endif;
        ?>
                    </li>
            <?php
            endforeach;
        endif;
        endforeach;
        ?>
    </ul>
  <?php

    } else {
        ?>
    <table id="reference" class="data-table">
      <tbody>
       <?php
       foreach ($ref_docs as $key => $ref_doc):
         $split_old_address_and_filename = explode('?pdf=references/', $ref_doc);
        if (count($split_old_address_and_filename) > 1) {
            $ref_doc_name = $split_old_address_and_filename[1];
        } else {
            $ref_doc_name = $ref_doc;
        }

        $ref_doc_metadata = array();
        if (isset($ref_doc_name) && !empty($ref_doc_name)):
          $attrs = array('filter_fields' => '{"extras_odm_reference_document":"'.$ref_doc_name.'"}');
          $ref_doc_metadata = wpckan_api_package_search(wpckan_get_ckan_domain(), $attrs);
        endif;
        if (count($ref_doc_metadata['results']) > 0):
           foreach ($ref_doc_metadata['results'] as $key => $metadata): ?>
               <tr>
                 <td class="row-key">
                   <a target="_blank" href="<?php echo wpckan_get_link_to_dataset($metadata['name']); ?>"><?php echo getMultilingualValueOrFallback($metadata['title_translated'], odm_language_manager()->get_current_language(), $metadata['title']) ?></a></br>
                   <div class="ref_date">
                     <?php if ($metadata['type'] == 'laws_record' && !(empty($metadata['odm_promulgation_date']))): ?>
                         <?php
                         if (odm_language_manager()->get_current_language() == 'km') {
                             echo convert_date_to_kh_date(date('d/m/Y', strtotime($metadata['odm_promulgation_date'])), '/');
                         } else {
                             echo '('.$metadata['odm_promulgation_date'].')';
                         } ?>
                     <?php elseif ($metadata['type'] == 'library_records' && !(empty($metadata['odm_publication_date']))):  ?>
                        <?php
                        if (odm_language_manager()->get_current_language() == 'km') {
                            echo convert_date_to_kh_date(date('d/m/Y', strtotime($metadata['odm_publication_date'])), '/');
                        } else {
                            echo '('.$metadata['odm_publication_date'].')';
                        } ?>
                     <?php endif; ?>
                   </div>
                 </td>
                 <td>
                   <?php $notes = isset($metadata['notes_translated']) ? $metadata['notes_translated'] : $metadata['notes'];
                    echo getMultilingualValueOrFallback($notes, odm_language_manager()->get_current_language(), $metadata['notes']);?></td>
               </tr>
           <?php
           endforeach;
        endif;
        endforeach;
        ?>
    </tbody>
  </table>
<?php

    }
}

function echo_download_buttons($dataset){
  ?>
    <div class="download_buttons">
      <?php
      if (isset($dataset['resources']) && $dataset['resources']):
          $file_format = array_count_values(
          array_map(function ($value) {
            return $value['format'];
          }, $dataset['resources']));
          foreach ($file_format as $format => $file_extention):
              if ($file_format[$format] > 1 &&  $format != 'CSV'): ?>
              <div class="format_button" id="format_<?php echo $format;?>">
                <a class="button download format" href="#"><i class="fa fa-download"></i> <?php echo $format;?></a>
                  <div class="show_list_format format_<?php echo $format?>">
                      <ul class="list_format">
                        <?php
                        foreach ($dataset['resources'] as $key => $resource) :
                          if ($resource['format'] == $format): ?>
                            <li>
                              <a href="<?php echo $resource['url'];?>"><?php echo $resource['name'];?></a>
                            </li>
                        <?php
                          endif;
                        endforeach; ?>
                      </ul>
                  </div>
              </div>
            <?php
              elseif (($file_format[$format] > 1) &&  ($format == 'CSV')):
                  foreach ($dataset['resources'] as $key => $resource) :
                    if ($resource['format'] == $format):
                        $file_version[] = $resource['odm_language'][0];
                    endif;
                  endforeach;
                  $count_file_version = array_count_values($file_version);
                  if ($count_file_version[odm_language_manager()->get_current_language()] > 1):?>
                    <div class="format_button" id="format_<?php echo $format;?>">
                      <a class="button download format" href="#"><i class="fa fa-download"></i> <?php echo $format;?></a>
                      <div class="show_list_format format_<?php echo $format?>">
                        <ul class="list_format">
                          <?php
                          foreach ($dataset['resources'] as $key => $resource) :
                            if (($resource['format'] == $format) && ($resource['odm_language'][0] == odm_language_manager()->get_current_language())): ?>
                              <li>
                                <a href="<?php echo $resource['url'];?>"><?php echo $resource['name'];?></a>
                              </li>
                          <?php
                          endif;
                        endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php
                else:
                  foreach ($dataset['resources'] as $key => $resource) :
                    if (($resource['format'] == $format) && ($resource['odm_language'][0] == odm_language_manager()->get_current_language())): ?>
                  <span>
                    <a class="button download format" target="_blank" href="<?php echo $resource['url'];?>">
                      <i class="fa fa-download"></i>  <?php echo $resource['format'];?>
                    </a>
                  </span>
                  <?php
                    endif;
                  endforeach;
                endif;
              else:
                  foreach ($dataset['resources'] as $key => $resource) :
                  if ($resource['format'] == $format): ?>
                <span>
                  <a target="_blank" href="<?php echo $resource['url'];?>">
                    <?php echo $resource['format'];?>
                  </a>
                </span>
              <?php
                endif;
                  endforeach;
              endif;
          endforeach; ?>
          <div>
         </div>
      <?php
    endif;?>
    </div>
  </div>
  <?php
}

function echo_metadata_button($dataset){
  ?>
  <a target="_blank" class="button download format" href="?metadata=<?php echo $dataset['id'];?>"><i class="fa fa-info"></i> <?php _e('Metadata', 'odm')?></a>
  <?php
}

?>

<?php function echo_view_metadata_and_download_button($dataset) { ?>
  <a target="_blank" class="button download format" href="?metadata=<?php echo $dataset['id'];?>"><i class="fa fa-info"></i> <?php _e('View metadata and download', 'odm')?></a>
<?php
} ?>
