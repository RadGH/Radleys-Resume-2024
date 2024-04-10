<?php

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
function get_image_url() { return load_content( 'image' ); }
function get_job_title() { return load_content( 'job_title' ); }
function get_email() { return load_content( 'email' ); }
function get_links() { return load_content( 'links' ); }
function get_categories() { return load_content( 'categories' ); }
function get_skills() { return load_content( 'skills' ); }
function get_profile() { return load_formatted_content( 'profile' ); }
function get_employment() { return load_content( 'employment' ); }
function get_testimonials() { return load_content( 'testimonials' ); }
function get_projects() { return load_content( 'projects' ); }
function get_project_tags() { return load_content( 'project_tags' ); }

function get_formatted_tooltip( $text, $tooltip ) {
	return '<a href="#" class="tooltip tooltip-underline" title="' . $tooltip . '">' . $text . '</a>';
}

// Format as plural or singular and inserts the number as %1$d
function _n( $singular, $plural, $number ) {
	$str = intval($number) === 1 ? $singular : $plural;
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

// Convert a date to a human-readable format such as "3 days ago"
function time_since( $time ) {
	$diff = time() - $time;
	
	if ( $diff < 60 ) {
		return _n( '1 Second', '%d Seconds', $diff );
	}
	
	$diff = round( $diff / 60 );
	if ( $diff < 60 ) {
		return _n( '1 Minute', '%d Minutes', $diff );
	}
	
	$diff = round( $diff / 60 );
	if ( $diff < 24 ) {
		return _n( '1 Hour', '%d Hours', $diff );
	}
	
	$diff = round( $diff / 24 );
	if ( $diff < 7 ) {
		return _n( '1 Day', '%d Days', $diff );
	}
	
	$diff = round( $diff / 7 );
	if ( $diff < 4 ) {
		return _n( '1 Week', '%d Weeks', $diff );
	}
	
	$diff = round( $diff / 4 );
	if ( $diff < 12 ) {
		return _n( '1 Month', '%d Months', $diff );
	}
	
	$diff = round( $diff / 12 );
	return _n( '1 Year', '%d Years', $diff );
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

function years_since_n( $time ) {
	$years = years_since( $time );
	return _n('%d Year', '%d Years', $years);
}

function years_ago( $time, $ago = true ) {
	$years = years_since_n( $time );
	if ( $ago ) $years .= ' ago';
	return $years;
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

function esc_attr( $str ) {
	return htmlspecialchars( $str, ENT_QUOTES );
}

function esc_html( $str ) {
	return htmlspecialchars( $str, ENT_QUOTES );
}