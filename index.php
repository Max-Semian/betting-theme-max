<?php
/**
 * The main template file
 *
 * @package Betting_Theme_Max
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="entry-meta">
                            <span class="posted-on"><?php echo get_the_date(); ?></span>
                            <span class="byline"> by <?php the_author(); ?></span>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                    </footer>
                </article>
                <?php
            endwhile;

            the_posts_pagination();
        else :
            ?>
            <p><?php esc_html_e( 'No posts found.', 'betting-theme-max' ); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
