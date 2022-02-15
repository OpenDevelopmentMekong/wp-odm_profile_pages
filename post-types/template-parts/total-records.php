<?php
$show_total_value   = "";
$array_map_profile  = array();
$id                 = '';

if (array_key_exists("map_id", $profiles[0])) :
    $array_map_profile = array_map(function ($value) {
        return array_key_exists('map_id', $value) ? $value['map_id'] : "";
    }, $profiles);
    $id = "map_id";
else :
    $array_map_profile = array_map(function ($value) {
        return array_key_exists('_id', $value) ? $value['_id'] : "";
    }, $profiles);
    $id = "_id";
endif;

if ($array_map_profile) :
    $count_project =  array_count_values($array_map_profile);
endif;

// List total of dataset by map_id as default
if (count($count_project) > 1) :
    $show_total_value .= "<li><strong>";

    if (odm_language_manager()->get_current_language() == "km") :
        $show_total_value .= __("Total", "wp-odm_profile_pages") . get_the_title() . __("Listed", "wp-odm_profile_pages") . __(":", "wp-odm_profile_pages");
        $show_total_value .= $count_project == "" ? convert_to_kh_number("0") : convert_to_kh_number(count($count_project));
    else :
        $show_total_value .=  __("Total", "wp-odm_profile_pages") . " " . get_the_title() . __(" listed", "wp-odm_profile_pages") . __(": ", "wp-odm_profile_pages");
        $show_total_value .= $count_project == "" ? "0" : count($count_project);
    endif;

    $show_total_value .= "</strong></li>";
endif;

$explode_total_number_by_attribute_name = explode("\r\n", $total_number_by_attribute_name);

if ($total_number_by_attribute_name != "") :
    foreach ($explode_total_number_by_attribute_name as $key => $total_attribute_name) :
        if ($total_attribute_name != $id) :
            //check if total number require to list by Specific value
            $total_attributename = trim($total_attribute_name);

            if (strpos($total_attribute_name, '[') !== FALSE) :
                $split_field_name_and_value = explode("[", $total_attributename);
                $total_attributename = trim($split_field_name_and_value[0]); //eg. data_class
                $total_by_specifit_value = str_replace("]", "", $split_field_name_and_value[1]);
                $specifit_value = explode(',', $total_by_specifit_value); // explode to get: Government data complete
            endif;

            $GLOBALS['total_attribute_name'] = $total_attributename;
            $map_value = array_map(function ($value) {
                return $value[$GLOBALS['total_attribute_name']];
            }, $profiles);
            $count_number_by_attr =  array_count_values($map_value);

            if (isset($specifit_value) && count($specifit_value) > 0) :
                foreach ($specifit_value as $field_value) :
                    $field_value = trim(str_replace('"', "", $field_value));
                    $show_total_value .= '<li>' . __($field_value, "wp-odm_profile_pages") . __(": ", "wp-odm_profile_pages");

                    if (isset($count_number_by_attr[$field_value])) :
                        $show_total_value .= '<strong>' . $count_number_by_attr[$field_value] == "" ? convert_to_kh_number("0") : convert_to_kh_number($count_number_by_attr[$field_value]) . '</strong></li>';
                    endif;
                endforeach;
            else :
                if ($total_attribute_name != $id) :
                    $show_total_value .= "<li>";

                    if (odm_language_manager()->get_current_language() == 'km') :
                        $show_total_value .= __("Total", "wp-odm_profile_pages") . $DATASET_ATTRIBUTE[$total_attributename] . __("Listed", "wp-odm_profile_pages") . __(":", "wp-odm_profile_pages");
                        $show_total_value .= '<strong>' . $total_attributename == "" ? convert_to_kh_number("0") : convert_to_kh_number(count($count_number_by_attr)) . '</strong>';
                    else :
                        $show_total_value .=  __("Total", "wp-odm_profile_pages") . " " . $DATASET_ATTRIBUTE[$total_attributename] . " " . __(" listed", "wp-odm_profile_pages") . __(": ", "wp-odm_profile_pages");
                        $show_total_value .= '<strong>' . $total_attributename == "" ? "0" : count($count_number_by_attr) . '</strong>';
                    endif;

                    $show_total_value .= "</li>";
                endif;
            endif;
        endif;
    endforeach;
endif;

if ($show_total_value) :
?>
    <div class="row">
        <div class="sixteen columns">
            <div class="total_listed">
                <ul>
                    <?php echo $show_total_value; ?>
                </ul>
            </div>
        </div>
    </div>
<?php
endif;
