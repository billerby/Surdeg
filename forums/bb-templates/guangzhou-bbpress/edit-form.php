
<?php if ( $topic_title ) : ?>

<p><?php _e('Topic:'); ?></p>

  <input name="topic" type="text" id="topic" size="50" class="text" maxlength="80"  value="<?php echo attribute_escape( get_topic_title() ); ?>" style="width: 95%" />

<?php endif; ?>
<p><?php _e('Post:'); ?></p>
  <textarea name="post_content" cols="50" rows="16" style="width: 95%" class="text" id="post_content"><?php echo apply_filters('edit_text', get_post_text() ); ?></textarea>
<p class="submit">
<input class="button-primary" type="submit" name="<?php _e('Submit'); ?>" value="<?php echo attribute_escape( __('Edit Post') ); ?>" />
<input type="hidden" name="post_id" value="<?php post_id(); ?>" />
<input type="hidden" name="topic_id" value="<?php topic_id(); ?>" />
</p>
<p><?php _e('Allowed markup:'); ?> <code><?php allowed_markup(); ?></code>. <br /><strong><?php _e('Put code in between <code>`backticks`</code>.'); ?></strong></p>

