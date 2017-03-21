<?php require_once PLUGIN_DIR.'/utils/profile-spreadsheet-post-meta.php'; ?>
<div class="container">
  <div class="row">
    <div class="sixteen columns">
      <?php
      if(function_exists('display_embedded_map')){
        display_embedded_map(get_the_ID());
      }
      ?>
    </div>
  </div>
  <?php
    if (odm_language_manager()->get_current_language() !== 'en') {
      $middle_content = get_post_meta(get_the_ID(), '_full_width_middle_content_localization', true);
    }else {
      $middle_content = get_post_meta(get_the_ID(), '_full_width_middle_content', true);
    }
    if($middle_content):
      ?>
      <div class="row">
        <div class="sixteen columns">
          <?php echo "<div class='iframe-visualitation'>".$middle_content."</div>"; ?>
        </div>
      </div>
  <?php endif; ?>

<?php if($profiles){ ?>
    <div class="row">
      <div class="sixteen columns">
        <?php
          // Display Total list
          $show_total_value = "";
          $array_map_profile = array();
          $id = '';

          if (array_key_exists("map_id", $profiles[0])){
            $array_map_profile = array_map(function($value){return array_key_exists('map_id', $value) ? $value['map_id'] : "";}, $profiles);
            $id = "map_id";
          }else {
            $array_map_profile = array_map(function($value){return array_key_exists('_id', $value) ? $value['_id'] : "";}, $profiles);
            $id = "_id";
          }

          if($array_map_profile){
            $count_project =  array_count_values($array_map_profile);
          }
          ?>
          <!-- List total of dataset by map_id as default-->
  				<?php if (count($count_project) > 1) {
                  $show_total_value .= "<li><strong>";
                  if(odm_language_manager()->get_current_language() == "km"):
                    $show_total_value .= __("Total", "wp-odm_profile_pages").get_the_title(). __("Listed", "wp-odm_profile_pages"). __(":", "wp-odm_profile_pages");
                    $show_total_value .= $count_project==""? convert_to_kh_number("0"):convert_to_kh_number(count($count_project));
                  else:
                    $show_total_value .=  __("Total", "wp-odm_profile_pages")." ".get_the_title(). __(" listed", "wp-odm_profile_pages"). __(": ", "wp-odm_profile_pages");
                    $show_total_value .= $count_project==""? "0":count($count_project);
                  endif;
                  $show_total_value .= "</strong></li>";
                }
                $explode_total_number_by_attribute_name = explode("\r\n", $total_number_by_attribute_name);
                if($total_number_by_attribute_name!=""){
                  foreach ($explode_total_number_by_attribute_name as $key => $total_attribute_name) {
                    if($total_attribute_name != $id ){
                    //check if total number require to list by Specific value
                    $total_attributename = trim($total_attribute_name);
                    if (strpos($total_attribute_name, '[') !== FALSE){ //if march
                    $split_field_name_and_value = explode("[", $total_attributename);
                    $total_attributename = trim($split_field_name_and_value[0]); //eg. data_class
                    $total_by_specifit_value = str_replace("]", "", $split_field_name_and_value[1]);
                    $specifit_value = explode(',', $total_by_specifit_value);// explode to get: Government data complete
                    } //end strpos
                    $GLOBALS['total_attribute_name'] = $total_attributename;
                    $map_value = array_map(function($value){ return $value[$GLOBALS['total_attribute_name']];}, $profiles);
                    $count_number_by_attr =  array_count_values($map_value);
                    ?>

                    <?php //count number by value: eg. Government data complete
                    if(isset($specifit_value) && count($specifit_value) > 0){
                      foreach ($specifit_value as $field_value) {
                        $field_value = trim(str_replace('"', "",$field_value));
                        $show_total_value .= '<li>'.__($field_value, "wp-odm_profile_pages"). __(": ", "wp-odm_profile_pages");
                        if(isset($count_number_by_attr[$field_value])){
                          $show_total_value .= '<strong>'. $count_number_by_attr[$field_value]==""? convert_to_kh_number("0"):convert_to_kh_number($count_number_by_attr[$field_value]).'</strong></li>';
                        }
                      }//end foreach
                    }else { //count number by field name/attribute name: eg. map_id/developer
                      if($total_attribute_name != $id ){
                        $show_total_value .= "<li>";
                        if(odm_language_manager()->get_current_language() == "km"):
                          $show_total_value .= __("Total", "wp-odm_profile_pages").$DATASET_ATTRIBUTE[$total_attributename].__("Listed", "wp-odm_profile_pages").__(":", "wp-odm_profile_pages");
                          $show_total_value .= '<strong>'.$total_attributename==""? convert_to_kh_number("0"):convert_to_kh_number(count($count_number_by_attr)).'</strong>';
                        else:
                          $show_total_value .=  __("Total", "wp-odm_profile_pages")." ".$DATASET_ATTRIBUTE[$total_attributename]." ". __(" listed", "wp-odm_profile_pages").__(": ", "wp-odm_profile_pages");
                          $show_total_value .= '<strong>'.$total_attributename==""? "0": count($count_number_by_attr).'</strong>';
                        endif;
                        $show_total_value .= "</li>";
                      }
                    }//end if $specifit_value
                  }//if not map_id
                }//foreach $explode_total_number_by_attribute_name
                }//if exist
                if($show_total_value){
                  echo '<div class="total_listed">';
                    echo "<ul>";
                      echo $show_total_value;
                    echo "</ul>";
                  echo "</div>";
                }

        ?>
      </div>
    </div>

    <div class="row">
      <div class ="sixteen columns">
        <div class="filter-container">
          <div class="panel">
            <div class="four columns">
              <p><?php _e('Textual search', 'wp-odm_profile_pages');?></p>
              <input type="text" id="search_all" placeholder="<?php _e('Search data in profile page', 'wp-odm_profile_pages'); ?>">
            </div>
            <?php
            if (isset($related_profile_pages) && $related_profile_pages != '') {
              $temp_related_profile_pages = explode("\r\n", $related_profile_pages);  ?>
              <div class="seven columns">
                <?php
                  if ($filtered_by_column_index): ?>
                  <div id="filter_by_classification">
                    <p><?php _e('Filter by', 'wp-odm_profile_pages');?></p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="five columns">
                <p><?php _e('Related profiles', 'wp-odm_profile_pages');?></p>
                <ul>
                <?php foreach ($temp_related_profile_pages as $profile_pages_url) :
                    $split_title_and_url = explode('|', $profile_pages_url);?>
                    <li>
                      <a href="<?php echo $split_title_and_url[1]; ?>" target="_blank"><?php echo $split_title_and_url[0]; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
              </div>
          <?php
          } else { ?>
            <div class="twelve columns">
              <?php
                if ($filtered_by_column_index): ?>
                <div id="filter_by_classification">
                  <p><?php _e('Filter by', 'wp-odm_profile_pages');?></p>
                </div>
              <?php endif; ?>
            </div>
          <?php
          }
          ?>
          </div>
          <div class="fixed_datatable_tool_bar"></div>
        </div>
      </div>
    </div>

    <!-- Table -->
  <div class="row no-margin-buttom">
  <div class="sixteen columns table-column-container">
    <table id="profiles" class="data-table">
      <thead>
        <tr>
          <th><div class='th-value'><?php _e('Map ID', 'wp-odm_profile_pages'); ?></div></th>
          <?php if ($DATASET_ATTRIBUTE) :
            foreach ($DATASET_ATTRIBUTE as $key => $value): ?>
              <th>
                <div class='th-value'>
                  <?php _e($DATASET_ATTRIBUTE[$key], 'wp-odm_profile_pages');?>
                </div>
              </th>
            <?php endforeach;
          endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($profiles):
            foreach ($profiles as $profile):  ?>
            <tr>
              <td>
                <div class="td-value-id">
                  <?php echo trim($profile[$id]);?>
                </div>
              </td>
            <?php
            if($DATASET_ATTRIBUTE):
              foreach ($DATASET_ATTRIBUTE as $key => $value): ?>
                <?php
                $link_to_detail_column_array = explode(',', $link_to_detail_column);
                if(array_key_exists($key, $profile)):
                    if(in_array($key, $link_to_detail_column_array)) :
                        ?>
                          <td class="entry_title">
                            <div class="td-value">
                              <a target="_blank" href="?feature_id=<?php echo $profile[$id];?>"><?php echo $profile[$key];?></a>
                            </div>
                          </td>
                        <?php
                    elseif (in_array($key, array('data_class', 'adjustment_classification', 'adjustment'))): ?>
                          <td>
                            <div class="td-value"><?php
                              if (odm_language_manager()->get_current_language() == 'en'):
                                  echo ucwords(trim($profile[$key]));
                              else:
                                  echo trim($profile[$key]);
                              endif;?>
                              <?php odm_data_classification_definition($profile[$key]);?>
                            </div>
                          </td>
                        <?php
                    elseif ($key == 'reference'): ?>
                          <td>
                            <div class="td-value"><?php
                              $ref_docs_profile = explode(';', $profile['reference']);
                              $ref_docs = array_unique(array_merge($ref_docs_profile, $ref_docs_tracking));
                              odm_list_reference_documents($ref_docs, 1);?>
                            </div>
                          </td>
                        <?php
                    elseif ($key == 'issuedate'): ?>
                        <td><div class="td-value"><?php
                            $issuedate = str_replace('T00:00:00', '', $profile[$key]);
                            echo $profile[$key] == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($issuedate)); ?></div>
                        </td>
                      <?php
                    elseif (in_array($key, array('cdc_num', 'sub-decree', 'year'))):
                        if (odm_language_manager()->get_current_language() == 'km'):
                            $profile_value = convert_to_kh_number($profile[$key]);
                        else:
                            $profile_value = $profile[$key];
                        endif; ?>
                        <td>
                          <div class="td-value"><?php
                            echo $profile_value == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($profile_value));?>
                          </div>
                        </td>
                    <?php
                    else:
                      $profile_val = str_replace('T00:00:00', '', $profile[$key]);
                      if (odm_language_manager()->get_current_language() == 'km'):
                          if (is_numeric($profile_val)):
                              $profile_value = convert_to_kh_number(str_replace('.00', '', number_format($profile_val, 2, '.', ',')));
                          else:
                              $profile_value = str_replace('__', ' ', $profile_val);
                          endif;
                      else:
                          if (is_numeric($profile_val)):
                              $profile_value = str_replace('.00', '', number_format($profile_val, 2, '.', ','));
                          else:
                              $profile_value = str_replace('__', ', ', $profile_val);
                          endif;
                      endif;

                      $profile_value = str_replace(';', '<br/>', trim($profile_value));?>
                        <td>
                          <div class="td-value"><?php
                            echo $profile[$key] == '' ? __('Unknown', 'wp-odm_profile_pages') : str_replace(';', '<br/>', trim($profile_value));?>
                          </div>
                        </td>
                      <?php
                    endif;
                  else:?>
                    <td>
                      <div class="td-value">
                        <?php _e('Unknown', 'wp-odm_profile_pages'); ?>
                      </div>
                    </td>
                  <?php
                endif;?>
              <?php endforeach; ?>
            </tr>
            <?php
            endif;
          endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>

