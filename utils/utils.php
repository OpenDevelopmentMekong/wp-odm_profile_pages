<?php

function odm_data_classification_definition($info) {
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
    if ($info != '' && $info != __('Unknown', 'wp-odm_profile_pages')) {
        echo '<i class="fa fa-question-circle info-data-classification" title=""></i>';
    }
    if ($info == 'no_evidence_of_adjustment') {
        echo '<div class="tooltip-info tooltip-no_evidence_of_adjustment">';
        echo '<p>'.__('ODC is not aware of any adjustments to the concession since it was first granted.', 'wp-odm_profile_pages');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'downsized') {
        echo '<div class="tooltip-info tooltip-downsized">';
        echo '<p>'.__('The concession has been subjected to additional reductions in size and has not been cancelled previously. Publicly available information on land area cut from ELCs does not include maps or spatial data of excisions. Thus, ODC cannot present land area cut in shapes. As a result, ELC projects that are visualized on the interactive map represent the original contract size.', 'wp-odm_profile_pages');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'revoked') {
        echo '<div class="tooltip-info tooltip-revoked">';
        echo '<p>'.__('The concession has been cancelled with or without a history of reductions in size.', 'wp-odm_profile_pages');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'downsized_after_revocation') {
        echo '<div class="tooltip-info tooltip-downsized_after_revocation">';
        echo '<p>'.__('The concession has been subjected to reduction(s) in size although it had been cancelled previously. Publicly available information on land area cut from ELCs does not include maps or spatial data of excisions. Thus, ODC cannot present land area cut in shapes. As a result, ELC projects that are visualized on the interactive map represent the original contract size.', 'wp-odm_profile_pages');
        echo '</p>';
        echo '</div>';
    } elseif ($info == 'government_data_complete') {
        echo '<div class="tooltip-info tooltip-government_data_complete">';
        echo '<p>'.__('Information obtained from official Government sources, with official legal documentation, in the four identification fields: <br>a. Company name; <br>b. Location; <br>c. GPS coordinates and/or analog map; and <br>  d. Purpose (crop, ore, etc.)', 'wp-odm_profile_pages').'</p>';
        echo '</div>';
    } elseif ($info == 'government_data_partial') {
        echo '<div class="tooltip-info tooltip-government_data_partial">';
        echo '<p>'.__('Information obtained from official Government sources, with legal documentation, but missing one or more of the following identification fields: <br>a. Company name; <br>b. Location; <br>c. GPS coordinates and/or analog map; and <br>d. Purpose (crop, ore, etc.)', 'wp-odm_profile_pages').'</p>';
        echo '</div> ';
    } elseif ($info == 'other_data') {
        echo '<div class="tooltip-info tooltip-other_data">';
        echo '<p>'.__('Information obtained from any other source in public domain (including documentation from photographs, etc.)', 'wp-odm_profile_pages').'</p>';
        echo '</div>';
    } elseif ($info == 'secondary_source_data') {
        echo '<div class="tooltip-info tooltip-secondary_source_data">';
        echo '<p>'.__('Information obtained from the concessionaire (company/entity) or from government source(s) without legal documentation.', 'wp-odm_profile_pages').'</p>';
        echo '</div>';
    } elseif ($info == 'canceled_data') {
        echo '<div class="tooltip-info tooltip-canceled_data">';
        echo '<p>'.__('These concessions have been cancelled by the Royal Government of Cambodia.', 'wp-odm_profile_pages').'</p>';
        echo '</div>';
    }
    echo '</div>';
}

function check_requirements_profile_pages()
{
    return function_exists('wpckan_get_ckan_domain') && function_exists('wpckan_validate_settings_read') && wpckan_validate_settings_read();
}

