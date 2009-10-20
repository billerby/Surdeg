<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<title><?php echo GZ::page_title(); ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta name="theme" content="Guangzhou <?php echo GZ::version(); ?>" />
	
	<?php wp_head(); ?>
	
	<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/print.css" type="text/css" media="print" charset="utf-8"/>
</head>

<body <?php if ( function_exists( 'body_cass' ) ) body_class(); ?>>
<div id="header">
	<div class="pagewrap">
		<h1><a href="<?php echo get_option( 'home' ); ?>/"><?php bloginfo( 'name' ); ?></a></h1>

		<div class="mainmenu">
			<ul>
				<?php foreach (GZ::main_menu() AS $link) : ?>
				<li><?php echo GZ::link_detail( $link ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="tagline">
			<?php bloginfo( 'description' ); ?>
		</div>
	</div>
</div>

<div class="topmenu">
	<div class="pagewrap">
		<ul>
			<?php if ( GZ::get_options( 'login_menu' ) ) : ?>
				<?php if ( is_user_logged_in() ) : ?>
				<li><?php GZ::profile_link() ?></li>
				<?php else : ?>
				<li><?php wp_register( '', '' ); ?></li>
				<li><?php wp_loginout(); ?></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php foreach ( GZ::top_menu() AS $link ) : ?>
			<li><?php echo GZ::link_detail( $link ); ?></li>
			<?php endforeach; ?>
		
			<?php if ( GZ::get_options( 'skip_links' ) ) : ?>
				<li><a href="#content"><?php _e( 'Skip to content', 'guangzhou' ) ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>