<h2 style="color: blue;">Người dùng hiện tại xác thực qua WordPress</h2>
<div id="poststuff" class="row gx-3">
	<div class="col">
		<div class="meta-box-sortables ui-sortable">
			<div class="postbox">

				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle"><?php echo wpsp_lite_trans('Information', null, true); ?></h2>
					<div class="handle-actions">
						<button type="button" class="handlediv" aria-expanded="true">
							<span class="toggle-indicator"></span>
						</button>
					</div>
				</div>

				<div class="inside" style="height: 550px;">
					<table>
						<tbody>
						<tr>
							<td>
								<?php
								echo '<pre>'; print_r(isset($current_wp_user->data) ? $current_wp_user->data : null); echo '</pre>';
								?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
	<div class="col">
		<div class="meta-box-sortables ui-sortable">
			<div class="postbox">

				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle"><?php echo wpsp_lite_trans('Roles', null, true); ?></h2>
					<div class="handle-actions">
						<button type="button" class="handlediv" aria-expanded="true">
							<span class="toggle-indicator"></span>
						</button>
					</div>
				</div>

				<div class="inside">
					<table>
						<tbody>
						<tr>
							<td>
								<?php
								echo '<pre>'; print_r(isset($current_wp_user->roles) ? $current_wp_user->roles : null); echo '</pre>';
								?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>
		<div class="meta-box-sortables ui-sortable">
			<div class="postbox">

				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle"><?php echo wpsp_lite_trans('Permissions', null, true); ?></h2>
					<div class="handle-actions">
						<button type="button" class="handlediv" aria-expanded="true">
							<span class="toggle-indicator"></span>
						</button>
					</div>
				</div>

				<div class="inside">
					<table width="100%">
						<tbody>
						<tr>
							<td>
								<div style="max-height: 300px; overflow-y: auto;">
									<?php
									echo '<pre>'; print_r(isset($current_wp_user->allcaps) ? $current_wp_user->allcaps : null); echo '</pre>';
									?>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>