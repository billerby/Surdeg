<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php global $is_bb; if($is_bb) : ?>
	<link rel="stylesheet" href="../forums/my-templates/blank2rbbpress/style.css" type="text/css" media="screen" />
<?php endif; ?>

<?php /* if index.php or another page template (copied from index.php) was not used
(i.e. by a plugin such as WPG2), the global $bfa_ata would be empty */
global $bfa_ata; if ($bfa_ata == "") include_once (TEMPLATEPATH . '/functions/bfa_get_options.php'); ?>
<?php if ( $bfa_ata['css_external'] == "External" ) { ?>
<link rel="stylesheet" href="<?php echo $bfa_ata['get_option_home']; ?>/?bfa_ata_file=css" type="text/css" media="all" />
<?php } ?>
<?php include (TEMPLATEPATH . '/functions/bfa_meta_tags.php'); ?>
<?php if ($bfa_ata['favicon_file'] != "") { ?><link rel="shortcut icon" href="<?php echo $bfa_ata['template_directory']; ?>/images/favicon/<?php echo $bfa_ata['favicon_file']; ?>" /><?php } ?>
<?php if ( is_single() OR is_page() ) { ?><link rel="canonical" href="<?php the_permalink(); ?>" /><?php } ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 	wp_enqueue_script( 'jquery' ); ?>
<?php if ( function_exists('wp_list_comments') AND is_singular() ) { 	wp_enqueue_script( 'comment-reply' ); } ?>
<?php wp_head(); ?>
<?php echo ($bfa_ata['html_inserts_header'] != "" ? apply_filters(widget_text, $bfa_ata['html_inserts_header']) : ''); ?>
<?php if ($bfa_ata['pngfix_selectors'] != "") { ?>
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo $bfa_ata['template_directory']; ?>/js/DD_roundies.js"></script>
<script type="text/javascript">DD_roundies.addRule('<?php echo $bfa_ata['pngfix_selectors']; ?>');</script>
<![endif]-->
<?php } ?>
</head>
<body <?php body_class(); ?><?php echo ($bfa_ata['html_inserts_body_tag'] != "" ? ' ' . apply_filters(widget_text, $bfa_ata['html_inserts_body_tag']) : ''); ?>>
<?php echo ($bfa_ata['html_inserts_body_top'] != "" ? apply_filters(widget_text, $bfa_ata['html_inserts_body_top']) : ''); ?>
<div id="wrapper">
<div id="container">
<table id="layout" border="0" cellspacing="0" cellpadding="0">
<colgroup>
<?php if ( $bfa_ata['left_col'] == "on" ) { ?><col class="colone" /><?php } ?>
<?php if ( $bfa_ata['left_col2'] == "on" ) { ?><col class="colone-inner" /><?php } ?>
<col class="coltwo" />
<?php if ( $bfa_ata['right_col2'] == "on" ) { ?><col class="colthree-inner" /><?php } ?>
<?php if ( $bfa_ata['right_col'] == "on" ) { ?><col class="colthree" /><?php } ?>
</colgroup> 
	<tr>

		<!-- Header -->
		<td id="header" colspan="<?php echo $bfa_ata['cols']; ?>">

		<?php bfa_header_config($bfa_ata['configure_header']); ?>

		</td>
		<!-- / Header -->

	</tr>

	<!-- Main Body -->	
	<tr id="bodyrow">

		<?php if ( $bfa_ata['left_col'] == "on" ) { ?>
		<!-- Left Sidebar -->
		<td id="left">
			<?php // Widgetize the Left Sidebar 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Sidebar') ) : ?>
		
					<div class="widget widget_categories"><div class="widget-title">
					<h3><?php _e('Categories','atahualpa'); ?></h3>
					</div>
					<ul><?php wp_list_categories('show_count=1&title_li='); ?></ul>
					</div>
					
					<div class="widget widget_archive"><div class="widget-title">
					<h3><?php _e('Archives','atahualpa'); ?></h3>
					</div>
					<ul><?php wp_get_archives('type=monthly'); ?></ul>
					</div>
									
			<?php endif; ?>

		</td>
		<!-- / Left Sidebar -->
		<?php } ?>

		<?php if ( $bfa_ata['left_col2'] == "on" ) { ?>
		<!-- Left INNER Sidebar -->
		<td id="left-inner">

			<?php // Widgetize the Left Inner Sidebar 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Inner Sidebar') ) : ?>
		
					<!-- no default content for the LEFT INNER sidebar -->
									
			<?php endif; ?>

		</td>
		<!-- / Left INNER Sidebar -->
		<?php } ?>
		

		<!-- Main Column -->
		<td id="middle">