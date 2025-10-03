<?php

class Plugins {
	
	public static string $api_url = 'https://zingmap.com/wp-json/wp/v2/plugin?per_page=100';
	
	/*
[0]=>
  array(23) {
    ["id"]=>
    int(28362)
    ["date"]=>
    string(19) "2025-09-24T10:39:31"
    ["date_gmt"]=>
    string(19) "2025-09-24T17:39:31"
    ["guid"]=>
    array(1) {
      ["rendered"]=>
      string(50) "https://zingmap.com/?post_type=plugin&p=28362"
    }
    ["modified"]=>
    string(19) "2025-09-24T11:05:59"
    ["modified_gmt"]=>
    string(19) "2025-09-24T18:05:59"
    ["slug"]=>
    string(29) "rs-preview-woocommerce-emails"
    ["status"]=>
    string(7) "publish"
    ["type"]=>
    string(6) "plugin"
    ["link"]=>
    string(57) "https://zingmap.com/plugin/rs-preview-woocommerce-emails/"
    ["title"]=>
    array(1) {
      ["rendered"]=>
      string(29) "RS Preview WooCommerce Emails"
    }
    ["content"]=>
    array(2) {
      ["rendered"]=>
      string(3112) ""
      ["protected"]=>
      bool(false)
    }
    ["author"]=>
    int(2)
    ["featured_media"]=>
    int(28366)
    ["parent"]=>
    int(0)
    ["template"]=>
    string(0) ""
    ["plugin-tag"]=>
    array(3) {
      [0]=>
      int(31)
      [1]=>
      int(27)
      [2]=>
      int(35)
    }
    ["class_list"]=>
    array(9) {
      [0]=>
      string(10) "post-28362"
      [1]=>
      string(6) "plugin"
      [2]=>
      string(11) "type-plugin"
      [3]=>
      string(14) "status-publish"
      [4]=>
      string(18) "has-post-thumbnail"
      [5]=>
      string(6) "hentry"
      [6]=>
      string(19) "plugin-tag-download"
      [7]=>
      string(22) "plugin-tag-git-updater"
      [8]=>
      string(22) "plugin-tag-woocommerce"
    }
    ["acf"]=>
    array(0) {
    }
    ["yoast_head"]=>
    string(4392) "
"
    ["yoast_head_json"]=>
    array(14) {
	...
    }
    ["zingmap_plugin"]=>
    array(9) {
      ["featured_image_url"]=>
      string(84) "https://zingmap.com/wp-content/uploads/2025/09/rs-preview-woocommerce-emails-min.jpg"
      ["summary"]=>
      string(164) "Adds the ability to preview all WooCommerce order emails in a popup without sending an email. Accessible through the "Order Actions" dropdown when editing an order."
      ["release_date"]=>
      string(8) "20250924"
      ["download_url"]=>
      string(70) "https://github.com/RadGH/RS-Preview-WooCommerce-Emails/releases/latest"
      ["github_url"]=>
      string(54) "https://github.com/RadGH/RS-Preview-WooCommerce-Emails"
      ["website_url"]=>
      string(0) ""
      ["premium"]=>
      bool(false)
      ["git_updater"]=>
      bool(true)
      ["tags"]=>
      array(3) {
        [0]=>
        array(4) {
          ["id"]=>
          int(31)
          ["name"]=>
          string(8) "Download"
          ["slug"]=>
          string(8) "download"
          ["url"]=>
          string(40) "https://zingmap.com/plugin-tag/download/"
        }
        [1]=>
        array(4) {
          ["id"]=>
          int(27)
          ["name"]=>
          string(11) "Git Updater"
          ["slug"]=>
          string(11) "git-updater"
          ["url"]=>
          string(43) "https://zingmap.com/plugin-tag/git-updater/"
        }
        [2]=>
        array(4) {
          ["id"]=>
          int(35)
          ["name"]=>
          string(11) "WooCommerce"
          ["slug"]=>
          string(11) "woocommerce"
          ["url"]=>
          string(43) "https://zingmap.com/plugin-tag/woocommerce/"
        }
      }
    }
	 */
	
