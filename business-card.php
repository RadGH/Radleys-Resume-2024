<?php
// Radley Sustaire's business card version using resume styling
// Created 2024-02-27
// Last updated 2024-02-27

require_once( __DIR__ . '/utility.php' );

require_once( __DIR__ . '/template/header.php' );
?>

<style>

.site {
}

.business-card {
}

</style>

<div class="site">
<div class="business-card">
	
	<header class="site-header" id="home">
		
		<div class="image">
			<img src="<?php echo RESUME_URL . get_image_url(); ?>" alt="Portrait photo of Radley">
		</div>
		
		<div class="title">
			<div class="heading">
				<h1><?php echo get_name(); ?></h1>
				<h2 class="h-regular"><?php echo get_job_title(); ?></h2>
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
	
	</header>


</div> <!-- / .business-card -->
</div> <!-- / .site -->

<?php
require_once( __DIR__ . '/template/footer.php' );