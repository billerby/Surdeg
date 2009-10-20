<div id="commentform">
<?php if ( !is_topic() ) : ?>
<p>
	<label for="topic"><?php _e('Topic title: <small>(be brief and descriptive)</small>'); ?>
	</label>
	<input name="topic" type="text" id="topic" size="80" maxlength="80" tabindex="1" class="text"/>
</p>
<div class="clear"></div>
<?php endif; do_action( 'post_form_pre_post' ); ?>


<?php if ( !is_topic() ) : ?>
<p>
	<label for="tags-input"><?php printf(__('<a href="%s">Tags</a> <small>(separated by commas)</small>'), bb_get_tag_page_link()) ?>
	</label>
	<input id="tags-input" name="tags" type="text" size="80" maxlength="100" tabindex="2" value="<?php bb_tag_name(); ?> " class="text"/>
</p>
<div class="clear"></div>
<?php endif; ?>

<?php if ( is_bb_tag() || is_front() ) : ?>
<p>
	<label for="forum_id"><?php _e('Pick a section:'); ?>
	</label>
	<?php bb_new_topic_forum_dropdown(); ?>
</p>
<div class="clear"></div>
<?php endif; ?>

<p><small><strong><?php _e('XHTML:'); ?></strong> <?php _e('You can use these tags', 'guangzhou'); ?>: <code><?php allowed_markup(); ?></code>. <br /><strong><?php _e('Put code in between <code>`backticks`</code>.'); ?></strong></small></p>
<p>
	<textarea name="post_content" cols="50" rows="10" id="post_content" tabindex="3"></textarea>
</p>

 <input type="submit" class="button-primary" id="submit" name="Submit" value="<?php echo attribute_escape( __('Submit') ); ?>" tabindex="4" />
				
</div>
