<?php
/**
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie.merland@gmail.com>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 */


/**
 * Media Widget.
 * 
 * Display a list of the Movies from a specific Media. Options: Title, Description,
 * Media type, Show as dropdown.
 * 
 * @since    1.0.0
 */
class WPML_Media_Widget extends WP_Widget {

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			'wpml-media-widget',
			__( 'WPML Media', 'wpmovielibrary' ),
			array(
				'classname'	=>	'wpml-media-widget',
				'description'	=>	__( 'Display Movies from a specific media', 'wpmovielibrary' )
			)
		);
	}

	/**
	 * Output the Widget content.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		// Caching
		$name = apply_filters( 'wpml_cache_name', 'media_widget' );
		$content = WPML_Cache::output( $name, function() use ( $args, $instance ) {

			return $this->widget_content( $args, $instance );
		});

		echo $content;
	}

	/**
	 * Generate the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	private function widget_content( $args, $instance ) {

		extract( $args, EXTR_SKIP );
		extract( $instance );

		$title = $before_title . apply_filters( 'widget_title', $title ) . $after_title;
		$description = esc_attr( $description );
		$type = esc_attr( $type );
		$list = ( 1 == $list ? true : false );
		$css = ( 1 == $css ? true : false );
		$thumbnails = ( 1 == $thumbnails ? true : false );
		$media_only = ( 1 == $media_only ? true : false );

		$html = '';

		if ( $media_only ) {

			$media = WPML_Settings::get_available_movie_media();
			$movies = WPML_Settings::wpml__movie_rewrite();
			$rewrite = WPML_Settings::wpml__details_rewrite();

			if ( ! empty( $media ) ) {

				$items = array();
				$style = 'wpml-widget wpml-media-list';

				if ( $css )
					$style = 'wpml-widget wpml-media-list wpml-list custom';

				foreach ( $media as $slug => $media_title ) {
					$_slug = ( $rewrite ? __( $slug, 'wpmovielibrary' ) : $slug );
					$items[] = array(
						'ID'          => $slug,
						'attr_title'  => sprintf( __( 'Permalink for &laquo; %s &raquo;', 'wpmovielibrary' ), esc_attr( $media_title ) ),
						'link'        => home_url( "/{$movies}/{$_slug}/" ),
						'title'       => esc_attr( $media_title ),
					);
				}

				$items = apply_filters( 'wpml_widget_media_lists', $items, $list, $css );
				$attributes = array( 'items' => $items, 'description' => $description, 'default_option' => __( 'Select a media', 'wpmovielibrary' ), 'style' => $style );

				if ( $list )
					$html = WPMovieLibrary::render_template( 'media-widget/media-dropdown-list.php', $attributes );
				else
					$html = WPMovieLibrary::render_template( 'media-widget/media-list.php', $attributes );
			}
			else
				$html = sprintf( '<em>%s</em>', __( 'Nothing to display.', 'wpmovielibrary' ) );
		}
		else {

			$movies = WPML_Movies::get_movies_from_media( $type );
			if ( ! empty( $movies ) ) {

				$items = array();
				$style = 'wpml-widget wpml-media-movies-list';

				if ( $thumbnails )
					$style = 'wpml-widget wpml-media-movies-list wpml-movies wpml-movies-with-thumbnail';

				foreach ( $movies as $movie )
					$items[] = array(
						'ID'          => $movie->ID,
						'attr_title'  => sprintf( __( 'Permalink for &laquo; %s &raquo;', 'wpmovielibrary' ), $movie->post_title ),
						'link'        => get_permalink( $movie->ID ),
						'title'       => $movie->post_title,
					);

				$items = apply_filters( 'wpml_widget_media_lists', $items, $list, $css );
				$attributes = array( 'items' => $items, 'description' => $description, 'style' => $style );

				if ( $thumbnails )
					$html = WPMovieLibrary::render_template( 'media-widget/movies-by-media.php', $attributes );
				else
					$html = WPMovieLibrary::render_template( 'media-widget/media-list.php', $attributes );

			}
			else {
				$html = WPMovieLibrary::render_template( 'empty.php' );
			}
		}

		return $before_widget . $title . $html . $after_widget;
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The new instance of values to be generated via the update.
	 * @param	array	old_instance	The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['list'] = intval( $new_instance['list'] );
		$instance['thumbnails'] = intval( $new_instance['thumbnails'] );
		$instance['css'] = intval( $new_instance['css'] );
		$instance['media_only'] = intval( $new_instance['media_only'] );
		//$instance['show_icons'] = intval( $new_instance['show_icons'] );

		$name = apply_filters( 'wpml_cache_name', 'media_widget' );
		WPML_Cache::delete( $name );

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance
		);

		$instance['title']       = ( isset( $instance['title'] ) ? $instance['title'] : __( 'Movie by Media', 'wpmovielibrary' ) );
		$instance['description'] = ( isset( $instance['description'] ) ? $instance['description'] : '' );
		$instance['type']        = ( isset( $instance['type'] ) ? $instance['type'] : null );
		$instance['list']        = ( isset( $instance['list'] ) ? $instance['list'] : 0 );
		$instance['thumbnails']  = ( isset( $instance['thumbnails'] ) ? $instance['thumbnails'] : 0 );
		$instance['css']         = ( isset( $instance['css'] ) ? $instance['css'] : 0 );
		$instance['media_only']  = ( isset( $instance['media_only'] ) ? $instance['media_only'] : 0 );
		//$show_icons = ( isset( $instance['show_icons'] ) ? $instance['show_icons'] : 0 );

		// Display the admin form
		echo WPMovieLibrary::render_template( 'media-widget/media-admin.php', array( 'widget' => $this, 'instance' => $instance ), $require = 'always' );
	}

}
