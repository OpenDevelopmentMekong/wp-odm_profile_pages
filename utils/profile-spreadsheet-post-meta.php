<?php
    if ( (odm_language_manager()->get_current_language() != 'en') ) {
			$ckan_csv_resource = get_post_meta($post->ID, '_csv_resource_url_localization', true);
			if (isset($ckan_csv_resource) && !empty($ckan_csv_resource)) {
        $ckan_dataset = str_replace('?type=dataset', '', $ckan_csv_resource);
        $ckan_dataset_tracking = str_replace('?type=dataset', '', get_post_meta($post->ID, '_tracking_csv_resource_url_localization', true));
        $filtered_by_column_index = str_replace('?type=dataset', '', get_post_meta($post->ID, '_filtered_by_column_index_localization', true));  // index start from zero, so "-1" is needed, however, due to adding "map_id" to first column of table, so -1 don't need it
        $group_data_by_column_index = str_replace('?type=dataset', '', get_post_meta($post->ID, '_group_data_by_column_index_localization', true));
        $total_number_by_attribute_name = str_replace('?type=dataset', '', get_post_meta($post->ID, '_total_number_by_attribute_name_localization', true));
        $related_profile_pages = str_replace('?type=dataset', '', get_post_meta($post->ID, '_related_profile_pages_localization', true));
    }
	} else {
			$ckan_csv_resource = get_post_meta($post->ID, '_csv_resource_url', true);
			if (isset($ckan_csv_resource) && !empty($ckan_csv_resource)) {
        $ckan_dataset = str_replace('?type=dataset', '', $ckan_csv_resource);
        $ckan_dataset_tracking = str_replace('?type=dataset', '', get_post_meta($post->ID, '_tracking_csv_resource_url', true));
        $filtered_by_column_index = get_post_meta($post->ID, '_filtered_by_column_index', true);  // index start from zero, so "-1" is needed, however, due to adding "map_id" to first column of table, so -1 don't need it
        $group_data_by_column_index = get_post_meta($post->ID, '_group_data_by_column_index', true);
        $total_number_by_attribute_name = get_post_meta($post->ID, '_total_number_by_attribute_name', true);
        $related_profile_pages = get_post_meta($post->ID, '_related_profile_pages', true);
    }
}
if($ckan_dataset){
    $ckan_dataset_exploded_by_dataset = explode('/dataset/', $ckan_dataset );
    $ckan_dataset_exploded_by_resource = explode('/resource/', $ckan_dataset_exploded_by_dataset[1]);
    $ckan_dataset_id = $ckan_dataset_exploded_by_resource[0];
    $ckan_dataset_csv_id = $ckan_dataset_exploded_by_resource[1];
    $dataset = wpckan_api_package_show(wpckan_get_ckan_domain(),$ckan_dataset_id);

    if ( !empty($filter_map_id) ) {
      $profiles = wpckan_get_datastore_resource(wpckan_get_ckan_domain(), $ckan_dataset_csv_id);
			if (array_key_exists("map_id", $profiles[0])):
        $profile = wpckan_get_datastore_resources_filter(wpckan_get_ckan_domain(), $ckan_dataset_csv_id, 'map_id', $filter_map_id)[0];
			else:
        $profile = wpckan_get_datastore_resources_filter(wpckan_get_ckan_domain(), $ckan_dataset_csv_id, '_id', $filter_map_id)[0];
			endif;
    } else {
        $profiles = wpckan_get_datastore_resource(wpckan_get_ckan_domain(), $ckan_dataset_csv_id);
    }
}
  //For Tracking
if (isset($ckan_dataset_tracking) && $ckan_dataset_tracking != '') {
    $ckan_dataset_tracking_exploded_by_dataset = explode('/dataset/', $ckan_dataset_tracking);
    $ckan_dataset_tracking_exploded_by_resource = explode('/resource/', $ckan_dataset_tracking_exploded_by_dataset[1]);
    $ckan_dataset_tracking_id = $ckan_dataset_tracking_exploded_by_resource[0];
    $ckan_dataset_tracking_csv_id = $ckan_dataset_tracking_exploded_by_resource[1];
    if (!empty($filter_map_id)) {
        $ammendements = wpckan_get_datastore_resources_filter(wpckan_get_ckan_domain(), $ckan_dataset_tracking_csv_id, 'map_id', $filter_map_id);
    }
}
  //For Attribute
if ( (isset($ckan_dataset) && $ckan_dataset != '') || (isset($ckan_dataset_tracking) &&  $ckan_dataset_tracking != '') ) {
    if ((odm_language_manager()->get_current_language() != 'en')) {
        $ckan_attribute = get_post_meta($post->ID, '_attributes_csv_resource_localization', true);
        $ckan_attribute_tracking = get_post_meta($post->ID, '_attributes_csv_resource_tracking_localization', true);
    } else {
        $ckan_attribute = trim(get_post_meta($post->ID, '_attributes_csv_resource', true));
        $ckan_attribute_tracking = get_post_meta($post->ID, '_attributes_csv_resource_tracking', true);
    }
}

if (isset($ckan_attribute) && $ckan_attribute != '') {
    $array_attribute = parse_mapping_pairs($ckan_attribute);
    $DATASET_ATTRIBUTE = $array_attribute;
}

if (isset($ckan_attribute_tracking) && $ckan_attribute_tracking != '') {
    $array_attribute = parse_mapping_pairs($ckan_attribute_tracking);
    $DATASET_ATTRIBUTE_TRACKING = $array_attribute;
}

if ( (odm_language_manager()->get_current_language() != 'en') ) {
		$link_to_detail_column = get_post_meta($post->ID, '_link_to_detail_column_localization', true);
} else {
		$link_to_detail_column = get_post_meta($post->ID, '_link_to_detail_column', true);
}

$ref_docs_profile = array();
$ref_docs_tracking = array();
?>
