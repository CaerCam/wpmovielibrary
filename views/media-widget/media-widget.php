<?php
/**
 * Movies-by-Media Default Template
 * 
 * Display a list of movies links with thumbnails
 * 
 * @since    1.2.0
 * 
 * @uses    $items array of movies
 * @uses    $style container classes
 * @uses    $description Widget's description
 */
?>
	<div class="<?php echo $style ?>">

		<div class="wpml-widget-description"><?php echo $description ?></div>

		<ul class="wpml-widget-list">
<?php foreach ( $items as $item ) : ?>
			<li class="wpml-widget-list-item"><a href="<?php echo $item['link'] ?>" title="<?php echo $item['attr_title'] ?>"><?php echo $item['title'] ?></a></li>

<?php endforeach; ?>
		</ul>

	</div>