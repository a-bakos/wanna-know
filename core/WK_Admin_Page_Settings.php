<?php

namespace WK;

readonly final class WK_Admin_Page_Settings implements WK_Consts {
	public function render() {
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