<?php

namespace WK;

readonly final class WK_Admin_Page_Settings implements WK_Consts {
	public function render(): void {
		?>
		<div class="wrap">
			<h1>WannaKnow Settings</h1>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">Plugin version</th>
						<td><?php echo esc_html( WK_VERSION ); ?></td>
					</tr>
					<tr>
						<th scope="row">Plugin database table</th>
						<td><?php echo esc_html( WK_Consts::MAIN_TABLE_NAME ); ?></td>
					</tr>
					<tr>
						<th scope="row">Plugin database table columns</th>
						<td>
							<?php
							foreach ( WK_DB_Column::cases() as $column ) {
								echo esc_html( $column->value ) . ' | ' . esc_html( $column->description() ) . '<br>';
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<?php
			$all_roles = wp_roles();
			wk_p( $all_roles );

			if ( ! empty( $all_roles->role_names ) ) {
				?>
				<h2>Access Control</h2>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<td>Element / Role</td>
							<?php
							foreach ( $all_roles->role_names as $role_name ) {
								?>
								<td><?php echo esc_html( $role_name ); ?></td>
								<?php
							}
							?>
						</tr>
						<?php
						foreach ( WK_Element::cases() as $element ) {
							?>
							<tr>
								<td><?php echo esc_html( $element->get_name() ); ?></td>
								<?php
								foreach ( $all_roles->role_names as $role_key => $role_name ) {
									?>
									<td>
										<label for="<?php echo esc_attr( $element->get_option_name_for_role( $role_key ) ); ?>">
											Enable
										</label>
										<input
												type="checkbox"
												name="<?php echo esc_attr( $element->get_option_name_for_role( $role_key ) ); ?>"
												id="<?php echo esc_attr( $element->get_option_name_for_role( $role_key ) ); ?>">
									</td>
									<?php
								}
								?>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php
			}
			?>

			<h2>Event Listeners</h2>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">EVENT</th>
						<td>PLACEHOLDER</td>
					</tr>
				</tbody>
			</table>

			<div class="clear"></div>
		</div>
		<?php
	}
}