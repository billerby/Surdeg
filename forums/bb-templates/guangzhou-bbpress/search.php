<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">

			<?php if ( !empty ( $q ) ) : ?>
			<h2><?php _e('Search for')?> &#8220;<?php echo wp_specialchars($q); ?>&#8221;</h2>
			<?php endif; ?>

			<?php if ( $recent ) : ?>
			<h3><?php _e('Recent Posts')?></h3>
			<ol class="results">
			<?php foreach ( $recent as $bb_post ) : ?>
			<li><h4><a href="<?php post_link(); ?>"><?php topic_title($bb_post->topic_id); ?></a></h4>
			<p><?php echo bb_show_context($q, $bb_post->post_text); ?></p>
			<p><small><?php _e('Posted') ?> <?php bb_post_time( __('F j, Y, h:i A') ); ?></small></p>
			</li>
			<?php endforeach; ?>
			</ol>
			<?php endif; ?>

			<?php if ( $relevant ) : ?>
			<h3><?php _e('Relevant posts')?></h3>
			<ol class="results">
			<?php foreach ( $relevant as $bb_post ) : ?>
			<li><h4><a href="<?php post_link(); ?>"><?php topic_title($bb_post->topic_id); ?></a></h4>
			<p><?php echo bb_show_context($q, $bb_post->post_text); ?></p>
			<p><small><?php _e('Posted') ?> <?php bb_post_time( __('F j, Y, h:i A') ); ?></small></p>
			</li>
			<?php endforeach; ?>
			</ol>
			<?php endif; ?>

			<?php if ( $q && !$recent && !$relevant ) : ?>
			<p><?php _e('No results found.') ?></p>
			<?php endif; ?>
			<br />
			<p><?php printf(__('You may also try your <a href="http://google.com/search?q=site:%1$s %2$s">search at Google</a>'), bb_get_option('uri'), urlencode($q)) ?></p>
		</div>
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<h2><?php _e('Page Information', 'guangzhou'); ?></h2>
					<p><?php printf(__('You are searching for <strong>%s</strong>', 'guangzhou'), wp_specialchars ($q)); ?></p>
					
					<?php bb_topic_search_form(array ('tag' => true, 'submit' => 'Search')); ?>
				</li>
				<li>
					<?php do_action ('gz_place_sidebar'); ?>
				</li>
			</ul>
		</div>
		
		<?php do_action ('gz_place_bottom'); ?>
	</div>
	<div class="clear"></div>
</div>
<?php bb_get_footer(); ?>