<div class="row">
  <div class="sixteen columns">
    <div class="disclaimer">
      <?php the_content(); ?>
    </div>
  </div>
</div>
</div>
<?php if($profiles){ ?>
  <script type="text/javascript">
  var oTable;
  var mapIdColNumber = 0;

  jQuery(document).ready(function($) {
    // Update the breadcrumbs list for meta page
    if ($('.profile-metadata h2').hasClass('h2_name')) {
        var addto_breadcrumbs = $('.profile-metadata h2.h2_name').text();
        var add_li = $('<li class="separator_by"> / </li><li class="item_map_id"><strong class="bread-current">'+addto_breadcrumbs+'</strong></li>');
        add_li.appendTo( $('#breadcrumbs'));
        $('.item-current a').text($('.item-current a strong').text());
    }
    $.fn.dataTableExt.oApi.fnFilterAll = function (oSettings, sInput, iColumn, bRegex, bSmart) {
      var settings = $.fn.dataTableSettings;
      for (var i = 0; i < settings.length; i++) {
        settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
      }
    };

    <?php if ($filter_map_id == '' && $metadata_dataset == '') { ?>
      	var get_od_selector_height = $('#od-selector').height();
        var get_filter_container_height = $('.filter-container').height();
        var get_position_profile_table =  $('.filter-container').offset().top;
        var table_fixed_position = get_od_selector_height +get_filter_container_height +40;

        $(window).scroll(function() {
      			if ($(document).scrollTop() >= get_position_profile_table) {
      				$('.dataTables_scrollHead').css('position','fixed').css('top', table_fixed_position+'px');
      				$('.dataTables_scrollHead').css('z-index',9999);
      				$('.dataTables_scrollHead').width($('.dataTables_scrollBody').width());
       				$('.filter-container').css('position','fixed');
       				$('.filter-container').css('width',$('.dataTables_scrollBody').width());
              $('.filter-container').addClass("fixed-filter-container");
      				$('.dataTables_scrollBody').css('margin-top', 10+'em');
              $('.fixed_datatable_tool_bar').css('display','inline-block');
      		   }
      		   else {
      				$('.dataTables_scrollHead').css('position','static');
       				$('.fixed-filter-container').css('position','static');
              $('.fixed_datatable_tool_bar').hide();
      				$('.dataTables_scrollBody').css('margin-top', 0);
      		   }
           });
         oTable = $("#profiles").dataTable({
           scrollX: true,
           responsive: false,
           "sDom": 'T<"H"lf>t<"F"ip>',
           processing: true,
           lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
           displayLength: -1
           , columnDefs: [
             {
               "targets": [ 0 ],
               "visible": false
             }
           ]
           <?php if (odm_language_manager()->get_current_language() == 'km') { ?>
           , "oLanguage": {
               "sLengthMenu": 'បង្ហាញចំនួន <select>'+
                   '<option value="10">10</option>'+
                   '<option value="25">20</option>'+
                   '<option value="50">50</option>'+
                   '<option value="-1">ទាំងអស់</option>'+
                 '</select> ក្នុងមួយទំព័រ',
               "sZeroRecords": "ព័ត៌មានពុំអាចរកបាន",
               "sInfo": "បង្ហាញពីទី _START_ ដល់ _END_ នៃទិន្នន័យចំនួន _TOTAL_",
               "sInfoEmpty": "បង្ហាញពីទី 0 ដល់ 0 នៃទិន្នន័យចំនួន 0",
               "sInfoFiltered": "(ទាញចេញពីទិន្នន័យសរុបចំនួន _MAX_)",
               "sSearch":"ស្វែងរក",
               "oPaginate": {
                 "sFirst": "ទំព័រដំបូង",
                 "sLast": "ចុងក្រោយ",
                 "sPrevious": "មុន",
                 "sNext": "បន្ទាប់"
               }
           }
          <?php
          } ?>
          <?php
            if (isset($group_data_by_column_index) && $group_data_by_column_index != '') { ?>
             , "aaSortingFixed": [[<?php echo $group_data_by_column_index; ?>, 'asc' ]] //sort data in Data Classifications first before grouping
          <?php
          } ?>
             , "drawCallback": function ( settings ) {  //Group colums
                     var api = this.api();
                     var rows = api.rows( {page:'current'} ).nodes();
                     var last=null;
                    <?php
                    if (isset($group_data_by_column_index) && $group_data_by_column_index != '') { ?>
                       api.column(<?php echo $group_data_by_column_index; ?>, {page:'current'} ).data().each( function ( group, i ) {
                           if ( last !== group ) {
                               $(rows).eq( i ).before(
                                   '<tr class="group" id="cambodia-bgcolor"><td colspan="<?php echo  count($DATASET_ATTRIBUTE)?>">'+group+'</td></tr>'
                               );
                               last = group;
                           }
                       } );
                    <?php
                    } ?>
                   align_width_td_and_th();
               }
        });

         <?php
         if ($filtered_by_column_index) {
                  $num_filtered_column_index = explode(',', $filtered_by_column_index);
                  $number_selector = 1;
                  foreach ($num_filtered_column_index as $column_index) {
                      $column_index = trim($column_index);
                      if ($number_selector <= 3) { ?>
                        create_filter_by_column_index(<?php echo $column_index;?>);
                  <?php
                      }
                        ++$number_selector;
                    }
         }
         ?>
         //Set width of table header and body equally
        function align_width_td_and_th(){
             var widths = [];
             var $tableBodyCell = $('.dataTables_scrollBody #profiles tbody tr:nth-child(2) td');
             var $headerCell = $('.dataTables_scrollHead thead tr th');
             var $max_width;
             var $text_length = [];
             $tableBodyCell.each(
               function(){
                 widths.push($(this).width());
             });
             $tableBodyCell.each(
                   function(i, val){
                     var $adjust_width;
                     var $max_text_length = 0;
                     var td_index = i +1;
                     var $max_length_text_in_col = $('#profiles tbody td:nth-child('+td_index+')');
                     $max_length_text_in_col.each(function (){
                        $text_value = $(this).children(".td-value").clone();
                        $text_value.find('.tooltip').remove();
                        $text_length = $text_value.text().trim().length;
                        $max_text_length = Math.max($max_text_length, $text_length);
                     });

                     if($max_text_length >= 250){
                       $adjust_width = 400;
                     }else if($max_text_length >= 150){
                       $adjust_width = 365;
                     }else if($max_text_length >= 100){
                       $adjust_width = 300;
                     }else if($max_text_length >= 50){
                       $adjust_width = 275;
                     }else if($max_text_length >= 20){
                       $adjust_width = 230;
                     }else {
                       if($(this).width() >= 350){
                         $adjust_width = 365;
                       }else if( $headerCell.eq(i).width() >= 350){
                          $adjust_width = 365;
                       }
                     }

                     $tableBodyCell.eq(i).children('.td-value').text();
                     if ( $(this).width() >= $headerCell.eq(i).width() ){
                          $max_width = $(this).width();
                          if($adjust_width){
                            $max_width = $adjust_width;
                          }
                          $headerCell.eq(i).children('.th-value').css('width', $max_width);
                          if(!$(this).hasClass('group')){
                            $('#profiles tbody td:nth-child('+td_index+')').children('.td-value').css('width', $max_width);
                          }
                     }else if ( $(this).width() < $headerCell.eq(i).width() ){
                          $max_width = $headerCell.eq(i).width();
                          if($adjust_width){
                            $max_width = $adjust_width;
                          }
                          $headerCell.eq(i).children('.th-value').css('width', $max_width);
                          $('#profiles tbody td:nth-child('+td_index+')').children('.td-value').css('width', $max_width);
                     }
                 });
         }

        function create_filter_by_column_index(col_index){
          var columnIndex = col_index;
          var column_filter_oTable = oTable.api().columns( columnIndex );
          var column_headercolumnIndex = columnIndex -1;
          var column_header = $("#profiles").find("th:eq( "+column_headercolumnIndex+" )" ).text();
          <?php
          if (odm_language_manager()->get_current_language() == 'km') { ?>
             var div_filter = $('<div class="filter_by filter_by_column_index_'+columnIndex+'"></div>');
             div_filter.appendTo( $('#filter_by_classification'));
             var select = $('<select><option value="">'+column_header+'<?php _e('all', 'wp-odm_profile_pages');
             ?></option></select>');
          <?php
          } else { ?>
             var div_filter = $('<div class="filter_by filter_by_column_index_'+columnIndex+'"></div>');
             div_filter.appendTo( $('#filter_by_classification'));
             var select = $('<select><option value=""><?php _e('All ', 'wp-odm_profile_pages'); ?>'+column_header+'</option></select>');
          <?php
          } ?>
          select.appendTo( $('.filter_by_column_index_'+columnIndex) )
             .on( 'change', function () {
                 var val = $.fn.dataTable.util.escapeRegex(
                     $(this).val()
                 );
                 column_filter_oTable
                     .search( val ? '^'+val : '', true, false )
                     .draw();
                    var filtered = oTable._('tr', {"filter":"applied"});
                    <?php if (isset($map_visualization_url) &&  $map_visualization_url != '') { ?>
                            filterEntriesMap(_.pluck(filtered,mapIdColNumber));
                    <?php } ?>
          });
           var i = 1;
           column_filter_oTable.data().eq( 0 ).unique().sort().each( function ( d, j ) {
               d = d.replace(/[<]br[^>]*[>]/gi,"");
               var value = d.split('<');
               var first_value = value[1].split('>');
               var only_value = first_value[1].split('<');
               val = first_value[1].trim();
              select.append( '<option value="'+val+'">'+val+'</option>' )
           } );
         }

        var $fg_show_entry_bar = $(".dataTables_length").clone(true);

        $(".fixed_datatable_tool_bar").append($fg_show_entry_bar);
        $('.fixed_datatable_tool_bar .dataTables_length select').val($('.table-column-container .dataTables_length select').val());
        $('.fixed_datatable_tool_bar .dataTables_length select').on( 'change', function () {
           $('.table-column-container .dataTables_length select').val($(this).val());
        });
        $('.table-column-container .dataTables_length select').on( 'change', function () {
           $('.fixed_datatable_tool_bar .dataTables_length select').val($(this).val());
        });

        $('#filter_by_classification').find('select').each(function(index){

          $(this).change(function() {
            refreshMap();
          });
        })


        $('.dataTables_scrollHead').scroll(function(e){
               $('.dataTables_scrollBody').scrollLeft(e.target.scrollLeft);
        });

     $("#search_all").keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
           oTable.fnFilterAll(this.value);
           refreshMap();
        }
        event.stopPropagation();
     });

     var refreshMap = function(){
       var filtered = oTable._('tr', {"filter":"applied"});
       <?php
       $map_layers = get_selected_layers_of_map_by_mapID(get_the_ID());
       if (count($map_layers) > 1) {
       ?>
          filterEntriesMap(_.pluck(filtered,mapIdColNumber));
       <?php
       }
       ?>
     }

     var filterEntriesMap = function(mapIds){

       var mapIdsString = "('" + mapIds.join('\',\'') + "')";
        $( "#searchFeature_by_mapID").val(mapIdsString);
        $( "#searchFeature_by_mapID").trigger("keyup");
     }
    <?php
    }
    ?>
  }); //jQuery
  </script>
<?php }  ?>
