<?php

namespace WPSPLITE\App\Policies;

use WPSPCORELITE\App\Auth\Access\HandlesAuthorization;
use WPSPLITE\App\Models\UsersModel;

/**
 * Gate tự tìm Policy này cho WPSPLITE\App\Models\UsersModel (Models → Policies + hậu tố Policy).
 *
 * Dùng với $this->authorizeResource(UsersModel::class, 'user') trong wpsp_lite_tab_users:
 * $user là \WP_User đang đăng nhập, $id là giá trị thô của tham số 'user' (vd: ?user=5).
 */
class UsersModelPolicy {

	use HandlesAuthorization;

	// Chạy trước mọi method
	public function before(\WP_User $user, string $ability) {
		return user_can($user, 'manage_options') ? true : null;
	}

	// index
	public function viewAny(\WP_User $user) {
//		return $this->allow();
		return $this->deny('Bạn không có quyền xem danh sách users.');
	}

	// show
	public function view(\WP_User $user, $model = null) {
//		return $this->allow();
		return $this->deny('Bạn không có quyền xem user này.');
	}

	// create, store
	public function create(\WP_User $user) {
		return user_can($user, 'create_users')
			? $this->allow()
			: $this->deny('Bạn không có quyền tạo user.');
	}

	// edit, update
	public function update(\WP_User $user, $model = null) {
//		$model = $this->find($id);
//
//		if (!$model) {
//			return $this->denyAsNotFound('Không tìm thấy user.');
//		}

		return user_can($user, 'edit_users')
			? $this->allow()
			: $this->deny('Bạn không có quyền sửa user này.');
	}

	// destroy
	public function delete(\WP_User $user, $model = null) {
		return user_can($user, 'delete_users')
			? $this->allow()
			: $this->deny('Bạn không có quyền xoá user này.');
	}

	// forceDestroy
	public function forceDelete(\WP_User $user, $model = null) {
		return false;
	}

	// restore
	public function restore(\WP_User $user, $model = null) {
		return user_can($user, 'delete_users');
	}

}
