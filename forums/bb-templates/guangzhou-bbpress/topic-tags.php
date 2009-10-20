<div id="topic-tags">
	<?php if ( $public_tags ) : ?>
	<div id="othertags">
		<ul id="yourtaglist">
		<?php foreach ( $public_tags as $tag ) : ?>
			<li id="tag-<?php echo $tag->tag_id; ?>_<?php echo $tag->user_id; ?>">
				<a href="<?php bb_tag_link(); ?>" rel="tag"><?php bb_tag_name(); ?></a> <?php $tags = bb_get_tag_remove_link (); if ($tags) echo '<small>'.$tags.'</small>'; ?>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php else : ?>
		<p><?php printf(__('No <a href="%s">tags</a> yet.'), bb_get_tag_page_link() ); ?></p>
	<?php endif; ?>
	
	<?php GZ::tag_form(); ?>
</div>
