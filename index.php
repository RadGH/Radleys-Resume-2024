<?php
// Radley Sustaire's resume
// Created 2024-02-20
// Last updated 2024-02-20

define( 'RESUME_PATH', __DIR__ );
define( 'RESUME_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/resume' );

require_once( RESUME_PATH . '/github.php' );

// Get the version based on the last modified date of the files
function get_version() {
	return max(
		filemtime( RESUME_PATH . '/index.php' ),
		filemtime( RESUME_PATH . '/content.php' ),
		filemtime( RESUME_PATH . '/assets/style.css' ),
		filemtime( RESUME_PATH . '/assets/structure.css' ),
		filemtime( RESUME_PATH . '/assets/print.css' ),
		filemtime( RESUME_PATH . '/assets/main.js' )
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
function get_employment() { return load_content( 'employment' ); }
function get_testimonials() { return load_content( 'testimonials' ); }
function get_projects() { return load_content( 'projects' ); }

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

function get_github_repos() {
	return GitHubAPI::load_repos();
}

function get_github_profile() {
	return GitHubAPI::load_profile();
}

function get_site_title() {
	return load_content('site_title');
}

function get_site_description() {
	return load_content('site_description');
}

function get_display_url( $url ) {
	return parse_url($url, PHP_URL_HOST);
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title><?php echo get_site_title(); ?></title>
	<meta name="description" content="<?php echo get_site_description(); ?>">
	<meta name="author" content="Radley Sustaire">
	
	<link rel="preconnect" href="//unpkg.com">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	
	<!-- Open Props: https://open-props.style/#getting-started -->
	<link rel="stylesheet" href="//unpkg.com/open-props"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/normalize.min.css"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/buttons.min.css"/>
	<!-- see PropPacks for the full list -->
	
	<!-- Font: Noto Sans -->
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<style>
		:root {
			--font-family--base: 'Noto Sans', sans-serif;
			--letter-spacing--base: 0.0125em;
		}
	</style>
	<!-- End Font -->
	
	<link href="<?php echo RESUME_URL . '/assets/structure.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/style.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/print.css?v=' . get_version(); ?>" rel="stylesheet" media="print" id="print-css">
	<link href="<?php echo RESUME_URL . '/assets/font-awesome/all.min.css'; ?>" rel="stylesheet">
	
	<script src="<?php echo RESUME_URL . '/assets/main.js?v=' . get_version(); ?>"></script>
	
	<!-- OG Image -->
	<meta property="og:url" content="<?php echo RESUME_URL; ?>">
	<meta property="og:title" content="<?php echo get_site_title(); ?>">
	<meta property="og:description" content="<?php echo get_site_description(); ?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?php echo RESUME_URL . '/assets/resume-open-graph-image.png'; ?>">
	<!-- End OG Image -->
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-3LR5M0YVTS"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-3LR5M0YVTS');
	</script>
	<!-- End Google tag -->
</head>

<body>
<nav class="main-nav">
	<div class="inside">
		<a href="#" class="nav-menu-toggle">
				
				<span class="show-if-menu-open">
					<i class="fas fa-times"></i>
					<span class="text">Close</span>
				</span>
			<span class="show-if-menu-closed">
					<i class="fas fa-bars"></i>
					<span class="text">Navigation</span>
				</span>
		</a>
		
		<ul class="nav-menu">
			<li><a href="#home">Home</a></li>
			<li><a href="#profile">Profile</a></li>
			<li><a href="#skills">Skills</a></li>
			<li><a href="#experience">Experience</a></li>
			<li><a href="#testimonials">Testimonials</a></li>
			<li><a href="#projects">Projects</a></li>
			<?php if ( get_github_profile() && get_github_repos() ) { ?>
				<li><a href="#github">GitHub</a></li>
			<?php } ?>
			<li><a href="#contact">Contact</a></li>
		</ul>
	</div>
</nav>

<div class="site">
	<header class="site-header" id="home">
		
		<div class="image">
			<img src="<?php echo RESUME_URL . get_image_url(); ?>" alt="Portrait photo of Radley">
		</div>
		
		<div class="title">
			<div class="heading">
				<h1><?php echo get_name(); ?></h1>
				<h2><?php echo get_job_title(); ?></h2>
			</div>
		</div>
		
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
		
		<div class="controls">
			<a href="#" class="print-mode-toggle btn">
				<span class="icon"><i class="fas fa-print"></i></span>
				<span class="print-text">Print</span>
			</a>
			
			<a href="#" class="color-mode-toggle btn">
				<span class="icon"><i class="fas fa-adjust"></i></span>
				<span class="show-if-dark">Dark</span>
				<span class="show-if-light">Light</span>
			</a>
		</div>
		
	</header>
	
	<main class="site-body">
	
		<div class="area left-area">
			
			<section class="section profile-section" id="profile">
				<div class="section-heading heading">
					<h2>Profile</h2>
				</div>
				
				<div class="section-content">
					<div class="content"><?php echo get_profile(); ?></div>
				</div>
			</section>
			
		</div>
		
		<div class="area right-area">
			
			<section class="section skills-section" id="skills">
				<div class="section-heading heading">
					<h2>Skills</h2>
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
			
		</div>
		
		<div class="area wide-area">
			
			<section class="section experience-section" id="experience">
				<div class="section-heading heading">
					<h2>Experience</h2>
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
								<div class="heading">
									<h3><?php echo $job_title; ?></h3>
									<?php if ( $company_name ) { ?>
										<h4 class="company"><?php echo $company_name; ?></h4>
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
			
			<section class="section testimonials-section" id="testimonials">
				<div class="section-heading heading">
					<h2>Testimonials</h2>
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
								
								<div class="heading">
									<h3 class="name"><?php echo $name; ?></h3>
									
									<?php if ( $company_name ) { ?>
										<h4 class="company"><?php echo $company_name; ?></h4>
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
			
			<section class="section projects-section" id="projects">
				<div class="section-heading heading">
					<h2>Projects</h2>
				</div>
				
				<div class="section-content">
					
					<ul class="project-list">
						<?php
						foreach( get_projects() as $e ) {
							$title = $e['title'];
							$url = $e['url'];
							$image_url = $e['image_url'];
							$description = $e['description'];
							$credits = $e['credits'];
							$years = years_since($e['date']);
							$years = _n('%d year', '%d years', $years);
							
							?>
							<li class="project">
								<?php if ( $image_url ) { ?>
									<div class="image"><img src="<?php echo RESUME_URL . '/' . $image_url; ?>" alt=""></div>
								<?php } ?>
								
								<div class="heading">
									<h3 class="name"><?php echo $title; ?></h3>
									
									<?php if ( $url ) { ?>
										<h4 class="company"><a href="<?php echo $url; ?>"><?php echo get_display_url($url); ?></a></h4>
									<?php } ?>
									
									<?php if ( $years ) { ?>
										<h4 class="year"><?php echo $years; ?> ago</h4>
									<?php } ?>
								</div>
								
								<?php if ( $description || $credits ) { ?>
									<div class="content">
									<?php if ( $description ) { ?>
										<div class="description">
											<p><?php echo $description; ?></p>
										</div>
									<?php } ?>
									
									<?php if ( $credits ) { ?>
										<div class="credits"><?php echo $credits; ?></div>
									<?php } ?>
									</div>
								<?php } ?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</section>
			
			<?php
			$profile = get_github_profile();
			$repos = get_github_repos();
			
			if ( $profile && $repos ) {
				$count = count($repos);
				?>
				<section class="section github-section" id="github">
					<div class="section-heading heading">
						<h2><i class="fab fa-github"></i> GitHub</h2>
					</div>
					
					<div class="section-content">
						
						<div class="content">
							<p>Here are some of my projects on GitHub. These are mostly WordPress plugins, with an occasional side project thrown in.</p>
						</div>
						
						<?php
						$login = '@' . $profile['login'];
						$name = $profile['name'];
						$avatar_url = $profile['avatar_url'];
						$profile_url = $profile['html_url'];
						$bio = $profile['bio'];
						$public_repos = $profile['public_repos'];
						$public_gists = $profile['public_gists'];
						$followers = $profile['followers'];
						
						$gists_url = $profile['gists_url'];
						$repos_url = $profile['repos_url'];
						$followers_url = $profile['followers_url'];
						
						/*
						?>
						<div class="github-profile">
							<div class="image">
								<img src="<?php echo $avatar_url; ?>" alt="">
								<span class="icon">
									<a href="<?php echo $profile_url; ?>"><i class="fab fa-github"></i></a>
								</span>
							</div>
							
							<div class="details">
								<div class="profile-name heading">
									<span class="h2 heading"><?php echo $name) ?> <small><?php echo $login; ?></small></span>
								</div>
								
								<?php if ( $bio ) { ?>
								<div class="content">
									<p><?php echo $bio; ?></p>
								</div>
								<?php } ?>
								
								<ul class="stats">
									<li><a href="<?php echo $profile_url; ?>" class="btn">View Profile</a></li>
									<li><a href="<?php echo $gists_url; ?>" class="btn btn-text"><i class="fad fa-book-spells"></i> <span class="value"><?php echo $public_repos; ?></span> <span class="label">Repositories</span></a></li>
									<li><a href="<?php echo $repos_url; ?>" class="btn btn-text"><i class="fad fa-edit"></i> <span class="value"><?php echo $public_gists; ?></span> <span class="label">Gists</span></a></li>
									<li><a href="<?php echo $followers_url; ?>" class="btn btn-text"><i class="fad fa-user-friends"></i> <span class="value"><?php echo $followers; ?></span> <span class="label">Followers</span></a></li>
								</ul>
								
							</div>
						</div>
						*/
						?>
						
						<div class="github-links">
							<ul class="stats">
								<li><a href="<?php echo $profile_url; ?>" class="btn">View Profile</a></li>
								<li><a href="<?php echo $gists_url; ?>" class="btn btn-text"><i class="fad fa-book-spells"></i> <span class="value"><?php echo $public_repos; ?></span> <span class="label">Repositories</span></a></li>
								<li><a href="<?php echo $repos_url; ?>" class="btn btn-text"><i class="fad fa-edit"></i> <span class="value"><?php echo $public_gists; ?></span> <span class="label">Gists</span></a></li>
								<li><a href="<?php echo $followers_url; ?>" class="btn btn-text"><i class="fad fa-user-friends"></i> <span class="value"><?php echo $followers; ?></span> <span class="label">Followers</span></a></li>
							</ul>
						</div>
						
						<ul class="github-list">
							<?php
							$i = 0;
							
							foreach( $repos as $r ) {
								$title        = $r['name'];
								$language     = $r['language'];
								$description  = $r['description'];
								$repo_url     = $r['html_url'];
								$stars        = $r['stargazers_count'];
								$created_at   = strtotime($r['created_at']);
								$updated_at   = strtotime($r['updated_at']);
								
								// Skip ones with empty description
								if ( empty($description) ) continue;
								
								$i += 1;
								
								$date_created = date( 'F Y', $created_at );
								$date_updated = date( 'F Y', $updated_at );
								
								// Convert hyphens into spaces in the title
								$title = ucwords( str_replace( '-', ' ', $title ) );
								$title = str_replace('Rs ', 'RS ', $title);
								$title = str_replace('Zm ', 'ZM ', $title);
								$title = str_replace('Aa ', 'AA ', $title);
								
								// Number of stars text
								$stars_text = '';
								if ( $stars === 1 ) $stars_text = '1 Star';
								else if ( $stars > 0 ) $stars_text = number_format($stars) . ' Stars';
								?>
								<li class="github-item">
									
									<div class="number"><?php echo $i; ?></div>
									
									<div class="heading">
										<h3 class="h2b heading"><a href="<?php echo $repo_url; ?>"><?php echo $title; ?></a></h3>
									</div>
									
									<?php if ( $description ) { ?>
									<div class="content">
										<p><?php echo $description; ?></p>
									</div>
									<?php } ?>
									
									<ul class="stats">
										<li><a href="<?php echo $repo_url; ?>" class="btn"><i class="fab fa-github"></i> Repository</a></li>
										<li><span class="btn-text"><i class="fad fa-calendar"></i> <span class="value"><?php echo $date_created; ?></span></li>
										<li><span class="btn-text"><i class="fad fa-code"></i> <span class="value"><?php echo $language; ?></span></li>
										<?php if ( $stars_text ) { ?>
										<li><span class="btn-text"><i class="fad fa-star"></i> <span class="value"><?php echo $stars_text; ?></span></li>
										<?php } ?>
									</ul>
									
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</section>
				<?php
			}
			?>
			
			<section class="section contact-section" id="contact">
				<div class="section-heading heading">
					<h2>Work with Radley</h2>
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