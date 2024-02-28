document.addEventListener( 'DOMContentLoaded', function() {

	const HTML = document.documentElement;
	const BODY = document.body;

	const COLOR_BUTTON = document.querySelector( '.color-mode-toggle' );
	const PRINT_BUTTON = document.querySelector( '.print-mode-toggle' );

	const PRINT_STYLESHEET = document.querySelector('#print-css');

	const MAIN_NAV = document.querySelector('nav.main-nav');
	const NAV_MENU = document.querySelector('.nav-menu');
	const NAV_MENU_TOGGLE = document.querySelector('.nav-menu-toggle');

	function set_color_mode( dark = null ) {
		if ( HTML.classList.contains('print') ) {
			toggle_print_mode(false);
		}

		// Default to browser preference
		if ( dark === null ) {
			dark = window.matchMedia && ! window.matchMedia('(prefers-color-scheme: light)').matches;
		}
		HTML.setAttribute( 'data-theme', dark ? 'dark' : 'light' );
	}

	function toggle_print_mode( active = null ) {
		HTML.classList.toggle( 'print', active );
		if ( COLOR_BUTTON ) COLOR_BUTTON.classList.toggle( 'disabled', active );
		if ( PRINT_STYLESHEET ) PRINT_STYLESHEET.media = active ? 'all' : 'print';
	}

	// When changing color mode, change the HTML element "data-theme" attribute between "light" and "dark"
	const setup_color_mode = function() {

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
		if ( COLOR_BUTTON ) COLOR_BUTTON.addEventListener( 'click', function( e ) {
			toggle_color_mode();
			e.preventDefault();
		});

		// Set default color mode
		set_color_mode( null );
	};

	// When clicking ".print-mode-toggle", toggle the print mode
	const setup_print_mode = function() {
		// When clicking ".print-mode-toggle", toggle the print mode
		if ( PRINT_BUTTON ) PRINT_BUTTON.addEventListener( 'click', function( e ) {
			let	active = ! HTML.classList.contains('print');

			toggle_print_mode( active );

			if ( active ) {
				// Open print dialog after css is applied
				setTimeout(function() {
					window.print();
				}, 250);
			}

			e.preventDefault();
		});
	}

	// When clicking ".nav-menu-toggle", toggle the nav menu
	const setup_nav_menu = function() {
		if ( NAV_MENU_TOGGLE ) NAV_MENU_TOGGLE.addEventListener( 'click', function( e ) {
			let active = ! HTML.classList.contains('nav-menu-open');
			HTML.classList.toggle('nav-menu-open', active);
			if ( NAV_MENU ) NAV_MENU.classList.toggle('open', active);
			e.preventDefault();
		});
	}

	// As you scroll down the page, give "active" class to the currently visible section in the nav menu
	const setup_nav_scroll = function() {
		let scroll_sections = [];
		let active_section = null;

		// Get each section and link and put them together in scroll_sections
		// Also includes the top and bottom position of each section
		function recalculate_sections() {
			if ( ! NAV_MENU ) return;

			let navLinks = NAV_MENU.querySelectorAll('a.nav-section');
			scroll_sections = [];

			// Get each section linked in the menus
			for ( let i = 0; i < navLinks.length; i++ ) {
				let link = navLinks[i];
				let section = document.querySelector( link.hash );
				if ( section ) {
					scroll_sections[i] = {
						id: link.hash.replace('#', ''),
						a: link,
						section: section,
						top_pos: section.offsetTop,
						bottom_pos: section.offsetTop + section.offsetHeight,
					};

					// On the previous section, set the bottom_pos to the top_pos of this section
					// This eliminates gaps. The first section will have a top_pos of 0.
					if ( i > 0 ) {
						scroll_sections[i - 1].bottom_pos = scroll_sections[i].top_pos;
					}
				}
			}

			if ( scroll_sections.length < 1 ) return;

			// Order sections by top_pos (probably in this order already)
			scroll_sections.sort( (a, b) => a.top_pos - b.top_pos );

			// Ensure the first link has a top_pos of 0, even if something is above it
			scroll_sections[0].top_pos = 0;

			// Ensure the last link has a bottom_pos of the full body height, even if something is below it
			scroll_sections[scroll_sections.length - 1].bottom_pos = document.body.offsetHeight;

			// console.log( 'scroll_sections: ', scroll_sections );
		}

		// Get the scroll position of the window.
		function getScrollY() {
			let bodyHeight = document.body.offsetHeight;
			let windowHeight = window.innerHeight;
			let scrollY = window.scrollY;

			// If you are at the top of the page, use 0 as the scroll position
			// (You scrolled to the top of the page)
			if ( scrollY === 0 ) {
				return 0;
			}

			// If you scrolled to the bottom of the window, use the full body height
			// (You scrolled to the bottom of the page)
			if ( scrollY + windowHeight + 100 > bodyHeight ) {
				return bodyHeight;
			}

			// Otherwise, assume you scrolled to the middle of the window
			return scrollY + windowHeight / 2;
		}

		function update_scroll_indicator() {
			if ( active_section ) {
				let center_px = Math.round( active_section.a.offsetLeft + active_section.a.offsetWidth / 2 );
				scroll_indicator.style.left = center_px + 'px';
			}
		}

		function activate_section( s ) {
			if ( ! s ) return;
			if ( s === active_section ) return; // Already active

			// Store the active section
			active_section = s;

			// Deactivate all other sections
			for ( let i = 0; i < scroll_sections.length; i++ ) {
				let section = scroll_sections[i];
				if ( section.id !== active_section.id ) {
					section.a.parentElement.classList.toggle( 'active', false );
				}
			}

			// Activate the active section
			active_section.a.parentElement.classList.add('active');

			// Update the scroll indicator position to the center X position of the active section <a>
			update_scroll_indicator();
		}

		// Calculate which section is currently active, triggered on scroll
		function activate_sections() {
			if ( scroll_sections.length === 0 ) return;

			// Get the scroll position of the window, roughly the middle Y-position (except at top and bottom)
			let scrollYMiddle = getScrollY();

			// Track which section is active
			let active_id = null;

			// console.log( 'scrollYMiddle: ', scrollYMiddle );

			for ( let i = 0; i < scroll_sections.length; i++ ) {
				let section = scroll_sections[i];

				let section_top = section.top_pos;
				let section_bottom = section.bottom_pos;

				/*
				console.log( 'Checking if section is active', {
					section: section,
					active_id: active_id,
					scrollYMiddle: scrollYMiddle,
					section_top: section_top,
					section_bottom: section_bottom,
					bottom: scrollYMiddle >= section_bottom,
					top: scrollYMiddle >= section_top,
				});
				*/

				// If you scrolled past the bottom of a section, skip to the next one
				// Reminder: ScrollYMiddle is 0 at the top of the page.
				// +1 px to fix rounding errors
				if ( scrollYMiddle > section_bottom + 1 ) {
					continue;
				}

				// Check if you scrolled to a section yet
				if ( scrollYMiddle >= section_top ) {
					active_id = section.id;
					break;
				}
			}

			// console.log( 'Active section: ', active_id );

			// Add "active" class to the active section
			for ( let i = 0; i < scroll_sections.length; i++ ) {
				let section = scroll_sections[i];

				// Activate the section, if selected
				if ( section.id === active_id ) {
					activate_section( section );
					return;
				}
			}

			// If we did not activate a section, activate the first one
			activate_section( scroll_sections[0] );

			recalculate_all();
		}

		function recalculate_all() {
			recalculate_sections();
			update_scroll_indicator();

			// Repeat after a delay to allow animations to move things around
			setTimeout(function() {
				update_scroll_indicator();
			}, 1000);
		}

		function get_section_from_id( id ) {
			for ( let i = 0; i < scroll_sections.length; i++ ) {
				let section = scroll_sections[i];
				if ( section.id === id ) {
					return section;
				}
			}
			return null;
		}

		// Create an empty <span> to use as the scroll indicator (.scroll-indicator)
		let scroll_indicator = document.createElement('span');
		scroll_indicator.classList.add('scroll-indicator');

		// Add to the nav.main-nav element
		if ( MAIN_NAV ) MAIN_NAV.appendChild( scroll_indicator );

		// On scroll, activate the sections as they change
		window.addEventListener( 'scroll', activate_sections);

		// On resize, recalculate the sections and scroll indicator
		window.addEventListener( 'resize', recalculate_all );

		// Whenever an image loads, recalculate the sections
		window.addEventListener( 'load', recalculate_sections );

		// When clicking a section link, smooth scroll to the section without adding a hash to the URL
		if ( NAV_MENU ) NAV_MENU.addEventListener( 'click', function( e ) {
			if ( e.target.classList.contains('nav-section') ) {
				let section = get_section_from_id( e.target.hash.replace('#', '') );
				if ( section ) {
					let scrollY = section.top_pos;
					window.scrollTo({ top: scrollY, behavior: 'smooth' });
					e.preventDefault();
				}
			}
		});

		recalculate_sections();
		update_scroll_indicator();
		activate_sections();
	};

	setup_color_mode();

	setup_print_mode();

	setup_nav_menu();

	setup_nav_scroll();

});