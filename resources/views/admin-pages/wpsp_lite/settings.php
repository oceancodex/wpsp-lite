<form method="POST">
    <input name="action" value="save_settings" type="hidden"/>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-<?php echo htmlspecialchars($screen_columns ?? 2, ENT_QUOTES, 'UTF-8'); ?>">
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<?php if (!empty($admin_page_meta_boxes['side'])): ?>
						<?php foreach ($admin_page_meta_boxes['side'] as $admin_page_meta_box): ?>
							<?php if ($admin_page_meta_box && isset($admin_page_meta_box['view'])): ?>
								<?php include_once $admin_page_meta_box['view']; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<?php if (!empty($admin_page_meta_boxes['normal'])): ?>
						<?php foreach ($admin_page_meta_boxes['normal'] as $admin_page_meta_box): ?>
							<?php if ($admin_page_meta_box && isset($admin_page_meta_box['view'])): ?>
								<?php include_once $admin_page_meta_box['view']; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</form>

<?php
    wp_enqueue_media();
?>

<script>
	jQuery(document).ready(function ($) {
		let frame;
		$('#upload_logo_button').on('click', function (e) {
			e.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: 'Chọn hoặc upload ảnh',
				button: { text: 'Sử dụng ảnh này' },
				multiple: false
			});

			frame.on('select', function() {
				const attachment = frame.state().get('selection').first().toJSON();
				$('input[name="settings[logo]"]').val(attachment.url);
				$('#preview_logo').attr('src', attachment.url);
			});

			frame.open();
		});
	});
</script>


<script src="<?php echo wpsp_lite_asset('widen/plugins/autonumeric/autoNumeric.min.js'); ?>"></script>
<script src="<?php echo wpsp_lite_asset('widen/plugins/jquery-repeater/jquery.repeater.min.js'); ?>"></script>