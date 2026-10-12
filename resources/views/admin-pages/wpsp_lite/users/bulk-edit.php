<?php
/**
 * @var object $testService
 */

// 1. Thiết lập các biến cấu hình cho layout
$qe_title = 'Chỉnh sửa hàng loạt';

// 2. Bắt đầu gom nhóm HTML cho $qe_content bằng Output Buffering
ob_start();
?>

	<div class="row">
		<div class="col col-auto">
			<label for="bulk_edit[name]" class="d-block mb-1">Name</label>
			<input type="text" id="bulk_edit[name]" name="bulk_edit[name]"/>
		</div>
		<div class="col col-auto">
			<label for="bulk_edit[email]" class="d-block mb-1">Email</label>
			<input type="text" id="bulk_edit[email]" name="bulk_edit[email]"/>
		</div>
		<div class="col col-auto">
			<label for="bulk_edit[email]" class="d-block mb-1">
				<?php echo htmlspecialchars($testService->test(), ENT_QUOTES, 'UTF-8'); ?>
			</label>
			<?php echo htmlspecialchars($testService->subTestService->subTest(), ENT_QUOTES, 'UTF-8'); ?>
		</div>
	</div>

<?php
// Lấy toàn bộ nội dung HTML vừa render gán vào $qe_content
$qe_content = ob_get_clean();

// 3. Import layout chung (thay đổi đường dẫn cho phù hợp với dự án của bạn)
require __DIR__ . '/../../common/wp-list-table-bulk-edit.php';