	/**
	 * Gets an array of plugin data from the ZingMap website using public WP-JSON (Rest API)
	 * @return array[]|false {
	 *      @type int    $id The plugin ID
	 *      @type string $date The date the plugin was added
	 *      @type string $date_gmt The date the plugin was added in GMT
	 *      @type string $modified The date the plugin was last modified
	 *      @type string $modified_gmt The date the plugin was last modified in GMT
	 *      @type string $slug The slug of the plugin
	 *      @type string $link The link to the plugin page
	 *      @type array[rendered]  $title The title of the plugin
	 *      @type array[rendered]  $content The content of the plugin page
	 *      @type array  $zingmap_plugin {
	 *           @type string $featured_image_url The URL of the featured image
	 *           @type string $summary A short summary of the plugin
	 *           @type string $release_date The release date of the plugin (YYYYMMDD)
	 *           @type string $download_url The URL to download the plugin
	 *           @type string $github_url The GitHub URL of the plugin
	 *           @type string $website_url The website URL of the plugin
	 *           @type bool   $premium Whether the plugin is premium (true/false)
	 *           @type bool   $git_updater Whether the plugin uses Git Updater (true/false)
	 *           @type array  $tags An array of tags associated with the plugin {
	 *               @type int    $id The tag ID
	 *               @type string $name The name of the tag
	 *               @type string $slug The slug of the tag
	 *               @type string $url The URL of the tag archive
	 *          }
	 *      }
	 * }
	 */
	public static function get_plugins() {
		static $result = null;
		if ( $result !== null ) return $result;
		
		$cache_file = __DIR__ . '/zingmap_plugins.json';
		$cache_time = 3600 * 6; // 1 hour = 3600 seconds
		
		// Check if already cached and valid, returned cache data if so
		if ( file_exists( $cache_file ) && time() - filemtime( $cache_file ) < $cache_time ) {
			
			// Load from cache
			$result = self::load_from_cache( $cache_file );
			
		}else{
			
			// Not cached or cache expired, fetch new data
			$result = self::load_from_api();
			
			// Store in cache
			self::store_in_cache( $cache_file, $result );
			
		}
		
		return $result;
	}
	
	/**
	 * Gets an array of plugin tags from the ZingMap website based on current plugins
	 *
	 * @param array|null $plugins An array of plugins as returned by get_plugins(). If null, it will fetch the plugins automatically.
	 *
	 * @return array|false
	 */
	public static function get_plugin_tags( $plugins = null ) {
		if ( $plugins === null ) $plugins = self::get_plugins();
		
		$tags = array();
		
		if ( $plugins ) foreach( $plugins as $p ) {
			if ( ! isset( $p['zingmap_plugin'] ) ) continue;
			if ( ! isset( $p['zingmap_plugin']['tags'] ) ) continue;
			if ( ! is_array( $p['zingmap_plugin']['tags'] ) ) continue;
			
			foreach( $p['zingmap_plugin']['tags'] as $tag ) {
				if ( empty( $tag['id'] ) ) continue;
				
				$tags[ $tag['id'] ] = array(
					'id' => $tag['id'] ?? '',
					'name' => $tag['name'] ?? '',
					'slug' => $tag['slug'] ?? '',
					'url' => $tag['url'] ?? ''
				);
			}
		}
		
		return $tags;
	}
	
	/**
	 * Loads data from a cache file
	 *
	 * @param $cache_file
	 *
	 * @return array|false
	 */
	public static function load_from_cache( $cache_file ) {
		$result = file_get_contents( $cache_file );
		
		if ( $result ) {
			$data = json_decode( $result, true );
			if ( is_array( $data ) ) return $data;
		}
		
		return false;
	}
	
	/**
	 * Loads data from the ZingMap API
	 *
	 * @return array|false
	 */
	public static function load_from_api() {
		$curl = curl_init();
		
		// Get recent repositories
		curl_setopt_array( $curl, [
			CURLOPT_URL            => self::$api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => [
				'User-Agent: PHP Script',
			],
		] );
		
		// Execute the request
		$response = curl_exec( $curl );
		curl_close( $curl );
		
		// If request failed, return false
		if ( !$response ) {
			return false;
		}
		
		// Decode the response
		return json_decode( $response, true );
	}
	
	/**
	 * Stores data in a cache file
	 *
	 * @param string $cache_file
	 * @param mixed $data
	 *
	 * @return bool
	 */
	public static function store_in_cache( $cache_file, $data ) {
		// Delete existing file
		if ( file_exists( $cache_file ) ) unlink( $cache_file );
		
		// Create new file
		return (bool) file_put_contents( $cache_file, $data ? json_encode( $data ) : '[]' );
	}
}