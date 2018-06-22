<?php

    get_header();

    while(have_posts()) {
        the_post();
        pageBanner();
        ?>



    <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('professors'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i>
            Professors Home
            </a>
        <span class="metabox__main"><?php the_title();?></span>
        </p>
        </div>

        <div class="generic-content">
            <div class="row group">

                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>

                <div class="two-thirds">
                    <?php the_content(); ?>
                </div>

            </div>
        <?php  ?>

        </div>

        <?php

            //we are getting Wordpress post objects
            $relatedPrograms = get_field('related_programs');

            if($relatedPrograms){
                echo '<hr class="section-break">';
                echo '<h4 class="headline headline--medium">Subject(s) Taught</h4>';
                echo '<ul class="link-list min-list">';
                foreach($relatedPrograms as $program) { ?>

                    <li>
                        <a href="<?php echo get_the_permalink($program) ?>">
                            <?php echo get_the_title($program); ?>
                        </a>
                    </li>
                <?php }
                echo '</ul>';
            }
        ?>

    </div>


    <?php }

    get_footer();

?>