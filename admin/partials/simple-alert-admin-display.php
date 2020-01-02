<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h1 class="sa-plugin-heading">
		<?php esc_html_e( 'Simple Alert Settings', 'simple-alert' ); ?>
	</h1>
	<div class="sa-admin-settings-page">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'simple_alert_general_settings' );
			do_settings_sections( 'simple_alert_general_settings' );
			?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label>
								<?php esc_html_e( 'Alert Message', 'simple-alert' ); ?>
							</label>
						</th>
						<td>
							<textarea name="simple_alert_general_settings[alert_message]"><?php echo esc_html( $settings['alert_message'] ); ?></textarea>
							<p class="description">
								<?php esc_html_e( 'Add alert message.', 'simple-alert' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label>
								<?php esc_html_e( 'Enable Simple alert', 'simple-alert' ); ?>
							</label>
						</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span>
										<?php esc_html_e( 'Enable Simple alert', 'simple-alert' ); ?>
									</span>
								</legend>
								<label for="simple_alert_general_settings[enable_on_pages]">
									<input name="simple_alert_general_settings[enable_on_pages]" type="checkbox" class="sa-checkbox" value="1" <?php checked( $settings['enable_on_pages'], '1' ); ?>/>
									<?php esc_html_e( 'Pages', 'simple-alert' ); ?>
								</label>			
								<select name="simple_alert_general_settings[pages][]" id="sa_page_list" class="sa-selectize <?php echo $page_list_class; ?>" multiple>
								<?php
								if ( ! empty( $page_list ) ) {
									foreach( $page_list as $page_id => $page_name ) {
										if ( ! empty( $settings['pages'] ) ) {
											if ( in_array( $page_id, $settings['pages'] ) ) { ?>
												<option value="<?php echo esc_html( $page_id ); ?>" <?php echo 'selected = selected'; ?>><?php echo esc_html( $page_name ); ?></option>
											<?php } else { ?>	
												<option value="<?php echo esc_html( $page_id ); ?>"><?php echo esc_html( $page_name ); ?>	
												</option>
										<?php } } else { ?>
											<option value="<?php echo esc_html( $page_id ); ?>"><?php echo esc_html( $page_name ); ?>		
											</option>								
										<?php }								
									}
								}
								?>
								</select>
								<label for="simple_alert_general_settings[enable_on_posts]">
									<input name="simple_alert_general_settings[enable_on_posts]" type="checkbox" class="sa-checkbox" value="1" <?php checked( $settings['enable_on_posts'], '1' ); ?>/>
									<?php esc_html_e( 'Posts', 'simple-alert' ); ?>
								</label>										
								<select name="simple_alert_general_settings[posts][]" id="sa_post_list" class="sa-selectize <?php echo $post_list_class; ?>" multiple>
								<?php
								$post_ids = get_posts(array(
										    'fields'         => 'ids',
										    'posts_per_page' => -1,
										    'post_type'      => 'post'
										));	
								if ( ! empty( $post_ids ) ) {
									foreach( $post_ids as $post_id ) {
										if ( ! empty( $settings['posts'] ) ) {
											if ( in_array( $post_id, $settings['posts'] ) ) { ?>
												<option value="<?php echo esc_html( $post_id ); ?>" <?php echo 'selected = selected'; ?>><?php echo get_the_title( $post_id ); ?></option>
											<?php } else { ?>	
												<option value="<?php echo esc_html( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?>	
												</option>
										<?php } } else { ?>
											<option value="<?php echo esc_html( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?>		
											</option>								
										<?php }								
									}
								}
								?>
								</select>
								<?php 
								if ( ! empty( $post_types ) ) {
									foreach ( $post_types as $post_type ) {
										$post_details = get_post_type_object( $post_type );
										$cpt_post_ids = get_posts(array(
										    'fields'         => 'ids',
										    'posts_per_page' => -1,
										    'post_type'      => $post_type
										));										
										$post_list_class = "sa-hide";
									    if ( ! empty( $settings['enable_on_'.$post_type] ) ) {
											$post_list_class = "";
										}		
										?>
										<br>
										<label for="simple_alert_general_settings[enable_on_<?php echo $post_type; ?>]">
											<input name="simple_alert_general_settings[enable_on_<?php echo $post_type; ?>]" type="checkbox" class="sa-checkbox" value="1" <?php checked( $settings['enable_on_'.$post_type], '1' ); ?>/>
											<?php echo esc_html( $post_details->label ); ?>
										</label>
										<select name="simple_alert_general_settings[<?php echo $post_type; ?>][]" class="sa-selectize <?php echo $post_list_class; ?>" multiple>
										<?php
										if ( ! empty( $cpt_post_ids ) ) {
											foreach( $cpt_post_ids as $cpt_post_id ) {
												if ( ! empty( $settings[$post_type] ) ) {
													if ( in_array( $cpt_post_id, $settings[$post_type] ) ) { ?>
														<option value="<?php echo esc_html( $cpt_post_id ); ?>" <?php echo 'selected = selected'; ?>><?php echo get_the_title( $cpt_post_id ); ?></option>
													<?php } else { ?>	
														<option value="<?php echo esc_html( $page_id ); ?>"><?php echo get_the_title( $cpt_post_id ); ?>	
														</option>
												<?php } } else { ?>
													<option value="<?php echo esc_html( $cpt_post_id ); ?>">
														<?php echo get_the_title( $cpt_post_id ); ?>		
													</option>								
												<?php }								
											}
										}
										?>
										</select>
										<?php
									}
								}
								?>
							</fieldset>
																
							<p class="description">
								<?php esc_html_e( 'Add simple alert for pages, posts & custom post types.', 'simple-alert' ); ?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
</div>