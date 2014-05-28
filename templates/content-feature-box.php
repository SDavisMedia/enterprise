<?php
/**
 * feature box template
 */
?>

<?php if ( is_front_page() && 1 == get_theme_mod( 'enterprise_show_feature_box' ) ) : ?>	
	<div id="feature-box" class="feature-box inner site-element">
		<div class="feature-box-content">
			<div class="feature-box-visible">
				<?php if ( '' != get_theme_mod( 'enterprise_feature_box_headline' ) ) : ?>
					<h3><?php echo get_theme_mod( 'enterprise_feature_box_headline' ); ?></h3>
				<?php endif; ?>
				<?php if ( '' != get_theme_mod( 'enterprise_feature_box_content' ) ) : ?>
					<?php echo wpautop( get_theme_mod( 'enterprise_feature_box_content' ) ); ?>
				<?php endif; ?>
			</div>
			<?php if ( enterprise_fb_widgets() && '' != get_theme_mod( 'enterprise_feature_box_toggle' ) || 1 == get_theme_mod( 'enterprise_force_toggle' ) ) : ?>
				<span class="feature-box-toggle">
					<span><?php echo get_theme_mod( 'enterprise_feature_box_toggle', __( 'Learn More', 'enterprise' ) ); ?><i class="fa fa-caret-down"></i></span>
				</span>
			<?php endif; ?>
				<?php if ( enterprise_fb_widgets() ) : ?>
					<div class="feature-box-hidden">
						<?php if ( is_active_sidebar( 'feature-box-1' ) ) : ?>
							<div class="feature-box-widget-area fb-widget-1">
								<?php dynamic_sidebar( 'feature-box-1' ); ?>
							</div>
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'feature-box-2' ) ) : ?>
							<div class="feature-box-widget-area fb-widget-2">
								<?php dynamic_sidebar( 'feature-box-2' ); ?>
							</div>
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'feature-box-3' ) ) : ?>
							<div class="feature-box-widget-area fb-widget-3">
								<?php dynamic_sidebar( 'feature-box-3' ); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
		</div>
	</div>
<?php endif; ?>