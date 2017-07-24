<?php get_header(); ?>

<?php if (have_posts()) : the_post(); ?>

<?php
// End of hack
$ammendements = null;
$profile = null;
$profiles = null;
$filter_map_id = null;
$metadata_dataset = null;
$dataset = null;
$DATASET_ATTRIBUTE = null;

if (isset($_GET['feature_id'])) {
    $filter_map_id = htmlspecialchars($_GET['feature_id']);
}

if (isset($_GET['metadata'])) {
    $metadata_dataset = htmlspecialchars($_GET['metadata']);
}

if ( (odm_language_manager()->get_current_language() !== 'en') ) {
    $ckan_dataset = str_replace('?type=dataset', '', get_post_meta($post->ID, '_csv_resource_url_localization', true));
} else {
    $ckan_dataset = str_replace('?type=dataset', '', get_post_meta($post->ID, '_csv_resource_url', true));
}

if ( isset($ckan_dataset ) && $ckan_dataset != '') {
    $ckan_dataset_exploded_by_dataset = explode('/dataset/', $ckan_dataset );
    $ckan_dataset_exploded_by_resource = explode('/resource/', $ckan_dataset_exploded_by_dataset[1]);
    $ckan_dataset_id = $ckan_dataset_exploded_by_resource[0];
    $dataset = wpckan_api_package_show(wpckan_get_ckan_domain(),$ckan_dataset_id);
}

$template = get_post_meta($post->ID, '_attributes_template_layout', true);
$sub_navigation = get_post_meta($post->ID, '_page_with_sub_navigation', true);
?>
<?php if(!$sub_navigation):?>

	<section class=	"container section-title main-title">
    <header class="row">
      <div class="ten columns">
        <h1><?php the_title(); ?></h1>
      	<?php echo_post_meta(get_post()); ?>
      </div>
      <?php
      if(!empty($dataset)): ?>
        <div class="six columns align-right">
          <?php echo_download_button_link_to_datapage($ckan_dataset_id) ?>
        </div>
      <?php
			elseif (odm_screen_manager()->is_desktop()): ?>
        <div class="four columns">
          <div class="widget share-widget">
            <?php odm_get_template('social-share',array(),true); ?>
          </div>
        </div>
      <?php
    	endif;
      ?>
    </header>
	</section>
<?php endif; ?>

<section id="content" class="single-post">
  <?php if (!empty($filter_map_id)):
          include 'page-profiles-single-page.php';
        elseif (!empty($metadata_dataset)):
          include 'page-profiles-metadata-page.php';
        else:
          if ($template == 'with-widget'):
            include 'page-profiles-page-with-widget.php';
          elseif ($template == 'with-right-sibebar'):
            include 'page-profiles-with-right-sidebar.php';
          elseif ($template == 'with-sub-navigation'):
            include 'page-profiles-with-sub-navigation.php';
          else:
            include 'page-profiles-list-page.php';
          endif;

        endif;
        ?>
	</section>
<?php endif; ?>

<?php get_footer(); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">

jQuery(document).ready(function($) {

 $('.filter_box').select2();

 <?php
	 if($sub_navigation){
	 	$sub_menu = '<nav id="od-menu" class="od-submenu"><div class="od-submenu-bg '. odm_country_manager()->get_current_country() .'-bgcolor">
		</div><div class="container"><div class="six columns"><h1>'.get_the_title().'</h1></div><div class="ten columns">'. wp_nav_menu(array('menu' => $sub_navigation, 'echo'=>false)) .'</div></div></nav>';
    $sub_menu = str_replace( array("\r\n", "\n", "\r"), "", $sub_menu);
		?>
		$("#od-menu").after('<?php echo trim($sub_menu); ?>');
		<?php
	 }
?>
});

</script>
