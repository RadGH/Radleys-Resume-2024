document.addEventListener( 'DOMContentLoaded', function() {

	const HTML = document.documentElement;
	const BODY = document.body;

	const COLOR_BUTTON = document.querySelector( '.color-mode-toggle' );
	const PRINT_BUTTON = document.querySelector( '.print-mode-toggle' );

	const PRINT_STYLESHEET = document.querySelector('#print-css');

	const NAV_MENU = document.querySelector('.nav-menu');
	const NAV_MENU_TOGGLE = document.querySelector('.nav-menu-toggle');

	function set_color_mode( dark = null ) {
		// Default to browser preference
		if ( dark === null ) {
			dark = window.matchMedia && ! window.matchMedia('(prefers-color-scheme: light)').matches;
		}
		HTML.setAttribute( 'data-theme', dark ? 'dark' : 'light' );
	}

	function toggle_print_mode( active = null ) {
		HTML.classList.toggle( 'print', active );
		COLOR_BUTTON.style.display = active ? 'none' : '';
		PRINT_BUTTON.querySelector('.print-text').textContent = active ? 'Cancel' : 'Print';
		PRINT_STYLESHEET.media = active ? 'all' : 'print';
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
		COLOR_BUTTON.addEventListener( 'click', function( e ) {
			toggle_color_mode();
			e.preventDefault();
		});

		// Set default color mode
		set_color_mode( null );
	};

	const setup_print_mode = function() {
		let active = false;
		let previously_dark = false;

		// When clicking ".print-mode-toggle", toggle the print mode
		PRINT_BUTTON.addEventListener( 'click', function( e ) {
			active = ! active;

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

	const setup_nav_menu = function() {
		NAV_MENU_TOGGLE.addEventListener( 'click', function( e ) {
			let active = ! HTML.classList.contains('nav-menu-open');
			HTML.classList.toggle('nav-menu-open', active);
			NAV_MENU.classList.toggle('open', active);
			e.preventDefault();
		});
	}

	setup_color_mode();

	setup_print_mode();

	setup_nav_menu();

});