function odm_count_total_of_value($attr, $profiles, $field_label){
    // Display Total list
    $show_total_value = "";
    $array_map_profile = array();
    $id = '_id';
    $map_id = "map_id";
    ?>
    <!-- List total of dataset by map_id as default-->
    <?php
      if (count($profiles)):
        $show_total_value .= "<li><strong>";
        if(odm_language_manager()->get_current_language() == "km"):
          $show_total_value .= __("Total", "wp-odm_profile_pages").get_the_title(). __("Listed", "wp-odm_profile_pages"). __(":", "wp-odm_profile_pages");
          $show_total_value .= count($profiles)? convert_to_kh_number(count($profiles)) : convert_to_kh_number("0");
        else:
          $show_total_value .=  __("Total", "wp-odm_profile_pages")." ".get_the_title(). __(" listed", "wp-odm_profile_pages"). __(": ", "wp-odm_profile_pages");
          $show_total_value .= count($profiles)? count($profiles): "0";
        endif;
        $show_total_value .= "</strong></li>";
      endif;

      if($attr):
        $explode_total_number_by_attribute_name = explode("\r\n", $attr);
        foreach ($explode_total_number_by_attribute_name as $key => $total_attribute_name):
          if(($total_attribute_name != $map_id) && ($total_attribute_name != $id )): //if not map_id or _id
            //check if total number require to list by Specific value
            $total_attributename = trim($total_attribute_name);
            if (strpos($total_attribute_name, '[') !== FALSE):
              $split_field_name_and_value = explode("[", $total_attributename);
              $total_attributename = trim($split_field_name_and_value[0]); //eg. data_class
              $total_by_specifit_value = str_replace("]", "", $split_field_name_and_value[1]);
              $specifit_value = explode(',', $total_by_specifit_value);// explode to get: Government data complete
            endif;
            $GLOBALS['total_attribute_name'] = $total_attributename;
            $map_value = array_map(function($value){ return $value[$GLOBALS['total_attribute_name']];}, $profiles);
            $count_number_by_attr =  array_count_values($map_value); ?>

            <?php
            if(isset($specifit_value) && count($specifit_value) > 0):
              foreach ($specifit_value as $field_value):
                $field_value = trim(str_replace('"', "",$field_value));
                $show_total_value .= '<li>'.__($field_value, "wp-odm_profile_pages"). __(": ", "wp-odm_profile_pages");

                if(isset($count_number_by_attr[$field_value])):
                  $show_total_value .=  $count_number_by_attr[$field_value]? convert_to_kh_number($count_number_by_attr[$field_value]) :  convert_to_kh_number("0") .'</li>';
                else:
                  $show_total_value .=   convert_to_kh_number("0") .'</li>';
                endif;
              endforeach;
            else:
              if(($total_attribute_name != $map_id) && ($total_attribute_name != $id )):
                $show_total_value .= "<li>";
                if(odm_language_manager()->get_current_language() == "km"):
                  $show_total_value .= __("Total", "wp-odm_profile_pages").$field_label[$total_attributename].__("Listed", "wp-odm_profile_pages").__(":", "wp-odm_profile_pages");
                  $show_total_value .= '<strong>'.$total_attributename?convert_to_kh_number(count($count_number_by_attr)): convert_to_kh_number("0").'</strong>';
                else:
                  $show_total_value .=  __("Total", "wp-odm_profile_pages")." ".$field_label[$total_attributename]." ". __(" listed", "wp-odm_profile_pages").__(": ", "wp-odm_profile_pages");
                  $show_total_value .= '<strong>'.$total_attributename? count($count_number_by_attr): "0".'</strong>';
                endif;
                $show_total_value .= "</li>";
              endif;
            endif;
          endif;
        endforeach;
      endif;
      if($show_total_value):
        echo '<div class="total_listed">';
          echo "<ul>";
            echo $show_total_value;
          echo "</ul>";
        echo "</div>";
      endif;

}

