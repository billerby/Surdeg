<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php bb_title() ?></title>
	<?php bb_feed_head(); ?> 
	<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css" />
<?php if ( 'rtl' == bb_get_option( 'text_direction' ) ) : ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css" />
<?php endif; ?>

<?php
// hack för att få fram root-url till wordpressinstallationen
// gillar det inte eftersom det förutsätter att bbpress alltid ligger
// installerat i subfolder som är 7 tecken (plus /).
$url = "http://".$_SERVER['HTTP_HOST'];
$url2 = bb_get_option( 'uri' );
$urlLength=strlen($url2);
$stripTo=$urlLength-8;
$url = substr($url2, 0, $stripTo);

?>
<link rel="stylesheet" href="<?php echo $url; ?>/wp-content/themes/thesis_16/style.css?101409-18215" type="text/css" media="screen, projection" /> 
<link rel="stylesheet" href="<?php echo $url; ?>/wp-content/themes/thesis_16/custom/layout.css?110909-90640" type="text/css" media="screen, projection" /> 
<!--[if lte IE 7]><link rel="stylesheet" href="http://www.riktigtbrod.se/wp-content/themes/thesis_16/lib/css/ie.css?090809-195006" type="text/css" media="screen, projection" /><![endif]--> 
<link rel="stylesheet" href="<?php echo $url; ?>/wp-content/themes/thesis_16/custom/custom.css?110409-135134" type="text/css" media="screen, projection" /> 
 
<?php bb_head(); ?>

</head>

<body class="custom forum"> 
 
<div id="container"> 
<div id="page"> 
	<div id="header"> 
		<p id="logo"><a href="<?php echo $url; ?>">www.riktigtbrod.se</a></p> 
		<p id="tagline"></p> 
	</div> 
<ul class="menu"> 
<li class="tab tab-home"><a href="<?php echo $url; ?>">Hem</a></li> 
<li class="tab tab-1 current"><a href="<?php echo $url; ?>/forums/" title="Forum">Forum</a></li> 
<li class="tab tab-2"><a href="<?php echo $url; ?>/about/" title="Om riktigtbrod.se">Om riktigtbrod.se</a></li> 
<li class="cat-item cat-item-7"><a href="<?php echo $url; ?>/category/recept/" title="Se alla inlägg sparade under kategorin Recept">Recept</a> 
</li> 
<li class="rss"><a href="<?php echo $url; ?>/forums/rss.php" title="www.riktigtbrod.se RSS Feed" rel="nofollow">Subscribe</a></li> 
</ul> 
	

<div id="content_forum">
