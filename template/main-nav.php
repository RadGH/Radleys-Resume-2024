<nav class="main-nav">
	<a href="#" class="nav-menu-toggle show-if-mobile">
		<span class="show-if-menu-open">
			<i class="fas fa-times"></i>
			<span class="screen-reader-text">Close</span>
		</span>
		<span class="show-if-menu-closed">
			<i class="fas fa-bars"></i>
			<span class="screen-reader-text">Menu</span>
		</span>
		</span>
	</a>
	
	<ul class="nav-menu">
		<li><a href="#home" class="nav-section">Home</a></li>
		
		<li><a href="#profile" class="nav-section">Profile</a></li>
		
		<?php /* <li><a href="#skills">Skills</a></li> */ ?>
		
		<li><a href="#experience" class="nav-section">Experience</a></li>
		
		<li><a href="#testimonials" class="nav-section">Testimonials</a></li>
		
		<li><a href="#projects" class="nav-section">Projects</a></li>
		
		<?php
		$profile = get_github_profile();
		if ( $profile && get_github_repos() ) {
			// $public_repos = $profile['public_repos'];
			?>
			<li><a href="#github" class="nav-section">GitHub</a></li>
			<?php
		}
		?>
		
		<li><a href="#contact" class="nav-section">Contact</a></li>
		
		<li class="first-control-button">
			<a href="#" class="print-mode-toggle control-button">
				<span class="show-if-print" title="Exit print view">
					<i class="fas fa-times"></i>
					<span class="text">Cancel</span>
				</span>
				
				<span class="show-if-screen" title="Enable print view">
					<i class="fas fa-print"></i>
					<span class="text">Print</span>
				</span>
			</a>
		</li>
		<li>
			<a href="#" class="color-mode-toggle control-button">
				<span class="show-if-dark" title="Switch to Dark Mode">
					<i class="far fa-moon"></i>
					<span class="text">Dark</span>
				</span>
				<span class="show-if-light" title="Switch to Light Mode">
					<i class="far fa-sun" ></i>
					<span class="text">Light</span>
				</span>
			</a>
		</li>
	</ul>
</nav>