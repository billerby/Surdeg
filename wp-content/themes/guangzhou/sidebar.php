<div class="sidebar">
	<ul>
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 1 ) ) : ?>
			<?php $info = new GZ_Widget_PageInfo( __( 'Page Information', 'guangzhou' )); $info->display( array( 'before_widget' => '<li>', 'after_widget' => '</li>' ) ); ?>
			<?php $search = new GZ_Widget_Search( __( 'Search', 'guangzhou' ) ); $search->display( array( 'before_widget' => '<li>', 'after_widget' => '</li>', 'before_title' => '<h2>', 'after_title' => '</h2>' ) ); ?>
		<?php endif;?>
	</ul>
</div>
