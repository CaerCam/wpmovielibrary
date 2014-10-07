<?php
/**
 * WPMovieLibrary Dashboard Class extension.
 * 
 * Create a Help & Doc Widget.
 *
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie@caercam.org>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 */

if ( ! class_exists( 'WPMOLY_Dashboard_Helper_Widget' ) ) :

	class WPMOLY_Dashboard_Helper_Widget extends WPMOLY_Dashboard {

		/**
		 * Widget ID
		 * 
		 * @since    1.0
		 * 
		 * @var      string
		 */
		protected $widget_id = 'wpmoly_dashboard_helper_widget';

		/**
		 * Constructor
		 *
		 * @since   1.0.0
		 */
		public function __construct() {}

		/**
		 * The Widget content.
		 * 
		 * @since    1.0
		 */
		public function dashboard_widget() {

			$links = array();
			$list = array(
				'support' => array(
					'url'   => 'http://wordpress.org/support/plugin/wpmovielibrary',
					'title' => __( 'Support', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-help'
				),
				'report' => array(
					'url'   => 'https://github.com/wpmovielibrary/wpmovielibrary/issues/new',
					'title' => __( 'Report a bug', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-flag-alt'
				),
				'contribute' => array(
					'url'   => 'https://github.com/wpmovielibrary/wpmovielibrary',
					'title' => __( 'Contribute', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-wrench'
				),
				'donate' => array(
					'url'   => 'http://wpmovielibrary.com/contribute/#donate',
					'title' => __( 'Donate', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-heart'
				),
				'documentation' => array(
					'url'   => 'http://wpmovielibrary.com/documentation/',
					'title' => __( 'Documentation', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-doc'
				),
				'homepage' => array(
					'url'   => 'http://wpmovielibrary.com/',
					'title' => __( 'Official website', 'wpmovielibrary' ),
					'icon'  => 'wpmoly-icon wpmoly-icon-home'
				)
			);

			foreach ( $list as $slug => $data )
				$links[] = sprintf( '<li><a href="%s"><span class="%s"></span><span class="link">%s</span></a></li>', $data['url'], $data['icon'], $data['title'] );

			$links = implode( '', $links );

			echo self::render_admin_template( '/dashboard-help/help.php', array( 'links' => $links ) );
		}

		/**
		 * Widget's configuration callback
		 * 
		 * @since    1.0
		 * 
		 * @param    string    $context box context
		 * @param    mixed     $object gets passed to the box callback function as first parameter
		 */
		public function dashboard_widget_handle( $context, $object ) {}

	}

endif;