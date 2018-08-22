<?php require_once (WP_PLUGIN_DIR.'/wp-odm_profile_pages/utils/profile-spreadsheet-post-meta.php'); ?>
<div class="container">
  <?php
  $full_width_content = odm_language_manager()->get_current_language() !== 'en' ? get_post_meta(get_the_ID(), '_full_width_middle_content_localization', true) : get_post_meta(get_the_ID(), '_full_width_middle_content', true);
  $full_width_position = get_post_meta(get_the_ID(), '_full_width_content_position', true);

  if($full_width_content && $full_width_position): ?>
	  <div class="row">
	    <div class="sixteen columns">
	      <?php echo "<div class='full-width-content above-map'>".$full_width_content."</div>"; ?>
	    </div>
	  </div>
  <?php endif; ?>

  <div class="row">
    <div class="sixteen columns">
      <?php
      if(function_exists('display_embedded_map')):
        //AAAAAA display_embedded_map(get_the_ID());
      endif;
      ?>
    </div>
  </div>
  <?php
    if($full_width_content && !$full_width_position):
      ?>
    	<section class="container">
    		<div class="row">
    			<div class="sixteen columns">
            <?php echo "<div class='full-width-content below-map'>".$full_width_content."</div>"; ?>
    			</div>
    		</div>
    	</section>
  <?php
		endif; ?>

<?php
if($profiles):
    if($total_number_by_attribute_name): ?>
    	<div class="row">
        <div class="sixteen columns">
          <?php odm_count_total_of_value($total_number_by_attribute_name, $profiles, $DATASET_ATTRIBUTE); ?>
        </div>
      </div>
    <?php
    endif;

		if (!odm_screen_manager()->is_desktop()): ?>

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
        <div class ="eight columns">
          <div class="close-mobile-dialog align-right">
            <i class="fa fa-times-circle"></i>
          </div>
        </div>
				<div class ="eight columns align-left">
					<?php _e("Filters","wp-odm_profile_pages"); ?>
				</div>
	      <div class ="sixteen columns">
	        <div class="panel panel_filter">
	          <?php
	          if (isset($related_profile_pages) && $related_profile_pages != ''):
	            $temp_related_profile_pages = explode("\r\n", $related_profile_pages);  ?>
	            <div class="eight columns">
	              <?php
	                if ($filtered_by_column_index): ?>
	                <div id="filter_by_classification">
	                  <p><?php _e('Filter by', 'wp-odm_profile_pages');?></p>
	                </div>
	              <?php endif; ?>
	            </div>
	            <div class="eight columns">
	              <p><?php _e('Related profiles', 'wp-odm_profile_pages');?></p>
	              <ul class="related_profiles">
	              <?php foreach ($temp_related_profile_pages as $profile_pages_url) :
	                  $split_title_and_url = explode('|', $profile_pages_url);?>
	                  <li>
	                    <a href="<?php echo $split_title_and_url[1]; ?>" target="_blank"><?php echo $split_title_and_url[0]; ?></a>
	                  </li>
	              <?php endforeach; ?>
	              </ul>
	            </div>
	        <?php
					else: ?>
	          <div class="sixteen columns">
	            <?php
	              if ($filtered_by_column_index): ?>
	              <div id="filter_by_classification">
	                <p><?php _e('Filter by', 'wp-odm_profile_pages');?></p>
	              </div>
	            <?php endif; ?>
	          </div>
	        <?php
					endif;
	        ?>
	        </div>
	      </div>
	    </div>

	     <?php
		else: ?>
    <div class="row hideOnMobileAndTablet">
      <div class ="sixteen columns">
        <div class="filter-container">
          <div class="panel_related_profile">
            <?php if (odm_screen_manager()->is_desktop()): ?>
              <div class="related_profiles_toggle_icon">
                <span><?php _e("Filters","wp-odm_profile_pages"); ?></span>
                <i class="fa fa-times-circle"></i>
              </div>
            <?php endif ?>
            <div class="panel panel_filter">
	            <div class="four columns">
	              <p><?php _e('Textual search', 'wp-odm_profile_pages');?></p>
	              <input type="text" id="search_all" placeholder="<?php _e('Search data in profile page', 'wp-odm_profile_pages'); ?>">
	            </div>
	            <?php
	            if (isset($related_profile_pages) && $related_profile_pages != ''):
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
  	                <ul class="related_profiles">
  	                <?php foreach ($temp_related_profile_pages as $profile_pages_url) :
  	                    $split_title_and_url = explode('|', $profile_pages_url);?>
  	                    <li>
  	                      <a href="<?php echo $split_title_and_url[1]; ?>" target="_blank"><?php echo $split_title_and_url[0]; ?></a>
  	                    </li>
  	                <?php endforeach; ?>
  	                </ul>
  	              </div>

  	          <?php
  						else: ?>
  	            <div class="twelve columns">
  	              <?php
  	                if ($filtered_by_column_index): ?>
  	                <div id="filter_by_classification">
  	                  <p><?php _e('Filter by', 'wp-odm_profile_pages');?></p>
  	                </div>
  	              <?php endif; ?>
  	            </div>
  	          <?php
  						endif;
  	          ?>
	          </div>
	         <div class="fixed_datatable_tool_bar"></div>
          </div>
        </div>
      </div>
    </div>

	<?php
	endif; ?>

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
			    	$id = '_id';
						$archive_refdoc = [];
						$archive_refdoc_list = [];
            foreach ($profiles as $profile):  ?>
	            <tr>
	              <td class="td-value-id">
	                  <?php echo trim($profile[$id]);?>
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
	                              <?php if($link_to_detail_page):?>
	                                <a target="_blank" href="<?php echo $profile[$link_to_detail_page];?>"><?php echo $profile[$key];?></a>
	                              <?php else:?>
	                                <a target="_blank" href="?feature_id=<?php echo $profile[$id];?>"><?php echo $profile[$key];?></a>
	                              <?php endif; ?>
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
																echo '<ul style="min-width:300px">';
																foreach ($ref_docs as $key => $ref_doc):
																	$ref_doc_arr_temp = array($ref_doc);
																	if(in_array(trim($ref_doc), $archive_refdoc)){ //archieve existing finding ref in arr
																		echo $archive_refdoc_list[$ref_doc];
																	}else{
																		$archive_refdoc[] = $ref_doc;
																		$archive_refdoc_list[$ref_doc] = odm_list_reference_documents($ref_doc_arr_temp, 1, 0);
		                              	echo odm_list_reference_documents($ref_doc_arr_temp, 1, 0);
																	}
																endforeach;
																echo '</ul>';
																?>
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
<?php
endif; ?>

