<?php
// Radley Sustaire's resume
// Created 2024-02-20
// Last updated 2024-02-20

define( 'RESUME_PATH', __DIR__ );
define( 'RESUME_URL', '/resume' );

// Get the version based on the last modified date of the files
function get_version() {
	return max(
		filemtime( RESUME_PATH . '/index.php' ),
		filemtime( RESUME_PATH . '/content.php' ),
		filemtime( RESUME_PATH . '/assets/style.css' ),
		filemtime( RESUME_PATH . '/assets/structure.css' ),
		filemtime( RESUME_PATH . '/assets/animations.css' )
	);
}

// Load content from a specific key from content.php
function load_content( $key ) {
	static $content = null;
	
	if ( $content === null ) {
		$content = require_once( RESUME_PATH . '/content.php' );
	}
	
	return $content[ $key ] ?? null;
}

// Load and format content
function load_formatted_content( $key ) {
	return get_formatted_content( load_content( $key ) );
}

// Apply shortcodes to a string for display
function get_formatted_content( $content ) {
	$dev_years = _n( '%d Year', '%d Years', years_since( get_dev_start_time() ) );
	$dev_years_tip = 'Developing websites since ' . get_year( get_dev_start_time() );
	
	$tags = array(
		'[dev_time]' => get_formatted_tooltip( $dev_years, $dev_years_tip ),
		'[dev_time_lower]' => get_formatted_tooltip( strtolower($dev_years), $dev_years_tip ),
		'[job_title]' => get_job_title(),
		'[job_title_lower]' => strtolower(get_job_title()),
	);
	
	return strtr( $content, $tags );
}

function get_name() { return load_content( 'name' ); }
function get_image_url() { return load_content( 'image_url' ); }
function get_job_title() { return load_content( 'job_title' ); }
function get_email() { return load_content( 'email' ); }
function get_links() { return load_content( 'links' ); }
function get_categories() { return load_content( 'categories' ); }
function get_skills() { return load_content( 'skills' ); }
function get_profile() { return load_formatted_content( 'profile' ); }
function get_hobbies() { return load_formatted_content( 'hobbies' ); }
function get_employment() { return load_content( 'employment' ); }
function get_testimonials() { return load_content( 'testimonials' ); }

function get_formatted_tooltip( $text, $tooltip ) {
	return '<a href="#" class="tooltip" title="' . $tooltip . '">' . $text . '</a>';
}

// Format as plural or singular and inserts the number as %1$d
function _n( $singular, $plural, $number ) {
	$str = $number === 1 ? $singular : $plural;
	return sprintf( $str, $number );
}

// Developer start year is based on the earliest skill date.
function get_dev_start_time() {
	$skills = get_skills();
	$times = array_map( function( $t ) {
		return $t['start'];
	}, $skills );
	return min( $times );
}

// Get the year from a timestamp
function get_year( $time ) {
	return date( 'Y', $time );
}

// Get the number of years since the given timestamp.
function years_since( $time, $precision = 0 ) {
	// 31556952 is the number of seconds in a year
	if ( $precision === 0 ) {
		return ceil( ( time() - $time ) / 31556952 );
	}else{
		return round( ( time() - $time ) / 31556952, $precision );
	}
}

