<?php

if (!class_exists('Odm_Profile_Pages_Post_Type')) {
    class Odm_Profile_Pages_Post_Type
    {
        public function __construct()
        {
          add_action('init', array($this, 'register_post_type'));
          add_action('add_meta_boxes', array($this, 'add_meta_box'));
          add_action('save_post', array($this, 'save_post_data'));
          add_filter( 'template_include', array($this, 'get_custom_page_template'));
        }
        public function get_custom_page_template($template){
              $template_slug = basename($template);
            if ( is_archive() && $template_slug == "archive-profiles.php") {
                return $template;
            }else if(is_single() && $template_slug =="single.php") {
                $single_template = $this->get_profile_pages_template($template);
                return $single_template;
            }else if (!is_archive()) {
                return $template;
            }else {
              if (!is_post_type_archive("profiles")):
                return $template;
              endif;
            }
        }

        public function get_profile_pages_template($single_template)
        {
          global $post;
          if ($post->post_type == 'profiles') {
                $single_template = plugin_dir_path(__FILE__).'templates/single-profiles.php';
          }
            return $single_template;
        }

        public function register_post_type()
        {
            $labels = array(
              'name' => __('Profiles', 'post type general name', 'odm_profile'),
              'singular_name' => __('Profile', 'post type singular name', 'odm_profile'),
              'menu_name' => __('Profiles', 'admin menu for profile pages', 'odm_profile'),
              'name_admin_bar' => __('Profiles', 'add new on admin bar', 'odm_profile'),
              'add_new' => __('Add new', 'profile', 'odm_profile'),
              'add_new_item' => __('Add new profile', 'odm_profile'),
              'new_item' => __('New profile', 'odm_profile'),
              'edit_item' => __('Edit profile', 'odm_profile'),
              'view_item' => __('View profile', 'odm_profile'),
              'all_items' => __('All profile', 'odm_profile'),
              'search_items' => __('Search profiles', 'odm_profile'),
              'parent_item_colon' => __('Parent profiles:', 'odm_profile'),
              'not_found' => __('No profile found.', 'odm_profile'),
              'not_found_in_trash' => __('No profile found in trash.', 'odm_profile'),
            );

            $args = array(
              'labels'             => $labels,
              'public'             => true,
              'publicly_queryable' => true,
              'show_ui'            => true,
              'show_in_menu'       => true,
  			      'menu_icon'          => '',
              'query_var'          => true,
              'rewrite'            => array( 'slug' => 'profiles' ),
              'capability_type'    => 'page',
              'has_archive'        => true,
              'hierarchical'       => true,
              'menu_position'      => 5,
              'taxonomies'         => array('category', 'language'),//, 'post_tag'
              'supports' => array('title', 'editor', 'page-attributes', 'revisions', 'author', 'thumbnail', 'custom-fields')
            );

            register_post_type('profiles', $args);
        }

        public function add_meta_box()
        {
          // Profile settings
          add_meta_box(
           'profiles_template_layout',
           __('Template layout', 'odm_profile'),
           array($this, 'template_layout_settings_box'),
           'profiles',
           'advanced',
           'high'
          );
          add_meta_box(
           'profiles_resource',
           __('CKAN​ Dataset Resource', 'odm_profile'),
           array($this, 'resource_settings_box'),
           'profiles',
           'advanced',
           'high'
          );
            add_meta_box(
           'profiles_setting',
           __('Setting of Profiles Page', 'odm_profile'),
           array($this, 'profiles_page_settings_box'),
           'profiles',
           'advanced',
           'high'
          );

        }//metabox


      public function template_layout_settings_box($post = false)
      {
          $template = get_post_meta($post->ID, '_attributes_template_layout', true); ?>
          <div id="template_layout_settings_box">
           <h4><?php _e('Choose template layout', 'odm_profile');?></h4>
           <select id="_attributes_template_layout" name="_attributes_template_layout">
              <option value="default" <?php if ($template == "default"): echo "selected"; endif; ?>>Default</option>
              <option value="with-widget" <?php if ($template == "with-widget"): echo "selected"; endif; ?>>With widgets</option>
              <option value="sub-profile-page" <?php if ($template == "sub-profile-page"): echo "selected"; endif; ?>>Sub profile page</option>
            </select>
          </div>
      <?php
      }

      public function resource_settings_box($post = false)
      {
          $full_width_middle_content = get_post_meta($post->ID, '_full_width_middle_content', true);
          $full_width_middle_content_localization = get_post_meta($post->ID, '_full_width_middle_content_localization', true);
          $map_visualization_url = get_post_meta($post->ID, '_map_visualization_url', true);
          $map_visualization_url_localization = get_post_meta($post->ID, '_map_visualization_url_localization', true);
          $csv_resource_url = get_post_meta($post->ID, '_csv_resource_url', true);
          $csv_resource_url_localization = get_post_meta($post->ID, '_csv_resource_url_localization', true);
          $tracking_csv_resource_url = get_post_meta($post->ID, '_tracking_csv_resource_url', true);
          $tracking_csv_resource_url_localization = get_post_meta($post->ID, '_tracking_csv_resource_url_localization', true);

          $filtered_by_column_index = get_post_meta($post->ID, '_filtered_by_column_index', true);
          $filtered_by_column_index_localization = get_post_meta($post->ID, '_filtered_by_column_index_localization', true);
          ?>
  		<div id="multiple-site">
  			<input type="radio" id="csv_en" class="en" name="language_site" value="en" checked />
  			<label for="csv_en"><?php _e('ENGLISH', 'jeo');
          ?></label> &nbsp;
  			<input type="radio" id="csv_localization" class="localization" name="language_site" value="localization" />
  			<label for="csv_localization"><?php _e(odm_language_manager()->get_the_language_by_site(), 'odm_profile');
          ?></label>
  		</div>
  		<div id="resource_settings_box">
  		  <div class="resource_settings resource-en">
  				<table class="form-table resource_settings_box">
  					<tbody>
              <tr>
              <th><label for="_full_width_middle_content"><?php _e('Full width content (English)', 'odm_profile');
              ?></label></th>
              <td>
              <textarea name="_full_width_middle_content" style="width:100%;height: 50px;" placeholder=""><?php echo $full_width_middle_content; ?></textarea>
              <p class="description"><?php _e('Any content can add to under the Editor content and sidebar and  full width of website even the iframe.', 'odm_profile');
              ?></p>
              </td>
              </tr>
  						<tr>
   					  <th><label for="_map_visualization_url"><?php _e('CartoDB JSON URL (English)', 'odm_profile');
          ?></label></th>
   					  <td>
   					 	<input id="_map_visualization_url" type="text" placeholder="https://" size="40" name="_map_visualization_url" value="<?php echo $map_visualization_url;
          ?>" />
   					 	<p class="description"><?php _e('CartoDB visualization URL. E.g.: http://user.cartodb.com/api/v2/viz/621d23a0-5eaa-11e4-ab03-0e853d047bba/viz.json', 'odm_profile');
          ?></p>
   					  </td>
   					 </tr>
  					 <tr>
  		 				<th><label for="_csv_resource_url"><?php _e('CSV Resource URL (English)', 'odm_profile');
          ?></label></th>
  						<td>
  						 <input id="_csv_resource_url" type="text" placeholder="https://" size="40" name="_csv_resource_url" value="<?php echo $csv_resource_url;
          ?>" />
  						 <p class="description"><?php _e('CSV Resource of dataset on CKAN. Eg. https://data.opendevelopmentmekong.net/dataset/economic-land-concessions/resource/3b817bce-9823-493b-8429-e5233ba3bd87?type=dataset', 'odm_profile');
          ?></p>
  						</td>
  					 </tr>
  					 <tr>
  		 				<th><label for="_tracking_csv_resource_url"><?php _e('CSV Tracking URL (English)', 'odm_profile');
          ?></label></th>
  						<td>
  						 <input id="_tracking_csv_resource_url" type="text" placeholder="https://" size="40" name="_tracking_csv_resource_url" value="<?php echo $tracking_csv_resource_url;
          ?>" />
  						 <p class="description"><?php _e('CSV Resource of tracking dataset on CKAN. Eg. https://data.opendevelopmentmekong.net/dataset/economic-land-concessions/resource/8cc0c651-8131-404e-bbce-7fe6af728f89?type=dataset', 'odm_profile');
          ?></p>
  						</td>
  					 </tr>
  					</tbody>
  		 		</table>
  				<?php $this->attributes_settings_box('English', $post);
          ?>
  			</div>
  <?php if (odm_language_manager()->get_the_language_by_site()) {
    ?>
  		 <div class="resource_settings resource-localization">
  			 	<table class="form-table form-table-localization resource_settings_box">
  		 			<tbody>
              <tr>
              <th><label for="_full_width_middle_content_localization"><?php _e('Full width content (('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
              ?></label></th>
              <td>
              <textarea name="_full_width_middle_content_localization" style="width:100%;height: 50px;" placeholder=""><?php echo $full_width_middle_content_localization; ?></textarea>
              <p class="description"><?php _e('Any content can add to under the Editor content and sidebar and  full width of website even the iframe.', 'odm_profile');
              ?></p>
              </td>
              </tr>
  						<tr>
  						 <th><label for="_map_visualization_url_localization"><?php _e('CartoDB JSON URL ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  						 <td>
  							<input id="_map_visualization_url_localization" type="text" placeholder="https://" size="40" name="_map_visualization_url_localization" value="<?php echo $map_visualization_url_localization;
    ?>" />
  							<p class="description"><?php _e('CartoDB visualization URL. E.g.: http://user.cartodb.com/api/v2/viz/621d23a0-5eaa-11e4-ab03-0e853d047bba/viz.json', 'odm_profile');
    ?></p>
  						 </td>
  						</tr>
  		 			 <tr>
  		 				<th><label for="_csv_resource_url_localization"><?php _e('CSV Resource URL ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  		 				<td>
  		 				 <input id="_csv_resource_url_localization" type="text" placeholder="https://" size="40" name="_csv_resource_url_localization" value="<?php echo $csv_resource_url_localization;
    ?>" />
  		 				  <p class="description"><?php _e('CSV Resource of dataset on CKAN. Eg. https://data.opendevelopmentmekong.net/dataset/economic-land-concessions/resource/3b817bce-9823-493b-8429-e5233ba3bd87?type=dataset', 'odm_profile');
    ?></p>
  		 				</td>
  		 			 </tr>
  					 <tr>
  		 				<th><label for="_tracking_csv_resource_url_localization"><?php _e('CSV Tracking URL ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  		 				<td>
  		 				 <input id="_tracking_csv_resource_url_localization" type="text" placeholder="https://" size="40" name="_tracking_csv_resource_url_localization" value="<?php echo $tracking_csv_resource_url_localization;
    ?>" />
  		 				  <p class="description"><?php _e('CSV Resource of tracking dataset on CKAN. Eg. https://data.opendevelopmentmekong.net/dataset/economic-land-concessions/resource/8cc0c651-8131-404e-bbce-7fe6af728f89?type=dataset', 'odm_profile');
    ?></p>
  		 				</td>
  		 			 </tr>
  					</tbody>
  		 		</table>
  				<?php $this->attributes_settings_box(odm_language_manager()->get_the_language_by_site(), $post);
    ?>
  		 </div>
   <?php

}
          ?>
  		</div>
  		<script type="text/javascript">
  		 jQuery(document).ready(function($) {
  			var $container = $('#multiple-site');
  			var $languageSelection = $('input[type="radio"]');
  			var $forms = $('.resource_settings');
  			var showForms = function() {
  				  $forms.hide();
  					var selected = $('input[type="radio"][name=language_site]').filter(':checked').val();
  					$('.resource-' + selected).show();
  			}
  			$languageSelection.on('change', function() {
  					$('.' + this.className).prop('checked', this.checked);
  			 	showForms();
  			});

  			showForms();
       });
      </script>
  		<?php

      }
        public function attributes_settings_box($lang = 'English', $post = false)
        {
            $attributes = get_post_meta($post->ID, '_attributes_csv_resource', true);
            $attributes_localization = get_post_meta($post->ID, '_attributes_csv_resource_localization', true);
            $attributes_tracking = get_post_meta($post->ID, '_attributes_csv_resource_tracking', true);
            $attributes_tracking_localization = get_post_meta($post->ID, '_attributes_csv_resource_tracking_localization', true);
            ?>
  			 <?php if ($lang != 'English') {
    ?>
  							 <h4><?php _e('The attributes of Resource Dataset that would like to display, separated by line breaks ('.$lang.')', 'odm_profile');
    ?></h4>
  							 <textarea name="_attributes_csv_resource_localization" style="width:100%;height: 200px;"placeholder="developer  =>  Developer"><?php echo $attributes_localization;
    ?></textarea>

  							 <h4><?php _e('The attributes of Tracking Resource that would like to display, separated by line breaks ('.$lang.')', 'odm_profile');
    ?></h4>
  							 <textarea name="_attributes_csv_resource_tracking_localization" style="width:100%;height: 100px;" placeholder="concession_or_developer => Amendment object"> <?php echo $attributes_tracking_localization;
    ?></textarea>
  			 <?php

} else {
    ?>
  							 <h4><?php _e('The attributes of Resource Dataset that would like to display, separated by line breaks ('.$lang.')', 'odm_profile');
    ?></h4>
  							 <textarea name="_attributes_csv_resource" style="width:100%;height: 200px;" placeholder="developer  =>  Developer"><?php echo $attributes;
    ?></textarea>

  							 <h4><?php _e('The attributes of Tracking Resource that would like to display, separated by line breaks ('.$lang.')', 'odm_profile');
    ?></h4>
  							 <textarea name="_attributes_csv_resource_tracking" style="width:100%;height: 100px;" placeholder="concession_or_developer => Amendment object"><?php echo $attributes_tracking;
    ?></textarea>
  							 <?php

}
        }

        public function profiles_page_settings_box($post = false)
        {
            $filtered_by_column_index = get_post_meta($post->ID, '_filtered_by_column_index', true);
            $filtered_by_column_index_localization = get_post_meta($post->ID, '_filtered_by_column_index_localization', true);

            $group_data_by_column_index = get_post_meta($post->ID, '_group_data_by_column_index', true);
            $group_data_by_column_index_localization = get_post_meta($post->ID, '_group_data_by_column_index_localization', true);
            $total_number_by_attribute_name = get_post_meta($post->ID, '_total_number_by_attribute_name', true);
            $total_number_by_attribute_name_localization = get_post_meta($post->ID, '_total_number_by_attribute_name_localization', true);

            $related_profile_pages = get_post_meta($post->ID, '_related_profile_pages', true);
            $related_profile_pages_localization = get_post_meta($post->ID, '_related_profile_pages_localization', true);
            ?>
  	  <div id="multiple-site">
  	    <input type="radio" id="en" class="en" name="p_language_site" value="en" checked />
  	    <label for="en"><?php _e('ENGLISH', 'jeo');
            ?></label> &nbsp;
  	    <input type="radio" id="localization" class="localization" name="p_language_site" value="localization" />
  	    <label for="localization"><?php _e(odm_language_manager()->get_the_language_by_site(), 'odm_profile');
            ?></label>
  	  </div>
  	  <div id="profiles_page_settings_box">
  	    <div class="resource_settings resource-en">
  	      <table class="form-table  profiles_page_settings_box">
  	        <tbody>
  	         <tr>
  	          <th><label for="_total_number_by_attribute_name"><?php _e('Show Total Numbers of Columns, separated by line breaks (English)', 'odm_profile');
            ?></label></th>
  	          <td>
  						<textarea name="_total_number_by_attribute_name" style="width:100%;height: 80px;"placeholder="column_1"><?php echo $total_number_by_attribute_name;
            ?></textarea>
  	        	<p class="description"><?php _e('List the attribute names to show their total number on page (separated by line breaks). Eg. For ELC: <br/>map_id<br/>developer<br/>data_class["Government data complete", "Government data partial"]', 'odm_profile');
            ?></p>
  	          </td>
  	         </tr>
  	         <tr>
  	          <th><label for="_filtered_by_column_index"><?php _e('Create Select Filter by Column Index (English)', 'odm_profile');
            ?></label></th>
  	          <td>
  	           <input id="_filtered_by_column_index" type="text" placeholder="2, 5" size="40" name="_filtered_by_column_index" value="<?php echo $filtered_by_column_index;
            ?>" />
  	           <p class="description"><?php _e('Filter selectors will create automatically by adding the column index and separated by comma. Maximum Filter selectors can create is three. Eg. Create filter selectors of Data Adjustment and Intended crop or project of ELC which have index 2 and 5', 'odm_profile');
            ?></p>
  	          </td>
  	         </tr>
  	         <tr>
  	          <th><label for="_group_data_by_column_index"><?php _e('Group Data in Column (English)', 'odm_profile');
            ?></label></th>
  	          <td>
  	            <input id="_group_data_by_column_index" type="text" placeholder="5" size="40" name="_group_data_by_column_index" value="<?php echo $group_data_by_column_index;
            ?>" />
  	              <p class="description"><?php _e('Eg. To group data classification of ELC, based on the attributes sample provided, the index of data classification is: 5', 'odm_profile');
            ?></p>
  	          </td>
  	         </tr>
  					 <tr>
  					  <th><label for="_related_profile_pages"><?php _e('Related Profile Pages (English)', 'odm_profile');
            ?></label></th>
  					  <td>
  								<textarea name="_related_profile_pages" style="width:100%;height: 50px;"placeholder="Label of Link|URL"><?php echo $related_profile_pages;
            ?></textarea>
  					      <p class="description"><?php _e('Please add the links of profile pages that related (separated by new breaking line). Format: Title of Link|URL. <br/>eg.
  Economic Land Concessions|https://cambodia.opendevelopmentmekong.net/profiles/economic-land-concessions/', 'odm_profile');
            ?></p>
  					  </td>
  					 </tr>
  	        </tbody>
  	      </table>
  	    </div>
  	<?php if (odm_language_manager()->get_the_language_by_site()) {
    ?>
  	   <div class="resource_settings resource-localization">
  	      <table class="form-table form-table-localization profiles_page_settings_box">
  	        <tbody>
  	         <tr>
  	          <th><label for="_total_number_by_attribute_name_localization"><?php _e('Show Total Numbers of Columns, separated by line breaks ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  	          <td>
  						<textarea name="_total_number_by_attribute_name_localization" style="width:100%;height: 80px;"placeholder="column_1"><?php echo $total_number_by_attribute_name_localization;
    ?></textarea>
  	          <p class="description"><?php _e('List the attribut4 names to show their total number on page (separated by line breaks). Eg. For ELC: map_id<br/>developer<br/>data_class["Government data complete", "Government data partial"]', 'odm_profile');
    ?></p>
  	          </td>
  	         </tr>
  	         <tr>
  	          <th><label for="_filtered_by_column_index_localization"><?php _e('Create Select Filter by Column Index ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  	          <td>
  	           <input id="_filtered_by_column_index_localization" type="text" placeholder="2, 5" size="40" name="_filtered_by_column_index_localization" value="<?php echo $filtered_by_column_index_localization;
    ?>" />
  	           <p class="description"><?php _e('Filter selectors will create automatically by adding the column index and separated by comma. Maximum Filter selectors can create is three. Eg. Create filter selectors of Data Adjustment and Intended crop or project of ELC which have index 2 and 5', 'odm_profile');
    ?></p>
  	          </td>
  	         </tr>
  	         <tr>
  	          <th><label for="_group_data_by_column_index_localization"><?php _e('Group Data in Column ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  	          <td>
  	            <input id="_group_data_by_column_index_localization" type="text" placeholder="5" size="40" name="_group_data_by_column_index_localization" value="<?php echo $group_data_by_column_index_localization;
    ?>" />
  	            <p class="description"><?php _e('Eg. To group data classification of ELC, based on the attributes sample provided, the index of data classification is: 5', 'odm_profile');
    ?></p>
  	          </td>
  	         </tr>
  					 <tr>
  					  <th><label for="_related_profile_pages_localization"><?php _e('Related Profile Pages ('.odm_language_manager()->get_the_language_by_site().')', 'odm_profile');
    ?></label></th>
  					  <td>
  							<textarea name="_related_profile_pages_localization" style="width:100%;height: 50px;"placeholder="Lable of Link|URL"><?php echo $related_profile_pages_localization;
    ?></textarea>
  							<p class="description"><?php _e('Please add the links of profile pages that related (separated by new breaking line). Format: Title of Link|URL. <br/>eg.
  Economic Land Concessions|https://cambodia.opendevelopmentmekong.net/profiles/economic-land-concessions/', 'odm_profile');
    ?></p>
  					  </td>
  					 </tr>
  	        </tbody>
  	      </table>
  	   </div>
  	<?php

}
            ?>
  	  </div>
  	  <?php

        }

        public function save_post_data($post_id)
        {
            global $post;
            if (isset($post->ID) && get_post_type($post->ID) == 'profiles') {
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return;
                }

                if (defined('DOING_AJAX') && DOING_AJAX) {
                    return;
                }

                if (false !== wp_is_post_revision($post_id)) {
                    return;
                }

                if (!current_user_can('edit_post')) {
                    return;
                }

                if (isset($_POST['_attributes_template_layout'])) {
                    update_post_meta($post_id, '_attributes_template_layout', $_POST['_attributes_template_layout']);
                }

                if (isset($_POST['_full_width_middle_content'])) {
                    update_post_meta($post_id, '_full_width_middle_content', $_POST['_full_width_middle_content']);
                }

                if (isset($_POST['_full_width_middle_content_localization'])) {
                    update_post_meta($post_id, '_full_width_middle_content_localization', $_POST['_full_width_middle_content_localization']);
                }

                if (isset($_POST['_map_visualization_url'])) {
                    update_post_meta($post_id, '_map_visualization_url', $_POST['_map_visualization_url']);
                }

                if (isset($_POST['_map_visualization_url_localization'])) {
                    update_post_meta($post_id, '_map_visualization_url_localization', $_POST['_map_visualization_url_localization']);
                }

                if (isset($_POST['_csv_resource_url'])) {
                    update_post_meta($post_id, '_csv_resource_url', $_POST['_csv_resource_url']);
                }

                if (isset($_POST['_csv_resource_url_localization'])) {
                    update_post_meta($post_id, '_csv_resource_url_localization', $_POST['_csv_resource_url_localization']);
                }

                if (isset($_POST['_tracking_csv_resource_url'])) {
                    update_post_meta($post_id, '_tracking_csv_resource_url', $_POST['_tracking_csv_resource_url']);
                }

                if (isset($_POST['_tracking_csv_resource_url_localization'])) {
                    update_post_meta($post_id, '_tracking_csv_resource_url_localization', $_POST['_tracking_csv_resource_url_localization']);
                }

                if (isset($_POST['_filtered_by_column_index'])) {
                    update_post_meta($post_id, '_filtered_by_column_index', $_POST['_filtered_by_column_index']);
                }

                if (isset($_POST['_filtered_by_column_index_localization'])) {
                    update_post_meta($post_id, '_filtered_by_column_index_localization', $_POST['_filtered_by_column_index_localization']);
                }

                if (isset($_POST['_group_data_by_column_index'])) {
                    update_post_meta($post_id, '_group_data_by_column_index', $_POST['_group_data_by_column_index']);
                }

                if (isset($_POST['_group_data_by_column_index_localization'])) {
                    update_post_meta($post_id, '_group_data_by_column_index_localization', $_POST['_group_data_by_column_index_localization']);
                }

                if (isset($_POST['_total_number_by_attribute_name'])) {
                    update_post_meta($post_id, '_total_number_by_attribute_name', $_POST['_total_number_by_attribute_name']);
                }

                if (isset($_POST['_total_number_by_attribute_name_localization'])) {
                    update_post_meta($post_id, '_total_number_by_attribute_name_localization', $_POST['_total_number_by_attribute_name_localization']);
                }

                if (isset($_POST['_attributes_csv_resource'])) {
                    update_post_meta($post_id, '_attributes_csv_resource', $_POST['_attributes_csv_resource']);
                }

                if (isset($_POST['_attributes_csv_resource_localization'])) {
                    update_post_meta($post_id, '_attributes_csv_resource_localization', $_POST['_attributes_csv_resource_localization']);
                }

                if (isset($_POST['_attributes_csv_resource_tracking'])) {
                    update_post_meta($post_id, '_attributes_csv_resource_tracking', $_POST['_attributes_csv_resource_tracking']);
                }

                if (isset($_POST['_attributes_csv_resource_tracking_localization'])) {
                    update_post_meta($post_id, '_attributes_csv_resource_tracking_localization', $_POST['_attributes_csv_resource_tracking_localization']);
                }

                if (isset($_POST['_related_profile_pages'])) {
                    update_post_meta($post_id, '_related_profile_pages', $_POST['_related_profile_pages']);
                }

                if (isset($_POST['_related_profile_pages_localization'])) {
                    update_post_meta($post_id, '_related_profile_pages_localization', $_POST['_related_profile_pages_localization']);
                }
            }
        }
    }
}

?>
