
		<div id="wpml-details" class="wpml-details">

			<div id="minor-publishing">

				<div id="misc-publishing-actions">

					<div class="misc-pub-section">
						<span id="movie-status-icon"> <label for="movie_status"><?php _e( 'Status:', 'wpml' ); ?></label></span>
						<span id="movie-status-display"><?php echo $this->wpml_movie_details['movie_status']['options'][$movie_status]; ?></span>
						<a href="#movie_status" class="edit-movie-status hide-if-no-js"><?php _e( 'Edit', 'wpml' ); ?></a>

						<div id="movie-status-select" class="hide-if-js">
							<input type="hidden" name="hidden_movie_status" id="hidden_movie_status" value="<?php echo $movie_status; ?>">
							<select name="wpml_details[movie_status]" id="movie_status">
<?php foreach ( $this->wpml_movie_details['movie_status']['options'] as $slug => $status ) : ?>
								<option value="<?php echo $slug; ?>" <?php selected( $status, $movie_status ); ?>><?php echo $status; ?></option>
<?php endforeach; ?>
							</select>
							<a href="#movie_status" class="save-movie-status hide-if-no-js button"><?php _e( 'OK', 'wpml' ); ?></a>
							<a href="#movie_status" class="cancel-movie-status hide-if-no-js"><?php _e( 'Cancel', 'wpml' ); ?></a>
						</div>

					</div><!-- .misc-pub-section -->

					<div class="misc-pub-section">
						<span id="movie-media-icon"> <label for="movie_media"><?php _e( 'Media:', 'wpml' ); ?></label></span>
						<span id="movie-media-display"><?php echo $this->wpml_movie_details['movie_media']['options'][$movie_media]; ?></span>
						<a href="#movie_media" class="edit-movie-media hide-if-no-js"><?php _e( 'Edit', 'wpml' ); ?></a>

						<div id="movie-media-select" class="hide-if-js">
							<input type="hidden" name="hidden_movie_media" id="hidden_movie_media" value="<?php echo $movie_media; ?>">
							<select name="wpml_details[movie_media]" id="movie_media">
<?php foreach ( $this->wpml_movie_details['movie_media']['options'] as $slug => $media ) : ?>
								<option value="<?php echo $slug; ?>" <?php selected( $media, $movie_media ); ?>><?php echo $media; ?></option>
<?php endforeach; ?>
							</select>
							<a href="#movie_media" class="save-movie-media hide-if-no-js button"><?php _e( 'OK', 'wpml' ); ?></a>
							<a href="#movie_media" class="cancel-movie-media hide-if-no-js"><?php _e( 'Cancel', 'wpml' ); ?></a>
						</div>

					</div><!-- .misc-pub-section -->

					<div class="misc-pub-section">
						<label for="movie_rating"><?php _e( 'Rating:', 'wpml' ); ?></label>
						<div id="movie_rating_display" class="stars-<?php echo $movie_rating; ?>"></div>
						<a href="#movie_rating" class="edit-movie-rating hide-if-no-js"><?php _e( 'Edit', 'wpml' ); ?></a>

						<div id="movie-rating-select" class="hide-if-js">
							<input type="hidden" name="hidden_movie_rating" id="hidden_movie_rating" value="<?php echo $movie_rating; ?>">
							<input type="hidden" name="wpml_details[movie_rating]" id="movie_rating" value="<?php echo $movie_rating; ?>">
							<div id="stars">
								<div id="star-1" class="star<?php echo ( $movie_rating >= 1 ? ' s' : '' ); ?>"></div>
								<div id="star-2" class="star<?php echo ( $movie_rating >= 2 ? ' s' : '' ); ?>"></div>
								<div id="star-3" class="star<?php echo ( $movie_rating >= 3 ? ' s' : '' ); ?>"></div>
								<div id="star-4" class="star<?php echo ( $movie_rating >= 4 ? ' s' : '' ); ?>"></div>
								<div id="star-5" class="star<?php echo ( $movie_rating >= 5 ? ' s' : '' ); ?>"></div>
							</div>
							<a href="#movie_media" class="save-movie-rating hide-if-no-js button"><?php _e( 'OK', 'wpml' ); ?></a>
							<a href="#movie_media" class="cancel-movie-rating hide-if-no-js"><?php _e( 'Cancel', 'wpml' ); ?></a>
						</div>

					</div><!-- .misc-pub-section -->
				</div>
				<div class="clear"></div>
			</div>

			<div id="major-publishing-actions">
				<div id="publishing-action">
					<span class="spinner"></span>
					<input name="wpml_details_save" type="hidden" id="wpml_details_save" value="<?php _e( 'Save', 'wpml' ); ?>">
					<input type="button" name="wpml_save" id="wpml_save" class="button button-secondary button-large" value="<?php _e( 'Save', 'wpml' ); ?>" accesskey="s">
				</div>
				<div class="clear"></div>
			</div>
		</div>