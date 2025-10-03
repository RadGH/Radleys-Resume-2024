<?php
// Radley Sustaire's resume
// Created 2024-02-20
// Last updated 2024-02-27

// If the site is accessed via "radgh.com", redirect to "radleysustaire.com"
if ( str_contains( $_SERVER['HTTP_HOST'], 'radgh.com' ) ) {
	header( 'Location: https://radleysustaire.com/', true, 301 );
	exit;
}

require_once( __DIR__ . '/utility.php' );

require_once( __DIR__ . '/template/header.php' );
?>

<div class="site">
	
	<header class="site-header" id="home">
		
		<div class="image">
			<img src="<?php echo RESUME_URL . get_image_url(); ?>" alt="Portrait photo of Radley">
		</div>
		
		<div class="details">
			<h1 class="header-title"><?php echo get_name(); ?></h1>
			
			<h2 class="header-subtitle h-regular"><?php echo get_job_title(); ?></h2>
		
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
			
			<div class="agency-list count-1">
				<div class="agency agency-zingmap">
					<a href="https://zingmap.com/" title="ZingMap" target="_blank">
						<span class="agency-title">Owner of <span class="screen-reader-text">ZingMap, LLC</span></span>
						<img src="<?php echo RESUME_URL . '/assets/logos/zingmap-2.png'; ?>" alt="ZingMap Logo">
					</a>
				</div>
			</div>
		</div>
	
	</header>
	
	<?php
	require_once( __DIR__ . '/template/main-nav.php' );
	?>
	
	<main class="site-body">
		
		<div class="area left-area">
			
			<section class="section profile-section" id="profile">
				<div class="section-heading heading">
					<h2>Resume &amp; Portfolio</h2>
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
					<div class="content">
						<?php
						foreach( get_categories() as $current_category ) {
							?>
							<h3><?php echo $current_category; ?></h3>
							
							<ul class="skill-list">
								<?php
								foreach( get_skills() as $t ) {
									$label = $t['title'];
									$start = $t['start'];
									$category = $t['category'];
									if ( $category !== $current_category ) continue;
									
									$years = years_since_n( $start );
									$tip = $label . ' experience since ' . date( 'Y', $start );
									$years_tooltip = get_formatted_tooltip( $years, $tip );
									?>
									<li class="skill">
										<span class="label"><?php echo $label; ?><span class="colon">:</span></span>
										<span class="years"><?php echo $years_tooltip; ?></span>
									</li>
									<?php
								}
								?>
							</ul>
							<?php
						}
						?>
					</div>
				</div>
			</section>
		
		</div>
		
		<div class="area wide-area">
			
			<section class="section projects-section" id="projects">
				<div class="section-heading heading">
					<h2>Projects (<span class="project-count"><?php echo count(get_projects()); ?></span>)</h2>
					
					<div class="section-tools hide-if-no-js">
						<div class="project-filters filter-group">
							<div class="filter-list">
								<span class="filter-label">Filter: </span>
								<a href="#projects" data-filter="*" class="filter">All</a>
								<?php
								foreach( get_project_tags() as $key => $e ) {
									if ( isset($e['hide_filter']) && $e['hide_filter'] ) continue;
									
									$slug = $key;
									$title = $e['title'];
									$description = $e['description'];
									?>
									<a href="#projects" data-filter="<?php echo esc_attr($slug); ?>" class="filter" title="<?php echo esc_attr($description); ?>"><?php echo esc_html($title); ?></a>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="section-content">
					
					<ul class="project-list list-cards">
						<?php
						foreach( get_projects() as $e ) {
							$title = $e['title'];
							$url = $e['url'] ?? false;
							$github_url = $e['github_url'] ?? false;
							$not_available_message = $e['not_available_message'] ?? 'No longer available';
							$image = $e['image'];
							$description = $e['description'];
							$credits = $e['credits'];
							// $years = years_since($e['date']);
							// $years = _n('%d year', '%d years', $years);
							$time_since = time_since($e['date']);
							$date_formatted = date( 'F Y', $e['date'] );
							$tags = $e['tags'];
							
							$image_url = $image ? RESUME_URL . '/' . $image : '';
							$image_path = $image ? RESUME_PATH . '/' . $image : '';
							$image_size = @getimagesize( $image_path );
							
							$classes = array('project');
							$classes[] = 'list-card-item';
							foreach( $tags as $tag ) $classes[] = 'tag-' . $tag;
							
							$atts = '';
							$atts .= 'alt="Screenshot of ' . $title . '" ';
							if ( $image_size && $image_size[0] > 0 && $image_size[1] > 0 ) {
								$atts .= 'width="'. $image_size[0] .'" ';
								$atts .= 'height="'. $image_size[1] .'" ';
							}
							?>
							<li class="<?php echo esc_attr(implode(' ', $classes)); ?>">
								<?php if ( $image ) { ?>
									<div class="image"><img src="<?php echo esc_attr($image_url); ?>" <?php echo trim($atts); ?>></div>
								<?php } ?>
								
								<div class="heading">
									<h3 class="h2b name"><?php echo $title; ?></h3>
									
									<?php
									/*
									if ( $url ) {
										?>
										<h4 class="company"><a href="<?php echo $url; ?>"><?php echo get_display_url($url); ?></a></h4>
										<?php
									}
									
									if ( $years ) {
										?>
										<h4 class="year"><?php echo $years; ?> ago</h4>
										<?php
									}
									*/
									?>
								</div>
								
								<?php if ( $description || $credits ) { ?>
									<div class="content">
										<?php if ( $description ) { ?>
											<div class="description">
												<p><?php echo $description; ?></p>
											</div>
										<?php } ?>
										
										<?php if ( $credits ) { ?>
											<div class="credits">
												<p><em><?php echo $credits; ?></em></p>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
								
								<ul class="stats stats-minor">
									<?php if ( $url ) { ?>
										<li><a href="<?php echo $url; ?>" class="btn" target="_blank">Visit Website</a></li>
									<?php } ?>
									
									<?php if ( $github_url ) { ?>
										<li><a href="<?php echo $github_url; ?>" class="btn btn-secondary" target="_blank"><i class="fab fa-github"></i> Repository</a></li>
									<?php } ?>
									
									<?php if ( ! $url && ! $github_url ) { ?>
										<li><a href="#" class="btn btn-disabled tooltip" title="<?php echo $not_available_message; ?>">Not Available</a></li>
									<?php } ?>
									
									<?php if ( $time_since ) { ?>
										<li><a class="btn btn-text btn-narrow tooltip" title="Created in <?php echo $date_formatted; ?>"><i class="far fa-calendar"></i> <?php echo $time_since; ?> ago</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</section>
			
			<section class="section plugins-section" id="plugins">
				<div class="section-heading heading">
					<h2>Plugins (<span class="plugin-count"><?php echo count(get_plugins()); ?></span>)</h2>
					
					<div class="section-tools hide-if-no-js">
						<div class="plugin-filters filter-group">
							<div class="filter-list">
								<span class="filter-label">Filter: </span>
								<a href="#plugins" data-filter="*" class="filter">All</a>
								<?php
								foreach( get_plugin_tags() as $key => $tag ) {
									if ( isset($tag['hide_filter']) && $tag['hide_filter'] ) continue;
									
									$slug = $tag['slug'];
									$title = $tag['name'];
									?>
									<a href="#plugins" data-filter="<?php echo esc_attr($slug); ?>" class="filter"><?php echo esc_html($title); ?></a>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="section-content">
					
					<ul class="plugin-list list-cards">
						<?php
						foreach( get_plugins() as $p ) {
							
							$title = $p['title']['rendered'];
							$url = $p['link'];
							$image_url = $p['zingmap_plugin']['featured_image_url'];
							$github_url = $p['zingmap_plugin']['github_url'];
							$description = $p['zingmap_plugin']['summary'] ?: $p['content']['rendered'];
							$date = $p['zingmap_plugin']['release_date'] ?: $p['date'];
							$tags = $p['zingmap_plugin']['tags'];
							
							if ( $date ) {
								$ts = strtotime( $date );
								$date_formatted = date( 'F Y', $ts );
								$time_since = time_since( $ts );
							}else{
								$date_formatted = '';
								$time_since = '';
							}
							
							$classes = array('plugin');
							$classes[] = 'list-card-item';
							foreach( $tags as $tag ) $classes[] = 'tag-' . $tag['slug'];
							
							$atts = '';
							$atts .= 'alt="Featured image for plugin ' . $title . '" ';
							?>
							<li class="<?php echo esc_attr(implode(' ', $classes)); ?>">
								<?php if ( $image_url ) { ?>
									<div class="image"><img src="<?php echo esc_attr($image_url); ?>" <?php echo trim($atts); ?>></div>
								<?php } ?>
								
								<div class="heading">
									<h3 class="h2b name"><?php echo $title; ?></h3>
								</div>
								
								<?php if ( $description ) { ?>
									<div class="content">
										<div class="description">
											<p><?php echo $description; ?></p>
										</div>
									</div>
								<?php } ?>
								
								<ul class="stats stats-minor">
									<?php if ( $url ) { ?>
										<li><a href="<?php echo $url; ?>" class="btn" target="_blank">Visit Website</a></li>
									<?php } ?>
									
									<?php if ( $github_url ) { ?>
										<li><a href="<?php echo $github_url; ?>" class="btn btn-secondary" target="_blank"><i class="fab fa-github"></i> Repository</a></li>
									<?php } ?>
									
									<?php if ( $time_since ) { ?>
										<li><a class="btn btn-text btn-narrow tooltip" title="Created in <?php echo $date_formatted; ?>"><i class="far fa-calendar"></i> <?php echo $time_since; ?> ago</a></li>
									<?php } ?>
								</ul>
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
										<h4 class="h-regular company"><?php echo $company_name; ?></h4>
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
			
			<?php
			$profile = get_github_profile();
			$repos = get_github_repos();
			
			if ( $profile && $repos ) {
				$count = count($repos);
				
				$login = '@' . $profile['login'];
				$name = $profile['name'];
				$avatar_url = $profile['avatar_url'];
				$profile_url = $profile['html_url'];
				$bio = $profile['bio'];
				$public_repos = $profile['public_repos'];
				$public_gists = $profile['public_gists'];
				$followers = $profile['followers'];
				
				$gists_url = 'https://gist.github.com/RadGH'; //$profile['gists_url'];
				$repos_url = 'https://github.com/RadGH?tab=repositories'; // $profile['repos_url'];
				$followers_url = 'https://github.com/RadGH?tab=followers'; // $profile['followers_url'];
				?>
				<section class="section github-section" id="github">
					<div class="section-heading heading">
						<h2><i class="fab fa-github"></i> GitHub</h2>
						
						<div class="section-tools">
							<div class="github-links">
								<ul class="stats">
									<li><a href="<?php echo $profile_url; ?>" target="_blank" class="btn">View Profile</a></li>
									<li><a href="<?php echo $repos_url; ?>" target="_blank" class="btn btn-text"><i class="fad fa-book-spells"></i> <span class="value"><?php echo $public_repos; ?></span> <span class="label">Repositories</span></a></li>
									<li><a href="<?php echo $gists_url; ?>" target="_blank" class="btn btn-text"><i class="fad fa-edit"></i> <span class="value"><?php echo $public_gists; ?></span> <span class="label">Gists</span></a></li>
									<li><a href="<?php echo $followers_url; ?>" target="_blank" class="btn btn-text"><i class="fad fa-user-friends"></i> <span class="value"><?php echo $followers; ?></span> <span class="label">Followers</span></a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<div class="section-content">
						
						<?php
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
						
						<ul class="github-list list-cards">
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
								
								// $date_created = date( 'F Y', $created_at );
								// $date_updated = date( 'F Y', $updated_at );
								
								$date_formatted = date( 'F j, Y', $created_at );
								$time_since = time_since( $created_at ) . ' ago';
								
								// Convert hyphens into spaces in the title
								$title = ucwords( str_replace( '-', ' ', $title ) );
								
								// Capitalize certain words
								foreach( array('rs', 'zm', 'aa', 'gf') as $word ) {
									$s = '/\b' . $word . '\b/i';
									$r = strtoupper($word);
									$title = preg_replace( $s, $r, $title );
								}
								
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
									
									<ul class="stats stats-minor">
										<li><a target="_blank" href="<?php echo $repo_url; ?>" class="btn btn-secondary"><i class="fab fa-github"></i> Repository</a></li>
										<li><a class="btn btn-text btn-narrow tooltip" title="Created <?php echo $date_formatted; ?>"><i class="far fa-calendar"></i> <span class="value"><?php echo $time_since; ?></span></a></li>
										<?php if ( $language ) { ?>
											<li><span class="btn-text btn-narrow"><i class="far fa-code"></i> <span class="value"><?php echo $language; ?></span></span></li>
										<?php } ?>
										<?php if ( $stars_text ) { ?>
											<li><span class="btn-text btn-narrow"><i class="fas fa-star"></i> <span class="value"><?php echo $stars_text; ?></span></span></li>
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
							
							$date_range = date( 'Y', $start ) . ' – ' . ($end ? date( 'Y', $end ) : 'Current');
							if ( date('Y', $start) === date('Y', $end) ) {
								$date_range = date( 'Y', $start );
							}
							?>
							<li class="job">
								<div class="heading">
									<h3 class="job-title"><?php echo $job_title; ?></h3>
									<?php if ( $company_name ) { ?>
										<h4 class="h-regular company"><?php echo $company_name; ?></h4>
									<?php } ?>
								</div>
								
								<div class="date"><?php echo $date_range; ?></div>
								
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

<?php
require_once( __DIR__ . '/template/footer.php' );