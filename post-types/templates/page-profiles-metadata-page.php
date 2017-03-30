<?php

$metadata_dataset = null;

if (isset($_GET['metadata'])) {
    $metadata_dataset = htmlspecialchars($_GET['metadata']);
}  ?>

<section class="container section-title main-title">
  <header class="row">
    <div class="sixteen columns">
      <h3 class="align-left profile-name"><?php _e('Metadata: ', 'odi'); the_title() ?></h3>
    </div>
  </header>
</section>

<section class="container">
    <div class="row">
      <div class="sixteen columns">
          <?php wpckan_get_metadata_info_of_dataset_by_id(wpckan_get_ckan_domain(), $metadata_dataset, 0, null); ?>
      </div>
    </div>
</section>
