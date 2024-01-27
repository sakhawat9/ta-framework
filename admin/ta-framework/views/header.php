<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

	$demo    = get_option( 'taf_demo_mode', false );
	$text    = ( ! empty( $demo ) ) ? 'Deactivate' : 'Activate';
	$status  = ( ! empty( $demo ) ) ? 'deactivate' : 'activate';
	$class   = ( ! empty( $demo ) ) ? ' taf-warning-primary' : '';
	$section = ( ! empty( $_GET['section'] ) ) ? sanitize_text_field( wp_unslash( $_GET['section'] ) ) : 'about';
	$links   = array(
		'about'           => 'About',
		'quickstart'      => 'Quick Start',
		'documentation'   => 'Documentation',
		'free-vs-premium' => 'Free vs Premium',
		'support'         => 'Support',
		'relnotes'        => 'Release Notes',
	);

	?>
<div class="taf-welcome taf-welcome-wrap">

	<h1>Welcome to Codestar Framework v<?php echo esc_attr( TAF::$version ); ?></h1>

	<p class="taf-about-text">A Simple and Lightweight WordPress Option Framework for Themes and Plugins</p>

	<p class="taf-demo-button"><a href="<?php echo esc_url( add_query_arg( array( 'taf-demo' => $status ) ) ); ?>" class="button button-primary<?php echo esc_attr( $class ); ?>"><?php echo esc_attr( $text ); ?> Demo</a></p>

	<div class="taf-logo">
	<div class="taf--effects"><i></i><i></i><i></i><i></i></div>
	<div class="taf--wp-logos">
		<div class="taf--wp-logo"></div>
		<div class="taf--wp-plugin-logo"></div>
	</div>
	<div class="taf--text">Codestar Framework</div>
	<div class="taf--text taf--version">v<?php echo esc_attr( TAF::$version ); ?></div>
	</div>

	<h2 class="nav-tab-wrapper wp-clearfix">
	<?php

	foreach ( $links as $key => $link ) {

		if ( TAF::$premium && $key === 'free-vs-premium' ) {
			continue; }

		$activate = ( $section === $key ) ? ' nav-tab-active' : '';

		echo '<a href="' . esc_url(
			add_query_arg(
				array(
					'page'    => 'taf-welcome',
					'section' => $key,
				),
				admin_url( 'tools.php' )
			)
		) . '" class="nav-tab' . esc_attr( $activate ) . '">' . esc_attr( $link ) . '</a>';

	}

	?>
	</h2>
