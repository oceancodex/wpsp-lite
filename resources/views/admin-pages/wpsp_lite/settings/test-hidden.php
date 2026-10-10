<?php
// test-hidden.php

$id    = 'testhiddendiv';
$title = 'Test hidden';

// Kiểm tra trạng thái closed/hidden từ $admin_page_meta_boxes
$isClosed = isset($admin_page_meta_boxes['closed'][$id]) && $admin_page_meta_boxes['closed'][$id];
$isHidden = isset($admin_page_meta_boxes['hidden'][$id]) && $admin_page_meta_boxes['hidden'][$id];
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
		Metabox này được ẩn mặc định để thử nghiệm việc khai báo meta boxes trong admin page class với hidden meta boxes.
	</div>

</div>