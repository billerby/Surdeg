<?php bb_get_header(); ?>
<div id="main">
	<div class="page">
		<div id="content">
			<div class="post">
				<?php if ($popular) : ?>
				<h2><?php _e('Most Popular Topics'); ?></h2>
				<ol>
					<?php foreach ($popular as $topic) : ?>
					<li><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a> &#8212; <?php topic_posts(); ?> posts</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ol>
			</div>
		</div>
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<h2><?php _e('Statistics'); ?></h2>
					<dl>
						<dt><?php _e('Registered Users'); ?></dt>
						<dd><strong><?php total_users(); ?></strong></dd>
						<dt><?php _e('Posts'); ?></dt>
						<dd><strong><?php total_posts(); ?></strong></dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php bb_get_footer(); ?>
