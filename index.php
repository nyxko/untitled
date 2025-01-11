<!doctype html>
<html lang="<?php language_attributes(); ?>">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta name="color-scheme" content="light dark"> -->
  <title><?php echo wp_title( '|', true, 'right' ); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <header id="header">
    <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
    <p><?php bloginfo( 'description' ); ?></p>
    <?php 
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'container' => 'nav',
      'container_id' => 'nav',
      'container_class' => 'test',
      'menu_id' => 'nav',
      'menu_class' => 'pages',
      'fallback_cb' => 'wp_page_menu',
    ) ); ?>
  </header>

  <main>

    <?php if ( is_archive() ) : ?>
      <header>
        <h2><?php echo get_the_archive_title(); ?></h2>
        <div><?php echo get_the_archive_description(); ?></div>
      </header>
    <?php endif; ?>

    <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class(); ?>>

        <?php
        if ( $kicker = get_post_meta( get_the_ID(), 'kicker', true ) ) {
          echo '<div class="kicker">' . $kicker . '</div>';
        }
        ?>
        <?php
        if ( $category = get_the_term_list( get_the_ID(), 'category', '', ' ', '' ) ) {
          echo '<div class="category">' . $category . '</div>';
        }
        ?>

        <?php
        the_title(
          is_singular() ? '<h1 class="title">' : '<h2 class="title"><a href="' . get_permalink() . '">',
          is_singular() ? '</h1>' : '</a></h2>'
        );
        ?>

        <?php
        if ( is_singular() ) {
          if ( has_excerpt() ) {
            echo '<div class="summary">' . get_the_excerpt() . '</div>';
          }
          echo '<div class="content">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
        } else {
          echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
        }
        ?>

        <?php if ( is_singular() ) : ?>
        <?php #echo '<div class="author">' . get_the_author() . '</div>'; ?>
        <?php echo '<div class="date">' . get_the_date() . '</div>'; ?>
        <?php #echo '<div class="tags">' . get_the_tag_list( 'Tags: ', ', ', '' ) . '</div>'; ?>

        <?php if ( $prev = get_previous_post() ) : ?>
          <a href="<?php echo get_permalink( $prev ); ?>" class="prev">Previous: <?php echo get_the_title( $prev ); ?></a>
        <?php endif; ?>

        <?php endif; ?>

      </article>
    <?php endwhile; ?>
    <?php else : ?>
      <article class="nothing">
      <?php if ( is_search() ) : ?>
        <p>No results found for '<?php echo get_search_query(); ?>'.</p>
      <?php elseif ( is_404() ) : ?>
        <h1>404 Not Found</h1>
        <p>Page not found.</p>
      <?php else : ?>
        <p>Nothinng to see here.</p>
      <?php endif; ?>
      </article>
    <?php endif; ?>

    <?php the_posts_pagination( array(
      'screen_reader_text' => 'Pagination',
      'prev_text' => 'Previous',
      'next_text' => 'Next' ) ); ?>
  
  </main>

  <aside>
    <?php dynamic_sidebar( 'sidebar' ); ?>
  </aside>

  <footer>
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
  </footer>

  <?php wp_footer(); ?>

</body>
</html>