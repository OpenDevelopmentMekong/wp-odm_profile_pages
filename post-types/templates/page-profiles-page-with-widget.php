
  <section class="container">
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
      <div class="twelve columns post-title">
				<section class="content section-content">
					<?php
		      if(function_exists('display_embedded_map')){
		        display_embedded_map(get_the_ID());
		      }
		      ?>

  				<section id="post-content">
						<?php the_content(); ?>
  				</section>
        </section>
      </div>

      <div class="four columns">
        <aside id="sidebar">
          <ul class="widgets">
          	<?php dynamic_sidebar('profile-area-1'); ?>
          </ul>
        </aside>
      </div>
  </section>
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
  <?php endif; ?>

	<section id="profile-area-bottom" class="page-section footer-sidebar">
    <div class="container">
      <div class="row">
       <div class="eight columns">
         <?php dynamic_sidebar('profile-area-2'); ?>
       </div>
       <div class="eight columns">
         <?php dynamic_sidebar('profile-area-3'); ?>
       </div>
     </div>
    </div>
  </section>
