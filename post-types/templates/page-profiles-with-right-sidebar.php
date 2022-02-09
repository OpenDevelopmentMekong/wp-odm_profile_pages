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

			if($full_width_content && !$full_width_position):
			?>
				<section class="container">
					<div class="row">
						<div class="sixteen columns">
							<?php echo "<div class='full-width-content below-map'>" . $full_width_content . "</div>"; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
        
			<section id="post-content">
				<?php the_content(); ?>
			</section>
      	</section>
    </div>

    <div class="four columns">
      	<aside id="sidebar">
			<ul class="widgets">
				<?php dynamic_sidebar('profile-right-sidebar'); ?>
			</ul>
      	</aside>
    </div>
</section>

<?php if (is_single('forest-cover')  ||is_single('forest-cover-analysis-1973-2013') || is_single('forest-cover-analysis-1973-2014')): ?>
	<?php wp_enqueue_script('slider-script',  plugin_dir_url("/").'wp-odm_profile_pages/js/slider-script.js');?>
<?php endif; ?>
