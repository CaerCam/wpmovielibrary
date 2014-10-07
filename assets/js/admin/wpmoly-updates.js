
$ = jQuery;

wpmoly = wpmoly || {};

	wpmoly.updates = wpmoly_updates = {

		_number: '#update-movies-count',
		__number: '#update-movies-count-text',
		_total: '#update-movies-total',
		__total: '#update-movies-total-text',
		_percent: '#update-movies-progressbar-text .value',
		_status: '#update-movies-progressbar-text .text',
		_progress: '#update-movies-progress'
	};

		wpmoly.updates.movies = wpmoly_update_movies = {};

			wpmoly.updates.movies.enqueue = function( id ) {

				var $link = $( '#queue-movie-' + id ),
				    $tr = $( 'tr#movie-' + id );

				$link.attr( 'onclick', 'wpmoly.updates.movies.dequeue( ' + id + ' ); return false;' );
				$link.find( '.wpmoly-icon' ).removeClass( 'wpmoly-icon-yes' ).addClass( 'wpmoly-icon-cancel' );
				$tr.toggleClass( 'active' );

				wpmoly_update_progress.update_total( $( '#deprecated-movies tr.active' ).length );

				
			};

			wpmoly.updates.movies.dequeue = function( id ) {

				var $link = $( '#queue-movie-' + id ),
				    $tr = $( 'tr#movie-' + id );

				$link.attr( 'onclick', 'wpmoly.updates.movies.enqueue( ' + id + ' ); return false;' );
				$link.find( '.wpmoly-icon' ).removeClass( 'wpmoly-icon-cancel' ).addClass( 'wpmoly-icon-yes' );
				$tr.toggleClass( 'active' );

				wpmoly_update_progress.update_total( $( '#deprecated-movies tr.active' ).length );
			};

			wpmoly.updates.movies.update = function( id ) {

				wpmoly._post({
					data: {
						action: 'wpmoly_update_movie',
						nonce: wpmoly.get_nonce( 'update-movie' ),
						movie_id: id
					},
					error: function( response ) {
						wpmoly_state.clear();
						$.each( response.responseJSON.errors, function() {
							wpmoly_state.set( this, 'error' );
						});
						$( '#update-movies-log' ).append( '<span class="wpmoly-icon wpmoly-icon-cancel"></span> Movie #' + id + ' « <em>' + $tr.find( '.movie-title' ).text() + '</em> » not updated' );
					},
					success: function( response ) {
						var $tr = $( 'tr#movie-' + id );

						$tr.find( '.wpmoly-icon-angle-right' ).removeClass( 'wpmoly-icon-angle-right' ).addClass( 'wpmoly-icon-yes' );
						$tr.find( '.update-movie, .queue-movie' ).remove();
						$( '#updated-movies' ).append( $tr );
						$( '#update-movies-log' ).append( '<span class="update-movies-log-entry"><span class="wpmoly-icon wpmoly-icon-yes"></span> Movie #' + id + ' « <em>' + $tr.find( '.movie-title' ).text() + '</em> » updated succesfully</span>' );
						$( '#update-movies-log' ).scrollTop( Math.round( $( '.update-movies-log-entry' ).last().position().top + $( '.update-movies-log-entry' ).last().height() ) );
					},
					complete: function( r ) {
						wpmoly.update_nonce( 'update-movie', r.responseJSON.nonce );
					}
				});
			};

			wpmoly.updates.movies.update_all = function() {

				var $movies = $( 'tr.active' );
				$.each( $movies, function() {

					var id = $( this ).prop( 'id' ).replace( 'movie-', '' );

					$( wpmoly_updates._status ).text( wpmoly_legacy.lang.updating );

					$.ajaxQueue({
						data: {
							action: 'wpmoly_update_movie',
							nonce: wpmoly.get_nonce( 'update-movie' ),
							movie_id: id
						},
						beforeSend: function() {},
						error: function( response ) {
							wpmoly_state.clear();
							$.each( response.responseJSON.errors, function() {
								wpmoly_state.set( this, 'error' );
							});
							$( '#update-movies-log' ).append( '<span class="wpmoly-icon wpmoly-icon-cancel"></span> ' + wpmoly_legacy.lang.movie.charAt( 0 ).toUpperCase() + wpmoly_legacy.lang.movie.slice( 1 ) + ' #' + id + ' « <em>' + $tr.find( '.movie-title' ).text() + '</em> » ' + wpmoly_legacy.lang.not_updated );
						},
						success: function( response ) {
							var $tr = $( 'tr#movie-' + id );

							$tr.find( '.wpmoly-icon-angle-right' ).removeClass( 'wpmoly-icon-angle-right' ).addClass( 'wpmoly-icon-yes' );
							$tr.find( '.update-movie, .queue-movie' ).remove();
							$( '#updated-movies' ).append( $tr );
							$( '#update-movies-log' ).append( '<span class="update-movies-log-entry"><span class="wpmoly-icon wpmoly-icon-yes"></span> ' + wpmoly_legacy.lang.movie.charAt( 0 ).toUpperCase() + wpmoly_legacy.lang.movie.slice( 1 ) + ' #' + id + ' « <em>' + $tr.find( '.movie-title' ).text() + '</em> » ' + wpmoly_legacy.lang.updated + '</span>' );
							$( '#update-movies-log' ).scrollTop( Math.round( $( '.update-movies-log-entry' ).last().position().top + $( '.update-movies-log-entry' ).last().height() ) );
						},
						complete: function() {
							wpmoly_update_progress.update_counter( $( '#updated-movies tr.active' ).length );
							if ( ! $( '#deprecated-movies .active' ).length )
								$( wpmoly_updates._status ).text( wpmoly_ajax.lang.done );
						}
					});
				} );
			};

		wpmoly.updates.progress = wpmoly_update_progress = {};

			wpmoly.updates.progress.update_counter = function( number ) {

				var total = $( wpmoly_updates._total ).text(),
				 progress = Math.round( ( number * 100 ) / total ) + '%';
				$( wpmoly_updates._number ).text( number );
				$( wpmoly_updates.__number ).text( ( 1 < number ? wpmoly_legacy.lang.movies_updated : wpmoly_legacy.lang.movie_updated ) );
				$( wpmoly_updates._percent ).text( progress );
				$( wpmoly_updates._progress ).animate( { width: progress }, 25 );
			};

			wpmoly.updates.progress.update_total = function( total ) {

				$( wpmoly_updates._total ).text( total );
				$( wpmoly_updates.__total ).text( ( 1 < total ? wpmoly_legacy.lang.x_selected : wpmoly_legacy.lang.selected ) );
			};
