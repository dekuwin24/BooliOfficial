<?php
/**
 * Tophive Theme - BuddyPress - Groups Cover Image Header.
 *
 * @since 3.0.0
 * @version 3.2.0
 */
?>

<div id="cover-image-container">
	<div id="header-cover-image"></div>

	<div id="item-header-cover-image">
		<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
			<div id="item-header-avatar">
				<a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" title="<?php echo esc_attr( bp_get_group_name() ); ?>">

					<?php bp_group_avatar(); ?>

				</a>
			</div><!-- #item-header-avatar -->
		<?php endif; ?>
		<?php	if ( ! bp_nouveau_groups_front_page_description() ) : ?>
				<div id="item-header-content">
					<h4 class="group-name">
						<?php echo bp_group_name(); ?>
					</h4>
					<p class="group-status">
						<?php
						    echo esc_html( bp_get_group_status() );
						?>
					</p>

					<?php echo bp_nouveau_the_group_meta()->group_type_list; ?>
					<?php bp_nouveau_group_hook( 'before', 'header_meta' ); ?>

					<?php if ( bp_nouveau_group_has_meta_extra() ) : ?>
						<div class="item-meta">

							<?php echo bp_nouveau_the_group_meta()->extra; ?>

						</div><!-- .item-meta -->
					<?php endif; ?>

					<?php bp_nouveau_group_header_buttons(); ?>


					<div class="group-memebers-dp">
						<?php
							$args = array( 
							    'group_id' => bp_get_group_id(),
							    'exclude_admins_mods' => false
							);

							$group_members_result = groups_get_group_members( $args );
							$group_members = array();

							foreach(  $group_members_result['members'] as $member ) {
								$group_members[] = $member->ID;
							}
							$i = 0;
							if( !empty($group_members) ){
								foreach ($group_members as $value) {
									if( $i <= 3 ){
										echo get_avatar( $value, 25 );
									}
									$i++;
								}
								$total_members = count($group_members);
								$remaining = $total_members > 4 ? (int)$total_members - 4 : '';
								echo tophive_sanitize_filter($total_members) > 4 ? '<span class="remaining">+' . $remaining . esc_html__( ' Members', 'metafans' ) .'</span>' : '';
								echo '<a class="invitation-link" href="'. bp_get_group_permalink( $group ) .'send-invites">'. esc_html__( '+ Invite', 'metafans' ) .'</a>';
							}
						?>
					</div>
					<?php if ( ! bp_nouveau_groups_front_page_description() && bp_nouveau_group_has_meta( 'description' ) ) : ?>
						<div class="desc-wrap">
							<div class="group-description">
								<?php bp_group_description(); ?>
							</div><!-- //.group_description -->
						</div>
					<?php endif; ?>

					<?php bp_get_template_part( 'groups/single/parts/header-item-actions' ); ?>	
				</div><!-- #item-header-content -->
		<?php endif; ?>

	</div><!-- #item-header-cover-image -->


</div><!-- #cover-image-container -->
