<?php
// input.php

$id = 'inputsdiv';
$title = 'Cài đặt';

// Trạng thái closed/hidden từ $admin_page_meta_boxes
$isClosed = isset($admin_page_meta_boxes['closed'][$id]) && $admin_page_meta_boxes['closed'][$id];
$isHidden = isset($admin_page_meta_boxes['hidden'][$id]) && $admin_page_meta_boxes['hidden'][$id];

// Helper function xử lý lấy giá trị old() hoặc mặc định
if (!function_exists('wpsp_get_value')) {
	function wpsp_get_value($key, $default = '') {
		return function_exists('old') ? (old($key) ?? $default) : $default;
	}
}

// Helper function lấy thông báo lỗi validation
if (!function_exists('wpsp_get_error')) {
	function wpsp_get_error($key) {
		if (function_exists('errors')) {
			$errors = errors();
			return $errors->first($key);
		}
		return null;
	}
}

// Chuẩn bị dữ liệu cho repeater items
$repeaterItems = $settings['repeater_demo'] ?? [[]];
$noImageUrl = wpsp_lite_asset('widen/media/images/no-image.jpg');
?>

<div id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>"
	 class="postbox <?php echo $isClosed ? 'closed' : ''; ?> <?php echo $isHidden ? 'hidden' : ''; ?>">

	<div class="postbox-header">
		<h2 class="hndle ui-sortable-handle">
			<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>
		</h2>
		<div class="handle-actions">
			<button type="button" class="handle-order-higher" aria-disabled="true" aria-describedby="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>-handle-order-higher-description">
				<span class="screen-reader-text">Di chuyển lên</span>
				<span class="order-higher-indicator" aria-hidden="true"></span>
			</button>
			<span class="hidden" id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>-handle-order-higher-description">Chuyển Xuất bản lên trên</span>

			<button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>-handle-order-lower-description">
				<span class="screen-reader-text">Di chuyển xuống</span>
				<span class="order-lower-indicator" aria-hidden="true"></span>
			</button>
			<span class="hidden" id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>-handle-order-lower-description">Chuyển Xuất bản xuống dưới</span>

			<button type="button" class="handlediv" aria-expanded="<?php echo $isClosed ? 'false' : 'true'; ?>">
				<span class="screen-reader-text">Chuyển đổi bảng điều khiển: Xuất bản</span>
				<span class="toggle-indicator" aria-hidden="true"></span>
			</button>
		</div>
	</div>

	<div class="inside w-auto mt-0" style="padding: 12px;">
		<p class="mt-0">Đây là meta box được xây dựng bằng PHP thuần.<br/>Khi sử dụng phương thức này, screen options sẽ cần được thiết lập để hiển thị ra.</p>

		<!-- Media Upload Logo -->
		<div class="input-group mt-2">
			<label for="settings[logo]button" class="d-inline-block">
				Logo:
				<?php
				$media_url_val = wpsp_get_value('settings.logo', $settings['logo'] ?? '');
				$media_attachment_val = wpsp_get_value('settings.logo_attachment_id', $settings['logo_attachment_id'] ?? '');
				?>
				<div class="wpsp-lite-admin-media-upload mt-1" data-no_image_url="<?php echo htmlspecialchars($noImageUrl, ENT_QUOTES, 'UTF-8'); ?>">
					<img class="preview-image d-block mb-2 border" style="max-width:118px;" alt="" src="<?php echo htmlspecialchars($media_url_val ?: $noImageUrl, ENT_QUOTES, 'UTF-8'); ?>"/>
					<div class="hiddenx mb-2">
						<input type="text"
							   id="settings[logo_attachment_id]"
							   name="settings[logo_attachment_id]"
							   value="<?php echo htmlspecialchars($media_attachment_val, ENT_QUOTES, 'UTF-8'); ?>"
							   class="media-attachment-value hiddenx m-0"
							   placeholder="Attachment ID"
						/>
						<input type="text"
							   id="settings[logo]"
							   name="settings[logo]"
							   value="<?php echo htmlspecialchars($media_url_val, ENT_QUOTES, 'UTF-8'); ?>"
							   class="media-url-value hiddenx m-0"
							   placeholder="URL"
						/>
						<input type="text"
							   id=""
							   name=""
							   value=""
							   class="media-file-name-value hiddenx m-0"
							   placeholder="File name"
						/>
					</div>
					<button class="button button-primary button-small button-upload" type="button" id="settings[logo]button">Chọn tệp tin</button>
					<button class="button button-small button-remove" type="button">Xóa</button>
				</div>
			</label>
		</div>

		<!-- Input Test -->
		<div class="input-group mt-3">
			<label for="test">
				Test (required, min: 10):
				<input type="text" id="test" name="test" class="w-100 mt-1"
					   value="<?php echo htmlspecialchars(wpsp_get_value('test', $test ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
			</label>
			<?php if ($testError = wpsp_get_error('test')): ?>
				<span class="text-danger mt-1 d-block" style="color: red;"><?php echo htmlspecialchars($testError, ENT_QUOTES, 'UTF-8'); ?></span>
			<?php endif; ?>
		</div>

		<!-- Setting 1 -->
		<div class="input-group mt-3">
			<label for="settings[setting_1]">
				Setting 1:
				<input type="text" id="settings[setting_1]" name="settings[setting_1]" class="w-100 mt-1"
					   value="<?php echo htmlspecialchars(wpsp_get_value('settings.setting_1', $settings['setting_1'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
			</label>
			<?php if ($setting1Error = wpsp_get_error('settings.setting_1')): ?>
				<span class="text-danger mt-1 d-block" style="color: red;"><?php echo htmlspecialchars($setting1Error, ENT_QUOTES, 'UTF-8'); ?></span>
			<?php endif; ?>
		</div>

		<!-- Setting 2 -->
		<div class="input-group mt-3">
			<label for="settings[setting_2]">
				Setting 2:
				<input type="text" id="settings[setting_2]" name="settings[setting_2]" class="w-100 mt-1"
					   value="<?php echo htmlspecialchars(wpsp_get_value('settings.setting_2', $settings['setting_2'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
			</label>
		</div>

		<!-- Expiry Date -->
		<div class="input-group mt-3">
			<label for="settings[expiry_date]">
				<?php echo wpsp_lite_trans('messages.expiry_date'); ?>:
				<input type="text"
					   id="settings[expiry_date]"
					   name="settings[expiry_date]"
					   class="w-100 mt-1 wpsp-lite-admin-date-picker"
					   value="<?php echo htmlspecialchars(wpsp_get_value('settings.expiry_date', $settings['expiry_date'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"/>
			</label>
		</div>

		<!-- Toggle visible condition (Select) -->
		<div class="input-group mt-3">
			<label for="toggle_visible_condition">
				Toggle condition:
				<?php
				$selectVal = wpsp_get_value('toggle_visible_condition', null);
				$selectOptions = [
					'placeholder' => '- Chọn -',
					'one' => 'One',
					'two' => 'Two',
				];
				?>
				<select id="toggle_visible_condition"
						name="toggle_visible_condition"
						class="mt-1 w-100 toogle-visible-condition-controller"
						size="1"
						data-controller_trigger="change"
						data-controller_selector="option:selected"
						data-controller_source_data="value"
						data-victim_selector=".test-toggle-condition-1, .test-toggle-condition-2"
						data-victim_source_data="data-toggle_condition_show_if_controller_value">
					<?php foreach ($selectOptions as $optionKey => $optionLabel): ?>
						<?php if ($optionKey === 'placeholder'): ?>
							<option value=""><?php echo htmlspecialchars($optionLabel, ENT_QUOTES, 'UTF-8'); ?></option>
						<?php else: ?>
							<option value="<?php echo htmlspecialchars($optionKey, ENT_QUOTES, 'UTF-8'); ?>"
								<?php echo ($selectVal !== null && !is_array($selectVal) && $selectVal == $optionKey) ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars($optionLabel, ENT_QUOTES, 'UTF-8'); ?>
							</option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</label>
		</div>

		<!-- Dynamic elements conditioned via JS -->
		<div class="input-group mt-3">
			<div class="test-toggle-condition-1" data-toggle_condition_show_if_controller_value="one" style="display: none;">One</div>
			<div class="test-toggle-condition-2" data-toggle_condition_show_if_controller_value="two" style="display: none;">Two</div>
		</div>

		<!-- Popup demo -->
		<div class="input-group mt-3">
			<a href="javascript:void(0);" class="button-open-popup button button-primary" data-target_popup_selector="#popup_demo">Popup demo</a>

			<!-- Popup HTML Inline -->
			<div id="popup_demo" class="wpsp-popup-wrapper" style="display: none;">
				<div class="wpsp-popup-container">
					<div class="wpsp-popup-header">
						<h3 class="wpsp-popup-title">Popup demo</h3>
					</div>
					<div class="wpsp-popup-content">
						Đây là popup demo
					</div>
					<div class="wpsp-popup-footer">
						<button class="button button-secondary me-2 button-close-popup">Hủy bỏ</button>
						<button class="button button-primary">Lưu lại</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Repeater -->
		<div class="input-group mt-3">
			<div class="repeater">
				<div data-repeater-list="settings[repeater_demo]" class="repeater-demo">
					<?php foreach ($repeaterItems as $key => $item): ?>
						<div data-repeater-item class="repeater-demo-item row mt-1 gx-2 align-items-center">
							<!-- Base name -->
							<input type="hidden"
								   name="repeater_demo[0][id]"
								   data-item_base_name="repeater_demo[0]"
								   value="<?php echo htmlspecialchars($key ?? 0, ENT_QUOTES, 'UTF-8'); ?>"/>

							<!-- Name -->
							<div class="col col-2">
								<input name="repeater_demo[0][name]"
									   type="text"
									   class="w-100 d-block"
									   placeholder="Tên hạng mục"
									   value="<?php echo htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								/>
							</div>

							<!-- Unit price -->
							<div class="col col-2 text-end">
								<div class="d-flex">
									<input name="repeater_demo[0][unit_price]"
										   id="repeater_demo[0][unit_price]"
										   type="text"
										   step="0.01"
										   class="wpsp-lite-autonumeric w-100 text-end"
										   data-repeater_value="0"
										   value="<?php echo htmlspecialchars($item['unit_price'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
										   placeholder="Đơn giá"/>

									<!-- Currency Select Inline -->
									<select name="repeater_demo[0][currency]" class="" size="1">
										<option value="VND" selected>VND</option>
									</select>
								</div>
							</div>

							<!-- Time -->
							<div class="col col-2">
								<input id="repeater_demo[0][issue_date]"
									   name="repeater_demo[0][issue_date]"
									   type="text"
									   class="wpsp-lite-admin-date-picker w-100"
									   value="<?php echo htmlspecialchars($item['issue_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
									   placeholder="Thời gian"/>
							</div>

							<!-- Actions -->
							<div class="col col-auto text-end">
								<input data-repeater-delete class="button" type="button" value="Xóa"/>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<input data-repeater-create class="button button-primary mt-3" type="button" value="Thêm"/>
			</div>
		</div>

		<!-- Loading Indicator -->
		<div class="input-group mt-3">
			<div class="repeater">
				<button type="button" class="loading-indicator loading-indicator-hidden loading-indicator-right button button-primary" data-indicator_init_hide="true" data-indicator_trigger="click">
					Thử nghiệm loading indicator
				</button>
			</div>
		</div>

	</div>

</div>