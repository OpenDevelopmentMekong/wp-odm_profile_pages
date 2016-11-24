<section class="container">
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
        	<?php dynamic_sidebar('profile-right-sidebar'); ?>
        </ul>
      </aside>
    </div>
</section>
