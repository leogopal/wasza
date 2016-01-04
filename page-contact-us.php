<?php /* Template Name: Contact */
get_header(); ?>
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript">
	(function($) {
		
		function render_map( $el ) {
		 
			// var
			var $markers = $el.find('.marker');
		 
			// vars
			var args = {
				zoom		: 16,
				center		: new google.maps.LatLng(0, 0),
				mapTypeId	: google.maps.MapTypeId.ROADMAP
			};
		 
			// create map	        	
			var map = new google.maps.Map( $el[0], args);
		 
			// add a markers reference
			map.markers = [];
		 
			// add markers
			$markers.each(function(){
		 
		    	add_marker( $(this), map );
		 
			});
		 
			// center map
			center_map( map );
		 
		}
		 
		/*
		*  add_marker
		*
		*  This function will add a marker to the selected Google Map
		*
		*  @type	function
		*  @date	8/11/2013
		*  @since	4.3.0
		*
		*  @param	$marker (jQuery element)
		*  @param	map (Google Map object)
		*  @return	n/a
		*/
		 
		function add_marker( $marker, map ) {
		 
			// var
			var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
		 
			// create marker
			var marker = new google.maps.Marker({
				position	: latlng,
				map			: map
			});
		 
			// add to array
			map.markers.push( marker );
		 
			// if marker contains HTML, add it to an infoWindow
			if( $marker.html() )
			{
				// create info window
				var infowindow = new google.maps.InfoWindow({
					content		: $marker.html()
				});
		 
				// show info window when marker is clicked
				google.maps.event.addListener(marker, 'click', function() {
		 
					infowindow.open( map, marker );
		 
				});
			}
		 
		}
		 
		/*
		*  center_map
		*
		*  This function will center the map, showing all markers attached to this map
		*
		*  @type	function
		*  @date	8/11/2013
		*  @since	4.3.0
		*
		*  @param	map (Google Map object)
		*  @return	n/a
		*/
		 
		function center_map( map ) {
		 
			// vars
			var bounds = new google.maps.LatLngBounds();
		 
			// loop through all markers and create bounds
			$.each( map.markers, function( i, marker ){
		 
				var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
		 
				bounds.extend( latlng );
		 
			});
		 
			// only 1 marker?
			if( map.markers.length == 1 )
			{
				// set center of map
			    map.setCenter( bounds.getCenter() );
			    map.setZoom( 16 );
			}
			else
			{
				// fit to bounds
				map.fitBounds( bounds );
			}
		 
		}
		 
		/*
		*  document ready
		*
		*  This function will render each map when the document is ready (page has loaded)
		*
		*  @type	function
		*  @date	8/11/2013
		*  @since	5.0.0
		*
		*  @param	n/a
		*  @return	n/a
		*/
		 
		$(document).ready(function(){
		 
			$('.gmap').each(function(){
		 
				render_map( $(this) );
		 
			});
		 
		});
		 
	})(jQuery);
	</script>
	

	<div id="content" class="container contactuspage">
		<div class="row">
			<div id="page" class="col-lg-9">
				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>

					<div id="contacttop">
						<div class="row content">
							<div class="contactdetails">
								<ul>
									<li class="contactemail"><span><img src="<?php echo bloginfo('template_directory'); ?>/images/contact-house.png" /></span> <a href="mailto:<?php the_field('email_address'); ?>"><?php the_field('email_address'); ?></a></li>
									<li class="contactphone"><span><img src="<?php echo bloginfo('template_directory'); ?>/images/contact-phone.png" /></span> <?php the_field('contact_number'); ?></li>
									<li class="contactaddy"><span><img src="<?php echo bloginfo('template_directory'); ?>/images/contact-email.png" /></span> <?php the_field('address'); ?></li>
								</ul>
							</div>
							
							<div class="contactform">
								<?php gravity_form(2, false, false, '', '', true, ''); ?>
							</div>
						</div>
			
						
						<div class="row content gmapwrap">
							<?php $location = get_field('google_map'); ?>
							<div class="gmap">
								<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
							</div>
						</div>
						
					</div><!-- contract top -->

				<?php endwhile; endif; ?>
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
