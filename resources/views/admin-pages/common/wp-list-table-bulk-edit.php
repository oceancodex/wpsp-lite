<?php
/**
 * @var string|null $qe_title
 * @var string|null $qe_content
 * @var string|null $qe_save_button_label
 */
?>
<div id="poststuff" class="bulk-edit-panel" style="display: none;">
	<div class="postbox-container">
		<div class="postbox">
			<div class="postbox-header">
				<h2>
					<?php echo htmlspecialchars($qe_title ?? 'Quick edit', ENT_QUOTES, 'UTF-8'); ?>
				</h2>
			</div>
			<div class="inside form-table w-auto">
				<?php echo $qe_content ?? ''; ?>
			</div>
			<div class="border-top bg-light" style="padding: 12px;">
				<button class="button button-primary">
					<?php echo htmlspecialchars($qe_save_button_label ?? 'Save changes', ENT_QUOTES, 'UTF-8'); ?>
				</button>
				<button type="button" class="button button-secondary cancelled">Hủy</button>
			</div>
		</div>
	</div>
</div>