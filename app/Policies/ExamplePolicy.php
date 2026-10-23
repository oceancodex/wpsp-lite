<?php

namespace WPSPLITE\App\Policies;

use WPSPCORELITE\App\Auth\Access\Response;

class ExamplePolicy {

	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(\WP_User $user) {
		return Response::deny('Access denied. Method "viewAny()" is being return "false" in ExamplePolicy');
	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view(\WP_User $user, $model = null) {
		if (current_user_can('manage_options')) {
			return true;
		}
		return false;
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(\WP_User $user) {
		return false;
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update(\WP_User $user, $model = null) {
		return false;
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(\WP_User $user, $model = null) {
		return false;
	}

	/**
	 * Determine whether the user can restore the model.
	 */
	public function restore(\WP_User $user, $model = null) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 */
	public function forceDelete(\WP_User $user, $model = null) {
		return false;
	}

}
