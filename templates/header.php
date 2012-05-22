<?php
/**
 * Header Template
 *
 */
?>
<?php
  global $post;
  $itemtype = '';
  $name = '';
  $image = '';
  $description = '';
  $address = '';
  $author = '';

  if ( isset($post) && $post->post_type == "property" ) { 

    $content = get_option('placester_listing_layout');
    if(isset($content) && $content != '') {return $content;}
    $html = '';
    $listing = @unserialize($post->post_content);

    // Single Property
    $itemtype = 'http://schema.org/Offer';
    if (isset($listing['location']['unit']) && $listing['location']['unit'] != null) {
      $name = @$listing['location']['address'] . ', ' . $listing['location']['unit'] . ' ' . @$listing['location']['locality'] . ', ' . @$listing['location']['region'];
      $address = @$listing['location']['address'] . ', ' . $listing['location']['unit'] . ' ' . @$listing['location']['locality'] . ', ' . @$listing['location']['region'];
    } else {
      $name = @$listing['location']['address'] . ' ' . @$listing['location']['locality'] . ', ' . @$listing['location']['region'];
      $address = @$listing['location']['address'] . ' ' . @$listing['location']['locality'] . ', ' . @$listing['location']['region'];
    }
    
    $image = @$listing['images']['0']['url'];
    $description = @$listing['cur_data']['desc'];
    $author = @pls_get_option('pls-user-name');

  } elseif ( is_single() ) {

  // Single Blog Post
  $itemtype = 'http://schema.org/BlogPosting';
  $name = $post->post_title;
  if (has_post_thumbnail( $post->ID ) ) {
    $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    $image = $post_image[0];
  }
  $description = pls_get_option('pls-site-subtitle');
  $address = @pls_get_option('pls-company-street') . " " . @pls_get_option('pls-company-locality') . ", " . @pls_get_option('pls-company-region');
  $author = $post->post_author;

  } else {
  
  $itemtype = 'http://schema.org/LocalBusiness';
  if (is_home()) {
    $name = pls_get_option('pls-company-name');
  } elseif (isset($post)) {
    $name = $post->post_title;
  }
  $image = pls_get_option('pls-site-logo');
  $description = pls_get_option('pls-company-description');
  $address = @pls_get_option('pls-company-street') . " " . @pls_get_option('pls-company-locality') . ", " . @pls_get_option('pls-company-region');
  $author = pls_get_option('pls-user-name');
  }
?>
<!doctype xmlns:fb="http://ogp.me/ns/fb#" html itemscope itemtype="<?php echo $itemtype; ?>">
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
  Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $name; ?></title>

  <!-- Facebook Tags -->
  <meta property="og:site_name" content="<?php echo pls_get_option('pls-site-title'); ?>" />
  <meta property="og:title" content="<?php echo $name; ?>" />
  <meta property="og:url" content="<?php the_permalink(); ?>" />
  <meta property="og:image" content="<?php echo $image; ?>">
  <meta property="fb:admins" content="<?php echo pls_get_option('pls-facebook-admins'); ?>">
  <!-- Meta Tags -->
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="author" content="<?php echo $author; ?>">
  <!-- Schema.org Tags -->
  <meta itemprop="name" content="<?php echo $name; ?>">
  <meta itemprop="email" content="<?php echo @pls_get_option('pls-company-email') ?>">
  <meta itemprop="address" content="<?php echo $address; ?>">
  <meta itemprop="description" content="<?php echo $description; ?>">
  <meta itemprop="url" content="<?php the_permalink(); ?>">

  <?php if ( pls_get_option('pls-site-favicon') ) { ?>
    <link href="<?php echo pls_get_option('pls-site-favicon'); ?>" rel="shortcut icon" type="image/x-icon" />
  <?php } ?>

  <?php if ( (pls_get_option('pls-css-options')) && (pls_get_option('pls-custom-css')) ) { ?>
    <style type="text/css"><?php echo pls_get_option('pls-custom-css'); ?></style>
  <?php } ?>

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php pls_do_atomic( 'open_body' ); ?>
    <div class="container_12 clearfix">

    	<?php pls_do_atomic( 'before_header' ); ?>
        <header id="branding" role="banner" class="grid_12" itemscope itemtype="http://schema.org/Organization">

            <?php pls_do_atomic( 'open_header' ); ?>
            <div class="wrapper">
                <hgroup>

									<?php if (pls_get_option('pls-site-logo')): ?>
										<div id="logo">
                      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo pls_get_option('pls-site-title'); ?>" rel="home" itemprop="url">
											<img src="<?php echo pls_get_option('pls-site-logo') ?>" alt="<?php bloginfo( 'name' ); ?>" itemprop="image">
											</a>
										</div>
									<?php endif; ?>

									<?php if (pls_get_option('pls-site-title')): ?>
										<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo pls_get_option('pls-site-title'); ?>" rel="home" itemprop="url"><?php echo pls_get_option('pls-site-title'); ?></a></h1>

										<?php if (pls_get_option('pls-site-subtitle')): ?>
											<h2 id="site-description" itemprop="description"><?php echo pls_get_option('pls-site-subtitle'); ?></h2>
										<?php endif ?>
									<?php endif; ?>

									<?php if (!pls_get_option('pls-site-logo') && !pls_get_option('pls-site-title')): ?>
										<h1 id="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
										<h2 id="site-description" itemprop="description"><?php bloginfo( 'description' ); ?></h2>
									<?php endif; ?>

                </hgroup>

                <?php pls_do_atomic( 'header' ); ?>

                <div class="header-membership"><?php echo PLS_Plugin_API::placester_lead_control_panel(array('separator' => '|')); ?></div>

            </div>

            <?php pls_do_atomic( 'before_nav'); ?>

            <?php PLS_Route::get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>

            <?php pls_do_atomic( 'close_header' ); ?>
        </header>
    <?php pls_do_atomic( 'after_header' ); ?>
