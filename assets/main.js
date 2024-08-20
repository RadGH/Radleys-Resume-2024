document.addEventListener( 'DOMContentLoaded', function() {

	const HTML = document.documentElement;
	const BODY = document.body;

	const COLOR_BUTTON = document.querySelector( '.color-mode-toggle' );
	const PRINT_BUTTON = document.querySelector( '.print-mode-toggle' );

	const PRINT_STYLESHEET = document.querySelector('#print-css');

	const MAIN_NAV = document.querySelector('nav.main-nav');
	const NAV_MENU = document.querySelector('.nav-menu');
	const NAV_MENU_TOGGLE = document.querySelector('.nav-menu-toggle');

	function setup_js() {
		// Show all elements with "hide-if-no-js" (by disabling those styles)
		document.querySelector('#hide-if-no-js-style').setAttribute('media', 'none');

		// Hide all elements with "hide-if-js" (by enabling those styles)
		document.querySelector('#hide-if-js-style').setAttribute('media', 'all');
	}

	function set_color_mode( dark = null ) {
		if ( HTML.classList.contains('print') ) {
			toggle_print_mode(false);
		}

		// Default to last used color mode from browser cookie, or fall back to browser preference
		if ( dark === null ) {
			let mode = localStorage.getItem('color-mode');

			if ( mode === 'dark' || mode === 'light' ) {
				// Use stored value from previous visit
				dark = (mode === 'dark');
			}else{
				// Use browser preference
				dark = window.matchMedia && ! window.matchMedia('(prefers-color-scheme: light)').matches;
			}
		}else{
			// Store the color mode in a cookie
			localStorage.setItem('color-mode', dark ? 'dark' : 'light');
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
		if ( ! NAV_MENU_TOGGLE ) return;

		NAV_MENU_TOGGLE.addEventListener( 'click', function( e ) {
			let active = ! HTML.classList.contains('nav-menu-open');
			HTML.classList.toggle('nav-menu-open', active);
			if ( NAV_MENU ) NAV_MENU.classList.toggle('open', active);
			e.preventDefault();
		});

		NAV_MENU.addEventListener( 'click', function( e ) {
			if ( e.target.classList.contains('nav-section') ) {
				// Close the mobile menu
				HTML.classList.toggle('nav-menu-open', false);
				if ( NAV_MENU ) NAV_MENU.classList.toggle('open', false);
			}
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

				let width_px = Math.round( active_section.a.offsetWidth );
				scroll_indicator.style.width = width_px + 'px';
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
	
	const setup_click_message_popup = function() {
		// Create a new div to hold each item
		const POPUP_CONTAINER = document.createElement('div');
		POPUP_CONTAINER.classList.add('popup-container');
		document.body.appendChild( POPUP_CONTAINER );
		
		// Create a new popup item with this function
		const create_popup = function( message, type = 'success', duration = null ) {
			let popup = document.createElement('div');
			popup.classList.add('popup', type);
			popup.innerHTML = message;
			POPUP_CONTAINER.appendChild( popup );

			if ( duration === null ) duration = 3000;

			const fade_in_time = 150; // ms
			const fade_out_time = 500; // ms

			setTimeout(function() {
				popup.classList.add('reveal');
			}, fade_in_time);

			setTimeout(function() {
				popup.classList.remove('reveal');
				popup.classList.add('fade-out');
				setTimeout(function() {
					POPUP_CONTAINER.removeChild( popup );
				}, fade_out_time);
			}, duration);
		};
		
		// When clicking a link with the class "tooltip", show a message popup
		document.body.addEventListener( 'click', function( e ) {
			// Get the <a> element from the target, or the closest parent
			let anchor = e.target.closest('a');

			if ( anchor && anchor.classList.contains('tooltip') ) {
				let message = anchor.title || anchor.innerHTML;
				let type = anchor.getAttribute('data-type') || 'success';
				let duration = anchor.getAttribute('data-duration') || null;
				create_popup( message, type, duration );
				e.preventDefault();
			}
		});
	};

	function setup_isotope() {
	}

	function setup_filters() {
		// Each filter link must have an attribute: data-filter="{tag}"
		// Each project item should have a corresponding class: "tag-{tag}"
		let filter_areas = [
			{
				'filter_container': '.project-filters .filter-list',
				'filter_selector': '.filter',
				'item_container': '.project-list',
				'item_selector': '.project',
				'class_prefix': 'tag-',
				'count_selector': '.project-count',
			}
		];

		// on document load
		for ( let i = 0; i < filter_areas.length; i++ ) {
			let area = filter_areas[i];
			let filter_container = document.querySelector( area.filter_container );
			let all_filter_links = filter_container.querySelectorAll( area.filter_selector );
			let item_container = document.querySelector( area.item_container );
			let class_prefix = area.class_prefix || '';

			if ( filter_container && item_container ) {
				let iso = new Isotope( item_container, {
					itemSelector: area.item_selector,
					layoutMode: 'fitRows',
				});

				// Set the first filter link as active, if not already
				let first_filter = filter_container.querySelector('.filter');
				if ( first_filter ) {
					first_filter.classList.add('active');
				}

				// When clicking a filter link, filter the items
				filter_container.addEventListener( 'click', function( e ) {
					let link = e.target;

					if ( link.classList.contains('filter') ) {
						let filter = link.getAttribute('data-filter');

						// Toggle "active" class on the filter links
						all_filter_links.forEach( function( this_link ) {
							this_link.classList.toggle('active', this_link === link );
						});

						let filterFn = function( element, link, c, d, e ) {
							if ( filter === '*' ) return true;
							if ( filter === '' ) return false;

							return element.classList.contains( class_prefix + filter );
						};

						iso.arrange({ filter: filterFn });

						e.preventDefault();
					}
				});

				// Every time isotope is sorted, count the number of visible items to display in the count_selector element
				iso.on( 'arrangeComplete', function( filteredItems ) {
					let count = filteredItems.length;
					let count_selector = document.querySelector( area.count_selector );
					if ( count_selector ) {
						count_selector.innerHTML = count;
					}
				});

				// Add container class "isotope-active" to know isotope is ready
				filter_container.classList.add('isotope-active');
				item_container.classList.add('isotope-active');

				// Recalculate the layout, fixes grid
				iso.layout();
				setTimeout(function() { iso.layout(); }, 500);

			}
		}
	}

	setup_js();

	setup_color_mode();

	setup_print_mode();

	setup_nav_menu();

	setup_nav_scroll();
	
	setup_click_message_popup();

	setup_isotope();

	setup_filters();

});