<div class="row">
  <div class="sixteen columns">
    <div class="disclaimer">
      <?php echo get_the_content(); ?>
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

    <?php
			if ($filter_map_id == '' && $metadata_dataset == '') { ?>
      	var get_od_selector_height = $('#od-selector').height();
        var get_filter_container_height = 0;
        $('.filter-container').each(function(index){
          if ($(this).css("display") !== 'none'){
            get_filter_container_height += $(this).height();
          }
        });
        var get_position_profile_table =  $('.filter-container').offset().top-15;
        var table_fixed_position = get_od_selector_height + get_filter_container_height +37;
        var table_body_fixed_position = table_fixed_position+5;
        var get_first_set_dataTable_head_top = table_fixed_position;
        var get_first_set_dataTables_scrollBody_top = table_body_fixed_position+10;
        var updated_dataTables_scrollHeader_top = 0;
        var updated_dataTables_scrollBody_top = 0;
        $(window).scroll(function() {
      			if ($(document).scrollTop() >= get_position_profile_table) {
              var dataTables_scrollHead_top = updated_dataTables_scrollHeader_top? updated_dataTables_scrollHeader_top: table_fixed_position;
              var dataTables_scrollBody_top = updated_dataTables_scrollBody_top? updated_dataTables_scrollBody_top:table_body_fixed_position;
      				$('.dataTables_scrollHead').css('position','fixed').css('top', dataTables_scrollHead_top+'px');
      				$('.dataTables_scrollHead').css('z-index',99);
      				$('.dataTables_scrollHead').width($('.dataTables_scrollBody').width());
       				$('.filter-container').css('position','fixed');
       				$('.filter-container').css('width',$('.dataTables_scrollBody').width());
              $('.filter-container').addClass("fixed-filter-container");
      				$('.dataTables_scrollBody').css('margin-top', dataTables_scrollBody_top+'px');
              $('.fixed_datatable_tool_bar').css('display','inline-block');
      		   }else {
      				$('.dataTables_scrollHead').css('position','static');
              $('.filter-container').removeClass("fixed-filter-container");
              $('.filter-container').css('position','static');
              $('.fixed_datatable_tool_bar').hide();
      				$('.dataTables_scrollBody').css('margin-top', 0);
      		   }
         });

          //Hide filter on fixed table header
        $(".related_profiles_toggle_icon").click(function(){
            $(".fixed-filter-container .panel").toggleClass('hide');
            $(".fixed-filter-container .related_profiles_toggle_icon").find('i').toggleClass('fa-filter fa-times-circle');
            if( $(".fixed-filter-container .related_profiles_toggle_icon i").hasClass('fa-filter')){
              updated_dataTables_scrollHeader_top = get_first_set_dataTable_head_top - $(' .panel_filter').height() -20;
              updated_dataTables_scrollBody_top = get_first_set_dataTables_scrollBody_top - $(' .panel_filter').height();

                     console.log("updated_dataTables_scrollBody_top")
                     console.log(updated_dataTables_scrollBody_top);
              $('.dataTables_scrollHead').css('top', updated_dataTables_scrollHeader_top+'px');
              $('.dataTables_scrollBody').css('margin-top', updated_dataTables_scrollBody_top+'px');
            }else{
              $('.dataTables_scrollHead').css('top', get_first_set_dataTable_head_top+'px');
              $('.dataTables_scrollBody').css('margin-top', table_body_fixed_position+'px');
            }
        });

         oTable = $("#profiles").dataTable({
           scrollX: true,
					 <?php
					  	if (!odm_screen_manager()->is_desktop()): ?>
           responsive: true,
					 <?php
				 			endif; ?>
           sDom: 'T<"H"lf>t<"F"ip>',
           processing: true,
           lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
					 iDisplayLength: 10,
           displayLength: -1
           , columnDefs: [
             {
               "targets": [ 0 ],
               "visible": false
             }
           ]
           <?php
					 if (odm_language_manager()->get_current_language() == 'km'): ?>
           ,"oLanguage": {
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
					endif; ?>
          <?php
            if (isset($group_data_by_column_index) && !empty($group_data_by_column_index)): ?>
             , "aaSortingFixed": [[<?php echo $group_data_by_column_index; ?>, 'asc' ]] //sort data in Data Classifications first before grouping
          <?php
						endif; ?>
           , "drawCallback": function ( settings ) {  //Group colums
                   var api = this.api();
                   var rows = api.rows( {page:'current'} ).nodes();
                   var last=null;
                  <?php
                  if (isset($group_data_by_column_index) && !empty($group_data_by_column_index)) { ?>
                     api.column(<?php echo $group_data_by_column_index; ?>, {page:'current'} ).data().each( function ( group, i ) {
                         if ( last !== group ) {
                             $(rows).eq( i ).before(
                                 '<tr class="group" id="<?php echo odm_country_manager()->get_current_country()?>-bgcolor"><td colspan="<?php echo  count($DATASET_ATTRIBUTE)?>">'+group+'</td></tr>'
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
         if ($filtered_by_column_index) :
          $num_filtered_column_index = explode(',', $filtered_by_column_index);
          $number_selector = 1;
          foreach ($num_filtered_column_index as $column_index):
              $column_index = trim($column_index);
              if ($number_selector <= 3): ?>
                create_filter_by_column_index(<?php echo $column_index;?>);
	          <?php
							endif;
                ++$number_selector;
          endforeach;
         endif;
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
             var select = $('<select class="filter_box"><option value="">'+column_header+'<?php _e('all', 'wp-odm_profile_pages');
             ?></option></select>');
          <?php
          } else { ?>
             var div_filter = $('<div class="filter_by filter_by_column_index_'+columnIndex+'"></div>');
             div_filter.appendTo( $('#filter_by_classification'));
             var select = $('<select class="filter_box"><option value=""><?php _e('All ', 'wp-odm_profile_pages'); ?>'+column_header+'</option></select>');
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

        var typingTimer;
        $("#search_all").keyup(function () {
          clearTimeout(typingTimer);
          var keyword = this.value;
          if (keyword) {
            $("#search_all").addClass("loading_icon");
            typingTimer = setTimeout(function(){
                oTable.fnFilterAll(keyword);
                refreshMap();
            }, 2000);
          }
        });

       var refreshMap = function(){
         var filtered = oTable._('tr', {"filter":"applied"});
         <?php
         $map_layers = get_selected_layers_of_map_by_mapID(get_the_ID());
         if (count($map_layers) > 1) {
         ?>
            filterEntriesMap(_.pluck(filtered, s));
         <?php
         }
         ?>
       }

       var filterEntriesMap = function(mapIds){
         var mapIdsString = "('" + mapIds.join('\',\'') + "')";
          $( "#searchFeature_by_mapID").val(mapIdsString);
          $( "#searchFeature_by_mapID").trigger("keyup");
          $("#search_all").removeClass("loading_icon");
       }
    <?php
    }
    ?>
  }); //jQuery
  </script>
<?php }  ?>
