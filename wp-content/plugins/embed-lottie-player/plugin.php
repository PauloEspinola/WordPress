<?php
/**
 * Plugin Name: Lottie Player - Block
 * Description: Lottie player for display lottie files.
 * Version: 1.1.4
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: lottie-player
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'LPB_PLUGIN_VERSION', isset( $_SERVER['HTTP_HOST'] ) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.1.4' );
define( 'LPB_DIR', plugin_dir_url( __FILE__ ) );
define( 'LPB_ASSETS_DIR', LPB_DIR . 'assets/' );

if( !function_exists( 'lpb_init' ) ) {
	function lpb_init() {
		global $lpb_bs;
		require_once( plugin_dir_path( __FILE__ ) . 'bplugins_sdk/init.php' );
		$lpb_bs = new BPlugins_SDK( __FILE__ );
	}
	lpb_init();
}else {
	global $lpb_bs;
	$lpb_bs->uninstall_plugin( __FILE__ );
}

class LPBLottiePlayer{
	function __construct(){
		add_action( 'init', [$this, 'onInit'] );
		add_action( 'admin_enqueue_scripts', [$this, 'adminEnqueueScripts'] );
		add_action( 'enqueue_block_assets', [$this, 'enqueueBlockAssets'] );
		register_activation_hook( __FILE__, [$this, 'onPluginActivate'] );

		if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
			add_filter( 'block_categories', [$this, 'blockCategories'] );
		} else { add_filter( 'block_categories_all', [$this, 'blockCategories'] ); }

		add_filter( 'upload_mimes', [$this, 'uploadMimes'] );
		if ( version_compare( $GLOBALS['wp_version'], '5.1' ) >= 0 ) {
			add_filter( 'wp_check_filetype_and_ext', [$this, 'wpCheckFileTypeAndExt'], 10, 5 );
		} else { add_filter( 'wp_check_filetype_and_ext', [$this, 'wpCheckFileTypeAndExt'], 10, 4 ); }
	}

	function onPluginActivate(){
		if ( is_plugin_active( 'lottie-player-pro/plugin.php' ) ){
			deactivate_plugins( 'lottie-player-pro/plugin.php' );
		}
	}

	// function hasReusableBlock( $blockName ){
	// 	if( get_the_ID() ){
	// 		if ( has_block( 'block', get_the_ID() ) ){
	// 			// Check reusable blocks
	// 			$content = get_post_field( 'post_content', get_the_ID() );
	// 			$blocks = parse_blocks( $content );
	
	// 			if ( !is_array( $blocks ) || empty( $blocks ) ) {
	// 				return false;
	// 			}
	
	// 			foreach ( $blocks as $block ) {
	// 				if ( $block['blockName'] === 'core/block' && ! empty( $block['attrs']['ref'] ) ) {
	// 					if( has_block( $blockName, $block['attrs']['ref'] ) ){
	// 					 	return true;
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}
	// 	return false;
	// }

	function blockCategories( $categories ){
		return array_merge( [[
			'slug'	=> 'LPBlock',
			'title'	=> 'Lottie Player Block',
		] ], $categories );
	} // Categories

	function adminEnqueueScripts( $hook ){
		if( 'edit.php' === $hook || 'post.php' === $hook ){
			wp_enqueue_style( 'lpbAdmin', LPB_ASSETS_DIR . 'css/admin.css', [], LPB_PLUGIN_VERSION );
			wp_enqueue_script( 'lpbAdmin', LPB_ASSETS_DIR . 'js/admin.js', [ 'wp-i18n' ], LPB_PLUGIN_VERSION, true );
		}
	}

	function enqueueBlockAssets(){
		// if ( is_admin() || $this->hasReusableBlock( 'lpb/lottie-player' ) || has_block( 'lpb/lottie-player', get_the_ID() ) ){
		wp_register_script( 'dotLottiePlayer', LPB_ASSETS_DIR . 'js/dotlottie-player.js', [], '1.5.7', true );
		wp_register_script( 'lottieInteractivity', LPB_ASSETS_DIR . 'js/lottie-interactivity.min.js', [ 'dotLottiePlayer' ], '1.5.2', true );
		// }

		// if( !is_admin() && !$this->hasReusableBlock( 'lpb/lottie-player' ) || !has_block( 'lpb/lottie-player', get_the_ID() ) ){
		// 	wp_dequeue_script('lpb-lottie-player-script');
		// }
	}

	function onInit() {
		wp_register_style( 'lpb-lottie-player-style', plugins_url( 'dist/style.css', __FILE__ ), [], LPB_PLUGIN_VERSION ); // Style
		wp_register_style( 'lpb-lottie-player-editor-style', plugins_url( 'dist/editor.css', __FILE__ ), [ 'lpb-lottie-player-style' ], LPB_PLUGIN_VERSION ); // Backend Style

		register_block_type( __DIR__, [
			'editor_style'		=> 'lpb-lottie-player-editor-style',
			'style'				=> 'lpb-lottie-player-style',
			'render_callback'	=> [$this, 'render']
		] ); // Register Block

		wp_set_script_translations( 'lpb-lottie-player-editor-script', 'lottie-player', plugin_dir_path( __FILE__ ) . 'languages' );
	}

	function render( $attributes ){
		extract( $attributes );
		global $lpb_bs;

		wp_set_script_translations( 'lpb-lottie-player-script', 'lottie-player', plugin_dir_path( __FILE__ ) . 'languages' );

		$className = $className ?? '';
		$extraClass = $lpb_bs->can_use_premium_feature() ? 'premium' : 'free';
		$blockClassName = "wp-block-lpb-lottie-player $extraClass $className align$align";

		ob_start(); ?>
		<div class='<?php echo esc_attr( $blockClassName ); ?>' id='lpbLottiePlayer-<?php echo esc_attr( $cId ); ?>' data-attributes='<?php echo esc_attr( wp_json_encode( $attributes ) ); ?>'></div>

		<?php return ob_get_clean();
	} // Render

	//Allow some additional file types for upload
	function uploadMimes( $mimes ) {
		// New allowed mime types.
		$mimes['json'] = 'application/json';
		$mimes['lottie'] = 'application/json';
		return $mimes;
	}
	function wpCheckFileTypeAndExt( $data, $file, $filename, $mimes, $real_mime = null ){
		// If file extension is 2 or more 
		$f_sp = explode( '.', $filename );
		$f_exp_count = count( $f_sp );

		if( $f_exp_count <= 1 ){
			return $data;
		}else{
			$f_name = $f_sp[0];
			$ext = $f_sp[$f_exp_count - 1];
		}

		if( $ext == 'json' || $ext === 'lottie' ){
			$type = 'application/json';
			$proper_filename = '';
			return compact('ext', 'type', 'proper_filename');
		}else {
			return $data;
		}
	}
}
new LPBLottiePlayer;

// Require files
global $lpb_bs;
if( $lpb_bs ){
	if( $lpb_bs->can_use_premium_feature() ){
		require_once plugin_dir_path( __FILE__ ) . 'inc/CustomPost.php';
	}
}