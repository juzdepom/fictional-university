<?php

get_header();

while(have_posts()) {
    the_post(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>);"></div>
    <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title(); ?></h1>
    <div class="page-banner__intro">
        <p>DON'T FORGET TO REPLACE ME LATER</p>
    </div>
    </div>
</div>

<div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
        <i class="fa fa-home" aria-hidden="true"></i>
        All Programs
        </a>
    <span class="metabox__main"><?php the_title();?></span>
    </p>
    </div>

    <div class="generic-content">
    <?php the_content(); ?>
    <?php
        $relatedProfessors = new WP_Query(array(
            //-1 returns all posts that meet conditions
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                )
            )
        ));
        if($relatedProfessors->have_posts()){
            echo '<hr class="section-break" />';
            echo '<h4 class="headline headline--medium">' . get_the_title() . ' Professor(s)</h4>';
            //tell Wordpress what we want to query from the database

            echo '<ul class="professor-cards">';
            while($relatedProfessors->have_posts()) {
                //below gets the data ready for each post
                $relatedProfessors->the_post();?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url() ?>"/>
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>
            <?php }
            echo '</ul>';
        }

        //need to call this method otherwise everything below won't show
        //you want this everytime you run multiple queries
        wp_reset_postdata();

        $homepageEvents = new WP_Query(array(
            //-1 returns all posts that meet conditions
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today
                ),
                array(
                    /*
                    if the array of related programs contains (aka LIKE)
                    the id # of the current program post, then take it
                    */
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                )
            )
        ));
        if($homepageEvents->have_posts()){
            echo '<hr class="section-break" />';
            echo '<h4 class="headline headline--medium">Upcoming ' . get_the_title() . ' Event(s)</h4><br><br>';
            $today = date('Ymd');
            //tell Wordpress what we want to query from the database

            while($homepageEvents->have_posts()) {
                //below gets the data ready for each post
                $homepageEvents->the_post();?>
                <div class="event-summary">
                    <a class="event-summary__date t-center" href="#">
                        <span class="event-summary__month"><?php
                            $eventDate = new DateTime(get_field('event_date'));
                            echo $eventDate->format('M')
                            ?></span>
                        <span class="event-summary__day"><?php
                            $eventDate = new DateTime(get_field('event_date'));
                            echo $eventDate->format('d')
                            ?></span></span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <p><?php  if(has_excerpt()){
                            echo get_the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 18);
                        }
                        ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>
<?php }

get_footer();

?>