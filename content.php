<?php

return array(
	
	// Profile
	'name' => 'Radley Sustaire',
	'email' => 'radleygh@gmail.com',
	'image_url' => '/assets/radley-sustaire.jpg',
	'job_title' => 'WordPress Developer',
	
	'site_title' => 'Radley Sustaire\'s WordPress Developer Resume',
	'site_description' => 'WordPress Developer with 18 years of experience building themes and plugins, hosting websites, and managing servers.',
	
	// Links
	'links' => array(
		array(
			'title' => 'Location',
			'label' => 'Veneta, OR',
			'url' => 'https://www.google.com/maps/place/Veneta,+OR+97487',
			'icon_html' => '<i class="fad fa-map-marker-alt"></i>',
		),
		array(
			'title' => 'Email',
			'label' => 'radleygh@gmail.com',
			'url' => 'mailto:radleygh@gmail.com',
			'icon_html' => '<i class="fad fa-envelope-open-text"></i>',
		),
		/*
		array(
			'title' => 'Phone',
			'label' => '+1 (541) 513-8145',
			'url' => 'tel:1-541-513-8145',
			'icon_html' => '<i class="fad fa-phone-alt"></i>',
		),
		*/
		/*
		array(
			'title' => 'Website',
			'label' => 'radleysustaire.com',
			'url' => 'https://radleysustaire.com/',
			'icon_html' => '<i class="fad fa-globe"></i>',
		),
		*/
		array(
			'title' => 'Github',
			'label' => 'github.com/RadGH',
			'url' => 'https://github.com/RadGH/',
			'icon_html' => '
  <span class="fa-stack fa-1x">
    <i class="fas fa-circle fa-stack-1x fa-secondary"></i>
    <i class="fab fa-github fa-stack-1x fa-primary"></i>
  </span>',
		),
	),
	
	// Skills
	'categories' => array(
		'Front-End',
		'Back-End',
		'Design',
	),
	
	'skills' => array(
		array(
			'title' => 'HTML/CSS',
			'start' => strtotime('2007-01-01'),
			'category' => 'Front-End',
		),
		array(
			'title' => 'PHP',
			'start' => strtotime('2008-01-01'),
			'category' => 'Back-End',
		),
		array(
			'title' => 'MySQL',
			'start' => strtotime('2008-01-01'),
			'category' => 'Back-End',
		),
		array(
			'title' => 'JavaScript',
			'start' => strtotime('2010-01-01'),
			'category' => 'Front-End',
		),
		array(
			'title' => 'Photoshop',
			'start' => strtotime('2011-01-01'),
			'category' => 'Design',
		),
		array(
			'title' => 'WordPress',
			'start' => strtotime('2012-01-01'),
			'category' => 'Back-End',
		),
		array(
			'title' => 'Git',
			'start' => strtotime('2014-01-01'),
			'category' => 'Back-End',
		),
		array(
			'title' => 'Unix/SSH',
			'start' => strtotime('2016-01-01'),
			'category' => 'backend',
		),
		array(
			'title' => 'SCSS',
			'start' => strtotime('2017-01-01'),
			'category' => 'Front-End',
		),
		array(
			'title' => 'Illustrator/Inkscape',
			'start' => strtotime('2017-01-01'),
			'category' => 'Design',
		),
		array(
			'title' => 'Figma',
			'start' => strtotime('2022-01-01'),
			'category' => 'Design',
		),
	),
	
	
	// Content areas
	'profile' => '
		<p>I\'m a <strong>[job_title]</strong> with [dev_time_lower] of experience in web development. I\'m proficient with may design and
		development tools, and capable of managing Unix servers.</p>
		<p>My day-to-day work involves maintaining hosted websites for clients, developing custom themes and plugins, and
		optimizing websites for speed and performance.</p>
		<div class="heading"><h3>Preferred Software</h3></div>
		<p>Most of my projects are built with PHPStorm using Git. My AI tool of choice is GitHub Copilot. For design I prefer using Figma for layout,
		Photoshop for graphic design, and Inkscape for vector graphics.</p>
		<div class="heading"><h3>WordPress Specialist</h3></div>
		<p>I have focused <em>exclusively</em> on WordPress development since 2017. Recently I\'ve been working with Full Site Editor and the block themes.</p>
		<div class="heading"><h3>Hobbies</h3></div>
		<p>I enjoy painting with acrylics and oils, riding my road bike, and playing all kinds of games. My favorite game is Dungeons &amp; Dragons where I prefer a spell-casting Wizard or Cleric, unless I\'m the DM.</p>
		',
	
	'hobbies' => '
	',
	
	
	// Employment History
	'employment' => array(
		array(
			'job_title' => 'Front-End Developer and Support Specialist',
			'company_name' => 'Alchemy + Aim',
			'start' => strtotime('2017-09-01'),
			'end' => null,
			'description' => '
				<ul>
					<li>Complete custom WordPress builds from a design PSD.</li>
					<li>Coordinating with team members, designers and clients.</li>
					<li>Offering customer support through an email ticketing system, and occasional phone/online meetings.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'WordPress Developer',
			'company_name' => 'ZingMap, LLC',
			'start' => strtotime('2017-07-01'),
			'end' => null,
			'description' => '
				<ul>
					<li>Sourcing clients, discussing needs, writing estimates and proposals.</li>
					<li>Web development, hosting, and related services.</li>
					<li>Developing websites with custom themes, custom plugins, analytics, SEO, and so on.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'Lead WordPress Developer',
			'company_name' => 'Limelight Department, Inc.',
			'start' => strtotime('2012-01-01'),
			'end' => strtotime('2017-01-01'),
			'description' => '
				<ul>
					<li>Coached and led a team of in-house and remote developers.</li>
					<li>Delegated projects to other developers based on skill levels and workload.</li>
					<li>Maintained 5 separate web servers, containing more than 80 active websites.</li>
					<li>Built, tested, and deployed various completed websites with custom themes and plugins.</li>
					<li>Optimized two different websites each with over 1+ million monthly visitors, improving stability and loading speed immensely.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'Freelance WordPress Developer',
			'company_name' => 'Bridge Town Home Buyers, LLC',
			'start' => strtotime('2016-01-01'),
			'end' => strtotime('2016-12-31'),
			'description' => '
				<ul>
					<li>Rebuilt website using WordPress, reevaluated and modified all pages for improved usability and SEO.</li>
					<li>Custom WordPress plugin for a listing of properties.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'Freelance WordPress Developer',
			'company_name' => 'CaseSwap',
			'start' => strtotime('2015-01-01'),
			'end' => strtotime('2015-12-31'),
			'description' => '
				<ul>
					<li>Built a custom WordPress plugin with membership integration allowing paid users to be notified of case submissions.</li>
					<li>Integrated contact forms with membership system, notifying users based on their city/state.</li>
					<li>Set up Mandrill to distribute emails from the plugin\'s notifications.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'Web Developer',
			'company_name' => 'Goliath Creative',
			'start' => strtotime('2011-01-01'),
			'end' => strtotime('2015-12-31'),
			'description' => '
				<ul>
					<li>Built a horizontal scrolling restaurant website, with strict browser support requirements.</li>
					<li>Created numerous website templates from PSD\'s and PDF\'s, for use in a custom CMS.</li>
					<li>Added mobile version of websites using jQuery Mobile, and later using responsive design techniques.</li>
				</ul>
			',
		),
		array(
			'job_title' => 'Freelance WordPress Developer',
			'company_name' => 'oDesk',
			'start' => strtotime('2007-01-01'),
			'end' => strtotime('2011-12-31'),
			'description' => '
				<ul>
					<li>Worked with a variety of clients on many web development projects, big and small.</li>
					<li>Performed IT work, including Windows tutoring and building automation software.</li>
				</ul>
			',
		),
	),
		
	// Testimonials
	'testimonials' => array(
		array(
			'content' => 'Radley embodies the best of a partner in development. He really knows his way around databases, WordPress, and has a good design sense to boot. Radley intuits solutions to problems, both anticipated and unexpected. He is patient and more than willing to debug problems that arise. His communication skills are excellent.',
			'name' => 'Erik Contzius',
			'company_name' => 'Women Cantors\'s Network',
			'image' => 'erik.jpg',
		),
		array(
			'content' => 'Radley took my ideas and ran with them -- the end result is a solution that does more than I originally planned and I couldn\'t be more thrilled! He was prompt in replying to my messages and I was provided with detailed updates along the way. If you\'re looking for a developer, Radley really knows his stuff. Stop scrolling and send him a message now, you won\'t regret it. Thank you Radley!',
			'name' => 'Jamie Stephens',
			'company_name' => 'Brantford Experts',
			'location' => 'Ontario, Canada',
			'image' => 'jamie.jpg',
		),
		array(
			'content' => 'Radley rescued SPOT\'s sorely neglected and out of date website and transformed it into a wonderful new public face in an amazingly short time! He added video, streamlined every section of the site and added a much needed on-line application option for our clients. His excellent suggestions and creative genius throughout the site have increased our traffic and accessibility tremendously. He is extremely professional and pleasant to work with (really listening carefully and patiently explaining all the steps he was taking to our team of non-techies). We will definitely use his services again and would highly recommend his technical talent and business acumen!',
			'name' => 'Joey Curtin',
			'company_name' => 'Stop Pet Overpopulation Today',
			'location' => 'Eugene, OR',
			'image' => 'joey.jpg',
		),
		array(
			'content' => 'I worked with Radley for about five years in the agency world. My business partner and I hired Radley when he was a brand-new developer; inexperienced, but bright, eager, and motivated. In a very short amount of time, Radley grew into a brilliant developer and became our agency\'s lead developer. He and I worked in-tandem on dozens of websites over the years. He has qualities that are vital to successful programming. Firstly, he takes great personal pride in his work. His personal expectations of quality exceed that of those around him, and that makes his work superb. Radley is also a creative problem solver. We often joked that "if a client can dream it, Radley can build it". And finally, Radley\'s greatest luxury is his ability to articulate complex concepts both in "programmer-speak", and layman\'s terms. I\'ve had Radley write summaries for clients, where his layman\'s term verbiage is so eloquent that I just copy and paste it to my client. For those of you familiar with web developers, you know this is extremely rare. He\'s the ultimate 5-tool player, and you should certainly hire him.',
			'name' => 'Zack P.',
			'company_name' => '',
			'location' => 'Portland, OR',
			'image' => 'zack.jpg',
		),
		array(
			'content' => 'Radley is an absolute pleasure to work with. He\'s professional, organized, and efficient. The thing I looked most about working with him is his communication. He explains things thoroughly and succinctly. He\'s an all-around outstanding contractor.',
			'name' => 'Jeff H.',
			'company_name' => '',
			'location' => '',
			'image' => 'jeff.jpg',
		),
		array(
			'content' => 'Radley is a great developer. He is very knowledgeable and has a great eye for design. He is very easy to work with and is always willing to go the extra mile to make sure the project is done right. I would highly recommend him to anyone looking for a great developer.',
			'name' => 'Shannon McAlister',
			'company_name' => 'PDX Homeowners',
			'location' => 'Portland, OR',
			'image' => 'shannon.jpg',
		),
	),
	
	
	'projects' => array(
		array(
			'title' => 'Concealed Nation',
			'date' => strtotime('2020-01-01'),
			'url' => 'https://concealednation.org/',
			'image_url' => '/assets/websites/concealed-nation-2.png',
			'description' => 'Complete website rebuild optimized for thousands of concurrent visitors. Consolidated dozens of plugins into a small list of essentials.',
			'credits' => '<p>Designed and built by Radley.</p>',
		),
		array(
			'title' => 'Peg Rodrigues',
			'date' => strtotime('2018-01-01'),
			'url' => 'https://pegrodrigues.com/',
			'image_url' => '/assets/websites/peg-rodrigues.png',
			'description' => 'Built for Alchemy + Aim, designed by Rachel Pesso.',
			'credits' => '<p><em>Built for <a href="https://alchemyandaim.com/" target="_blank">Alchemy + Aim</a>, designed by
<a href="https://rachelpesso.com/" target="_blank">Rachel Pesso</a>.</em></p>',
		),
		array(
			'title' => 'Kruggsmash',
			'date' => strtotime('2018-01-01'),
			'url' => 'https://kruggsmash.com/',
			'image_url' => '/assets/websites/kruggsmash-2.png',
			'description' => 'This website was donated to Kruggsmash. He\'s one of my favorite YouTubers and makes excellent Dwarf Fortress videos.',
			'credits' => '<p>Designed and built by Radley.</p>',
		),
		array(
			'title' => 'ZingMap',
			'date' => strtotime('2017-01-01'),
			'url' => 'https://zingmap.com/',
			'image_url' => '/assets/websites/zingmap.png',
			'description' => 'Radley\'s hosting company website.',
			'credits' => '<p>Designed and built by Radley.</p>',
		),
		array(
			'title' => 'Tracy O\'Malley',
			'date' => strtotime('2017-01-01'),
			'url' => 'http://tracyomalley.com/',
			'image_url' => '/assets/websites/tracy-omalley.png',
			'description' => 'Website for Peg Rodrigues work and travel website.',
			'credits' => '<p><em>Built for <a href="https://alchemyandaim.com/" target="_blank">Alchemy + Aim</a>, designed by
<a href="https://rachelpesso.com/" target="_blank">Rachel Pesso</a>.</em></p>',
		),
		array(
			'title' => 'Steelhead Brewing Company',
			'date' => strtotime('2016-01-01'),
			'url' => 'https://steelheadbrewery.com/',
			'image_url' => '/assets/websites/steelhead.png',
			'description' => 'Beer list and restaurant menu with two locations to choose from.',
			'credits' => '<p><em>Built for Limelight Department.</em></p>',
		),
		array(
			'title' => 'The Adrienne St Clair Group',
			'date' => strtotime('2015-01-01'),
			'url' => 'https://www.thestclairs.com/',
			'image_url' => '/assets/websites/st-clairs.png',
			'description' => 'Property locator plugin (iHomeFinder), Unique day/night theme, Animated front page.',
			'credits' => '<p><em>Built for Limelight Department.</em></p>',
		),
		array(
			'title' => 'Fight Club 2: Project Mayhem (Dark Horse Comics)',
			'date' => strtotime('2015-01-01'),
			'url' => 'https://joinprojectmayhem.com/',
			'image_url' => '/assets/websites/project-mayhem.png',
			'description' => 'Custom map-style interface. Many animations. Contribute & Sightings section managed by custom post types. User submitted content.',
			'credits' => '<p><em>Built for Limelight Department.</em></p>',
		),
		array(
			'title' => 'Willamalane Parks & Recreation District',
			'date' => strtotime('2014-01-01'),
			'url' => 'http://willamalane.org/',
			'image_url' => '/assets/websites/willamalane.png',
			'description' => 'Custom map locators for Parks, Facilities, and Bird trails. Custom post type for taking classes. Advanced navigation and mobile menus. ADA Section 503c Compliance.',
			'credits' => '<p><em>Built for <a href="https://alchemyandaim.com/" target="_blank">Alchemy + Aim</a>, designed by
<a href="https://rachelpesso.com/" target="_blank">Rachel Pesso</a>.</em></p>',
		),
		array(
			'title' => 'Bowtech Archery',
			'date' => strtotime('2014-01-01'),
			'url' => 'https://bowtecharchery.com/',
			'image_url' => '/assets/websites/bowtech.png',
			'description' => 'International brand of hunting bows. Custom bow sorting and comparison utility. Store locator with API.',
			'credits' => '<p><em>Built for Limelight Department.</em></p>',
		),
		array(
			'title' => 'Gorilla Capital',
			'date' => strtotime('2013-01-01'),
			'url' => 'https://gorillacapital.com/',
			'image_url' => '/assets/websites/gorilla-capital.png',
			'description' => 'Custom built property locator, Custom advanced search tool, Custom Fix + Flip Calculator.',
			'credits' => '<p><em>Built for Limelight Department.</em></p>',
		),
	),
);