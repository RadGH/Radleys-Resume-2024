<?php

return array(
	
	// Profile
	'name' => 'Radley Sustaire',
	'email' => 'radleygh@gmail.com',
	'image_url' => '/assets/radley-sustaire.jpg',
	'job_title' => 'WordPress Developer',
	
	// Links
	'links' => array(
		array(
			'title' => 'Email',
			'label' => 'radleygh@gmail.com',
			'url' => 'mailto:radleygh@gmail.com',
			'icon' => 'fad fa-envelope-open-text',
			'icon_html' => '<i class="fad fa-envelope-open-text"></i>',
		),
		/*
		array(
			'title' => 'Phone',
			'label' => '+1 (541) 513-8145',
			'url' => 'tel:1-541-513-8145',
			'icon' => 'fad fa-phone-alt',
			'icon_html' => '<i class="fad fa-phone-alt"></i>',
		),
		*/
		array(
			'title' => 'Website',
			'label' => 'radleysustaire.com',
			'url' => 'https://radleysustaire.com/',
			'icon' => 'fad fa-globe',
			'icon_html' => '<i class="fad fa-globe"></i>',
		),
		array(
			'title' => 'Github',
			'label' => 'github.com/RadGH',
			'url' => 'https://github.com/RadGH/',
			'icon' => 'fab fa-github',
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
		<p>I\'m a <strong>[job_title]</strong> with [dev_time_lower] of experience in web development. I\'m proficient in a range of web
		development technologies, familiar with design and development tools, and capable of managing Unix servers.</p>
		<p>My day-to-day work involves maintaining hosted websites for clients, developing custom themes and plugins, and
		optimizing websites for speed and performance.</p>
		<div class="animated-heading"><h3 class="heading">Preferred Software</h3></div>
		<p>Most projects are built using PHPStorm, Git, and AI tools such as GitHub Copilot. For design work I prefer Figma for layout,
		Photoshop for graphic design, and Inkscape for vector graphics.</p>
		<div class="animated-heading"><h3 class="heading">WordPress Specialist</h3></div>
		<p>I have focused <em>exclusively</em> on WordPress development for several years. I\'m familiar with theme and plugin development, web hosting,
		optimization, migrations, and third party integrations.</p>
		<p>Recently I\'ve been focusing on building Full Site Editor themes and using <a href="https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/" rel="external">@wordpress/scripts</a>
		for block development.</p>
		',
	
	'hobbies' => '
	<p>I enjoy acrylic and oil painting, riding my road bike, playing video games, and playing all types of card games. I especially enjoy playing Dungeons &amp; Dragons where I prefer a spellcasting Wizard or Cleric, unless I\'m the DM.</p>
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
	
);