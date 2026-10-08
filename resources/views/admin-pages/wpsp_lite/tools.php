<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>

<div id="poststuff">
	<div id="post-body" class="metabox-holder columns-<?php echo $screen_columns ?? 2 ?>">
		<div id="postbox-container-1" class="postbox-container">
			<?php
			do_meta_boxes(get_current_screen(), 'side', null);
			?>
		</div>
		<div id="postbox-container-2" class="postbox-container">
			<?php
			do_meta_boxes(get_current_screen(), 'normal', null);
			?>
		</div>
	</div>
</div>