function odm_list_reference_documents($ref_docs, $only_title_url = 0, $include_ul_or_table_tag = 1) {
  $display_reference_list = null;
  if ($only_title_url == 1 && $include_ul_or_table_tag == 1) {
    $display_reference_list = '<ul style="min-width:300px">';
  }else{
    if($include_ul_or_table_tag == 1){
      $display_reference_list = '<table id="reference" class="data-table">
              <tbody>';
      }
  }
  foreach ($ref_docs as $key => $ref_doc):
      $split_old_address_and_filename = explode('?pdf=references/', $ref_doc);
      if (count($split_old_address_and_filename) > 1) {
          $ref_doc_name = $split_old_address_and_filename[1];
      } else {
          $ref_doc_name = $ref_doc;
      }
      //echo $ref_doc;
      $ref_doc_metadata = array();
      if (isset($ref_doc_name) && !empty($ref_doc_name)):
          $attrs = array('filter_fields' => '{"odm_reference_document":"'.$ref_doc_name.'"}', 'limit' => 1);
          $ref_doc_metadata = wpckan_api_package_search(wpckan_get_ckan_domain(), $attrs);
          if(isset($ref_doc_metadata['results']) && (count($ref_doc_metadata['results']) > 0) ):
              $metadata = $ref_doc_metadata['results'][0];

              $title = isset($metadata['title_translated']) ? $metadata['title_translated'] : $metadata['title'];
              $notes = isset($metadata['notes_translated']) ? $metadata['notes_translated'] : $metadata['notes'];
              $name = $metadata['name'];
              if ($metadata['type'] == 'laws_record' && (isset($metadata['odm_promulgation_date'])) ):
                $published_date = $metadata['odm_promulgation_date'];
              elseif (isset($metadata['odm_date_uploaded']) ):
                $published_date = $metadata['odm_date_uploaded'];
              endif;

              $archive_refdoc[] = $ref_doc_name;
              $archive_refdoc_info[] = array('odm_reference_document'=> $ref_doc_name, 'title'=>$title, 'link'=>$metadata['name'], 'description' => $notes, 'date' =>$published_date);
          endif;
      endif;

      if(isset($metadata)):
        if (trim($metadata['odm_reference_document']) == $ref_doc_name):
             if ($only_title_url == 1) {
               $display_reference_list .='<li><a target="_blank" href="'. wpckan_get_link_to_dataset($name).'">'. getMultilingualValueOrFallback($title, odm_language_manager()->get_current_language(), $title).'</a>';
                  if (odm_language_manager()->get_current_language() == 'km') {
                      $display_reference_list .= ' ('.convert_date_to_kh_date(date('d/m/Y', strtotime($published_date)), '/') .')';
                  } else {
                      $display_reference_list .= ' ('. date("d F Y" ,strtotime($published_date)) .')';
                  }
               $display_reference_list .='</li>';
             }else{
               $display_reference_list .='<tr>';
                 $display_reference_list .='<td class="row-key" width="35%">';
                     $display_reference_list .='<a target="_blank" href="'.wpckan_get_link_to_dataset($name).'">'. getMultilingualValueOrFallback($title, odm_language_manager()->get_current_language(), $title) .'</a></br>';
                     $display_reference_list .='<div class="ref_date">';
                       if (odm_language_manager()->get_current_language() == 'km') {
                           $display_reference_list .= ' ('.convert_date_to_kh_date(date('d/m/Y', strtotime($published_date)), '/') .')';
                       } else {
                             $display_reference_list .= ' ('. date("d F Y" ,strtotime($published_date)) .')';
                       }
                     $display_reference_list .='</div>';
                     $display_reference_list .='</td>';
                     $display_reference_list .='<td>';
                        $display_reference_list .= getMultilingualValueOrFallback($notes, odm_language_manager()->get_current_language(), $notes);
                     $display_reference_list .='</td>';
              $display_reference_list .='</tr>';
             }
         else:
           continue;
         endif; //count
     endif;
   endforeach;

   if ($only_title_url == 1 && $include_ul_or_table_tag == 1) {
       $display_reference_list .= '</ul>';
   }else{
     if($include_ul_or_table_tag == 1){
       $display_reference_list .= '</tbody></table>';
     }
   }
   return $display_reference_list;
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
                <a class="button download format" href="#"><?php echo $format;?></a>
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
                      <a class="button download format" href="#"><?php echo $format;?></a>
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
  <a target="_blank" class="button download format metadata_button" href="?metadata=<?php echo $dataset['id'];?>"><i class="fa fa-info"></i> <?php _e('Metadata', 'wp-odm_profile_pages')?></a>
  <?php
}

function echo_download_button_link_to_datapage($dataset_id, $only_hyperlink=false){
  if(!$only_hyperlink):?>
    <div class="nc_socialPanel widget_download">
      <div class="nc_tweetContainer swp_fb">
  <?php endif; ?>
        <a target="_blank" class="button download format" href="<?php echo get_bloginfo("url"); ?>/dataset/?id=<?php echo $dataset_id;?>"><i class="fa fa-download"></i>
          <span>
          <?php
          if (odm_screen_manager()->is_desktop()):
            _e('Download and Metadata', 'wp-odm_profile_pages');
          endif; ?>
          </span>
        </a>
    <?php if(!$only_hyperlink):?>
      </div>
    </div>
    <?php endif; ?>
  <?php
}
?>
