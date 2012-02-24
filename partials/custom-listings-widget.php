<?php 

function custom_widget_html_filter ($listing_html, $listing_data) {
	
	ob_start();
    ?>
		<section class="listing-item">
			<h4>
				<a href="<?php echo $listing_data['cur_data']['url']; ?>"><?php echo $listing_data['location']['address'] ?></a>
			</h4>
			<section class="details">
			    <span class="bed"><?php echo $listing_data['cur_data']['beds']; ?> Beds</span>
			    <span class="bath"><?php echo $listing_data['cur_data']['baths'] ?> Baths</span>
			    <span class="area"><?php echo $listing_data['cur_data']['sqft'] ?></span>
			</section>
			<section class="featured-image">
				<?php if ( is_array($listing_data['images']) ): ?>
					<a href="<?php echo $listing_data['cur_data']['url'] ?>">
			  		<?php echo PLS_Image::load($listing_data['images'][0]['url'], array('resize' => array('w' => 280, 'h' => 170, 'method' => 'crop'), 'fancybox' => true)); ?>
					</a>
				<?php endif ?>
			</section>
			<a class="learn-more" href="<?php echo $listing_data['cur_data']['url'];?>">Learn More</a>
			<div class="clearfix"></div>
		</section>
     <?php
     $listing_html = ob_get_clean();
     return $listing_html;
}