// Separate a string into spans for each word
function split_spans( $str ) {
	if ( $str ) {
		$str = '<span>'. str_replace(' ', '</span> <span>', $str ) . '</span>';
	}
	return $str;
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title><?php echo get_name(); ?>'s Resume – <?php echo get_job_title(); ?></title>
	
	<!-- Open Props: https://open-props.style/#getting-started -->
	<link rel="stylesheet" href="//unpkg.com/open-props"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/normalize.min.css"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/buttons.min.css"/>
	<!-- see PropPacks for the full list -->
	
	<link href="<?php echo RESUME_URL . '/assets/structure.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/style.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/animations.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/font-awesome/all.min.css'; ?>" rel="stylesheet">
	
<?php include( RESUME_PATH . '/fonts/noto-sans.php' ); ?>
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-3LR5M0YVTS"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-3LR5M0YVTS');
	</script>
	<!-- End Google tag -->
	
	<script>
	document.addEventListener( 'DOMContentLoaded', function() {

		const HTML = document.documentElement;
		const BODY = document.body;
		
		// When changing color mode, change the HTML element "data-theme" attribute between "light" and "dark"
		function set_color_mode( dark = null ) {
			// Default to browser preference
			if ( dark === null ) dark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			HTML.setAttribute( 'data-theme', dark ? 'dark' : 'light' );
		}
		
		// Toggle between light and dark mode
		function toggle_color_mode() {
			set_color_mode( HTML.getAttribute('data-theme') !== 'dark' );
		}
		
		// When clicking ".tooltip", show the "title" in an alert
		document.body.addEventListener( 'click', function( e ) {
			if ( e.target.classList.contains( 'tooltip' ) ) {
				alert( e.target.title );
				e.preventDefault();
				e.stopPropagation();
			}
		});
		
		// When clicking ".color-mode-toggle", toggle the color mode
		document.querySelector( '.color-mode-toggle' ).addEventListener( 'click', function( e ) {
			toggle_color_mode();
			e.preventDefault();
		});
		
		// Set default color mode
		set_color_mode();
		
	});
	</script>
	
</head>

<body>
<div class="site">
	
	<div class="controls">
		<a href="#" class="color-mode-toggle btn">
			<span class="icon"><i class="fas fa-adjust"></i></span>
			<span class="show-if-dark">Dark</span>
			<span class="show-if-light">Light</span>
		</a>
	</div>

	<header class="site-header">
		
		<div class="image">
			<img src="<?php echo RESUME_URL . get_image_url(); ?>" alt="Portrait photo of Radley">
		</div>
		
		<div class="title">
			<div class="animated-heading">
				<h1 class="heading"><?php echo split_spans(get_name()); ?></h1>
				<h2 class="heading"><?php echo split_spans(get_job_title()); ?></h2>
			</div>
		</div>
		
		<div class="separator"></div>
		
		<div class="links">
			<ul class="link-list">
			<?php
			foreach( get_links() as $link ) {
				$icon = trim($link['icon_html']);
				if ( $icon ) $icon = '<span class="icon">' . $icon . '</span>';
				?>
				<li>
					<a href="<?php echo $link['url']; ?>"><?php echo $icon; ?><span class="text"><?php echo $link['label']; ?></span></a>
				</li>
				<?php
			}
			?>
			</ul>
		</div>
		
	</header>
	
	<main class="site-body">
	
		<div class="area left-area">
			<section class="section profile-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Profile</span></h2>
				</div>
				
				<div class="section-content">
					<div class="content"><?php echo get_profile(); ?></div>
				</div>
			</section>
			
			<section class="section skills-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Skills</span></h2>
				</div>
				
				<div class="section-content">
					<ul class="category-list">
						<?php
						foreach( get_categories() as $current_category ) {
							?>
							<li class="category">
								
								<span class="category-name"><?php echo $current_category; ?></span>
								
								<ul class="skill-list">
								<?php
								foreach( get_skills() as $t ) {
									$label = $t['title'];
									$start = $t['start'];
									$category = $t['category'];
									if ( $category !== $current_category ) continue;
									
									$years = years_since( $start );
									$years = _n('%d year', '%d years', $years);
									$tip = $label . ' experience since ' . date( 'Y', $start );
									$years_tooltip = get_formatted_tooltip( $years, $tip );
									?>
									<li class="skill"><?php echo $label; ?>: <?php echo $years_tooltip; ?></li>
									<?php
								}
								?>
								</ul>
								
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</section>
			
			<section class="section hobbies-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Hobbies</span></h2>
				</div>
				
				<div class="section-content">
					<div class="content"><?php echo get_hobbies(); ?></div>
				</div>
			</section>
		</div>
		
		<div class="area right-area">
			<section class="section experience-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Experience</span></h2>
				</div>
				
				<div class="section-content">
					<ul class="job-list">
						<?php
						foreach( get_employment() as $e ) {
							$company_name = $e['company_name'];
							$job_title = $e['job_title'];
							$start = $e['start'];
							$end = $e['end'];
							$description = $e['description'];
							
							$years = years_since( $start );
							$years = _n('%d year', '%d years', $years);
							$tip = 'From ' . date( 'Y', $start ) . ' to ' . ( $end ? date( 'Y', $end ) : 'Present' );
							$years_tooltip = get_formatted_tooltip( $years, $tip );
							?>
							<li class="job">
								<div class="animated-heading">
									<h3 class="heading"><?php echo split_spans($job_title); ?></h3>
									<?php if ( $company_name ) { ?>
										<h4 class="heading company"><?php echo split_spans($company_name); ?></h4>
									<?php } ?>
								</div>
								
								<div class="date"><?php echo date( 'Y', $start ); ?> - <?php echo $end ? date( 'Y', $end ) : 'Present'; ?></div>
									
								<?php if ( $description ) { ?>
								<div class="content">
									<?php echo $description; ?>
								</div>
								<?php } ?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</section>
		</div>
		
		<div class="area wide-area">
			<section class="section testimonials-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Testimonials</span></h2>
				</div>
				
				<div class="section-content">
					<ul class="testimonial-list">
						<?php
						foreach( get_testimonials() as $e ) {
							$name = $e['name'];
							$content = $e['content'];
							$company_name = $e['company_name'];
							$image = $e['image'];
							?>
							<li class="testimonial">
								<?php if ( $image ) { ?>
									<div class="image"><img src="<?php echo RESUME_URL . '/images/' . $image; ?>" alt=""></div>
								<?php } ?>
								
								<div class="animated-heading">
									<h3 class="heading name"><?php echo split_spans($name); ?></h3>
									
									<?php if ( $company_name ) { ?>
										<h4 class="heading company"><?php echo split_spans($company_name); ?></h4>
									<?php } ?>
								</div>
								
								<div class="content"><p><?php echo $content; ?></p></div>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</section>
			
			<section class="section footer-section">
				<div class="section-heading animated-heading">
					<h2 class="heading"><span>Work</span> <span>with</span> <span>Radley</span></h2>
				</div>
				
				<div class="section-content">
					<div class="content">
						<p>For inquiries, please email <a href="mailto:<?php echo get_email(); ?>"><?php echo get_email(); ?></a>. Thank you!</p>
					</div>
				</div>
			</section>
		</div>
		
	</main>
	
</div> <!-- / .site -->
</body>
</html>