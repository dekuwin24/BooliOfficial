<?php
/**
 * BuddyPress - Members Notifications Loop
 *
 * @since 3.0.0
 * @version 3.1.0
 */

if ( bp_has_notifications( bp_ajax_querystring( 'notifications' ) ) ) :

	bp_nouveau_pagination( 'top' ); ?>

	<form action="" method="post" id="notifications-bulk-management" class="standard-form">
		<table class="notifications bp-tables-user">
			<thead>
				<tr>
					<th class="icon"></th>
					<th class="bulk-select-all"><input id="select-all-notifications" type="checkbox"><label class="bp-screen-reader-text" for="select-all-notifications"><?php esc_html_e( 'Select all', 'buddypress' ); ?></label></th>
					<th class="title"><?php esc_html_e( 'Notification', 'buddypress' ); ?></th>
					<th class="date">
						<?php esc_html_e( 'Date Received', 'buddypress' ); ?>
						<?php bp_nouveau_notifications_sort_order_links(); ?>
					</th>
					<th class="actions"><?php esc_html_e( 'Actions', 'buddypress' ); ?></th>
				</tr>
			</thead>

			<tbody>

				<?php
				while ( bp_the_notifications() ) :
					bp_the_notification();
				?>

					<tr>
						<td></td>
						<td class="bulk-select-check"><label for="<?php bp_the_notification_id(); ?>"><input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check"><span class="bp-screen-reader-text"><?php esc_html_e( 'Select this notification', 'buddypress' ); ?></span></label></td>
						<td class="notification-description"><?php bp_the_notification_description(); ?></td>
						<td class="notification-since"><?php bp_the_notification_time_since(); ?></td>
						<td class="notification-actions">
							<a href="#" data-action="read" data-notification-id="<?php bp_the_notification_id(); ?>">
								<span><?php esc_html_e('Mark as read', 'metafans' ); ?></span>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
								</svg>
							</a>
							<a href="#" data-action="delete" data-notification-id="<?php bp_the_notification_id(); ?>">
								<span><?php esc_html_e('Delete notification', 'metafans' ); ?></span>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
									<path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
								</svg>
							</a>
						</td>
					</tr>

				<?php endwhile; ?>

			</tbody>
		</table>

		<div class="notifications-options-nav">
			<?php bp_nouveau_notifications_bulk_management_dropdown(); ?>
		</div><!-- .notifications-options-nav -->

		<?php wp_nonce_field( 'notifications_bulk_nonce', 'notifications_bulk_nonce' ); ?>
	</form>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'member-notifications-none' ); ?>

<?php endif;
