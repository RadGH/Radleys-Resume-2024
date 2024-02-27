<?php

class GitHubAPI {
	
	// Github API Settings
	private static $username = 'radgh';
	
	// Get a token here: https://github.com/settings/tokens?type=beta
	private static function get_token() {
		$token = file_get_contents( __DIR__ . '/github_token.txt' );
		return $token;
	}
	
	/**
	 * Load the repositories from the cache or API
	 * @return array {
	 *     @type string $id  	          The repository ID: 763768137
	 *     @type string $node_id  	      The node ID: R_kgDOLYYtSQ
	 *     @type string $name 	          The repository name: Radleys-Resume-2024
	 *     @type string $full_name 	      The repository full name: RadGH/Radleys-Resume-2024
	 *     @type string $html_url 	      The repository URL (for public links): https://github.com/RadGH/Radleys-Resume-2024
	 *     @type string $description      The repository description, or null
	 *     @type array $owner             The repository owner details {
	 *         @type string $login                "RadGH"
	 *         @type string $id                   2008464
	 *         @type string $node_id              "MDQ6VXNlcjIwMDg0NjQ="
	 *         @type string $avatar_url           "https:\/\/avatars.githubusercontent.com\/u\/2008464?v=4"
	 *         @type string $gravatar_id          ""
	 *         @type string $url                  "https:\/\/api.github.com\/users\/RadGH"
	 *         @type string $html_url             "https:\/\/github.com\/RadGH"
	 *         @type string $followers_url        "https:\/\/api.github.com\/users\/RadGH\/followers"
	 *         @type string $following_url        "https:\/\/api.github.com\/users\/RadGH\/following{\/other_user}"
	 *         @type string $gists_url            "https:\/\/api.github.com\/users\/RadGH\/gists{\/gist_id}"
	 *         @type string $starred_url          "https:\/\/api.github.com\/users\/RadGH\/starred{\/owner}{\/repo}"
	 *         @type string $subscriptions_url    "https:\/\/api.github.com\/users\/RadGH\/subscriptions"
	 *         @type string $organizations_url    "https:\/\/api.github.com\/users\/RadGH\/orgs"
	 *         @type string $repos_url            "https:\/\/api.github.com\/users\/RadGH\/repos"
	 *         @type string $events_url           "https:\/\/api.github.com\/users\/RadGH\/events{\/privacy}"
	 *         @type string $received_events_url  "https:\/\/api.github.com\/users\/RadGH\/received_events"
	 *         @type string $type                 "User"
	 *         @type string $site_admin           false
	 *     }
	 *     @type bool $private 	          Is the repository private?
	 *     @type bool $fork 	          Is the repository a fork?
	 *     @type string $created_at       The date the repository was created
	 *     @type string $updated_at       The date the repository was last updated
	 *     @type string $pushed_at        The date the repository was last pushed to
	 *
	 *     @type string $url 	          API URL of the repository (not for public links)
	 *     @type string $git_url 	      The git URL of the repository
	 *     @type string $ssh_url 	      The SSH URL of the repository
	 *     @type string $clone_url 	      The clone URL of the repository
	 *     @type string $svn_url 	      The SVN URL of the repository
	 *
	 *     @type string $language 	      The primary language of the repository
	 *     @type int $stargazers_count    The number of stars the repository has
	 *     @type int $watchers_count      The number of watchers the repository has
	 *     @type bool $has_issues 	      Does the repository have issues?
	 *     @type bool $has_projects       Does the repository have projects?
	 *     @type bool $has_downloads      Does the repository have downloads?
	 *     @type bool $has_wiki 	      Does the repository have a wiki?
	 *     @type bool $has_pages 	      Does the repository have pages?
	 *     @type bool $has_discussions    Does the repository have discussions?
	 *     @type int $forks_count 	      The number of forks the repository has
	 *     @type bool $archived 	      Is the repository archived?
	 *     @type bool $disabled 	      Is the repository disabled?
	 *     @type int $open_issues_count   The number of open issues the repository has
	 *     @type bool $allow_forking      Is the repository allowed to be forked?
	 *     @type bool $is_template 	      Is the repository a template?
	 *     @type array $topics 		      The topics of the repository
	 *     @type string $visibility 	  The visibility of the repository
	 *     @type int $forks 			  The number of forks the repository has
	 *     @type int $open_issues 	      The number of open issues the repository has
	 *     @type int $watchers 		      The number of watchers the repository has
	 *     @type string $default_branch   The default branch of the repository
	 *     @type array $permissions 	  The permissions of the repository
	 * }
	 */
	public static function load_repos() {
		// Cache file settings
		$cache_file = __DIR__ . '/github_data.json';
		$cache_time = 3600; // 1 hour
		
		$repos = false;
		
		// Check if repos already cached and valid
		if ( file_exists($cache_file) && time() - filemtime($cache_file) < $cache_time) {
			$repos = self::load_repos_from_cache( $cache_file );
		}
		
		// If cache is invalid or doesn't exist, load from API
		if ( $repos === false ) {
			$repos = self::load_repos_from_api();
			
			// Store the repos in the cache
			if ( $repos ) {
				file_put_contents($cache_file, json_encode($repos, JSON_PRETTY_PRINT));
			}
		}
		
		return $repos;
	}
	
	/**
	 * Load the repositories from the cache
	 *
	 * @param string $cache_file
	 * @return array
	 */
	private static function load_repos_from_cache( $cache_file ) {
		return json_decode(file_get_contents($cache_file), true);
	}
	
	/**
	 * Load the repositories from the GitHub API
	 *
	 * @return array|false
	 */
	private static function load_repos_from_api() {
		$curl = curl_init();
		
		$username = self::$username;
		$token = self::get_token();
		
		// Get recent repositories
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.github.com/users/$username/repos?sort=created&direction=desc",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'User-Agent: PHP Script',
				'Authorization: token ' . $token
			],
		]);
		
		// Execute the request
		$response = curl_exec($curl);
		curl_close($curl);
		
		// If request failed, return false
		if ( ! $response ) {
			return false;
		}
		
		// Decode the response
		$repos = json_decode($response, true);
		
		// Remove any repos with no description
		$repos = array_filter($repos, function($repo) {
			return ! empty($repo['description']);
		});
		
		return $repos;
	}
	
	
	public static function load_profile() {
		// Cache file settings
		$cache_file = __DIR__ . '/github_profile.json';
		$cache_time = 3600; // 1 hour
		
		$profile = false;
		
		// Check if profile already cached and valid
		if ( file_exists($cache_file) && time() - filemtime($cache_file) < $cache_time) {
			$profile = self::load_profile_from_cache( $cache_file );
		}
		
		// If cache is invalid or doesn't exist, load from API
		if ( $profile === false ) {
			$profile = self::load_profile_from_api();
			
			// Store the profile in the cache
			if ( $profile ) {
				file_put_contents($cache_file, json_encode($profile, JSON_PRETTY_PRINT));
			}
		}
		
		return $profile;
	}
	
	private static function load_profile_from_cache($cache_file) {
		$data = json_decode(file_get_contents($cache_file), true);
		// If error or message returned, do not use the cached value
		if ( ! $data || isset($data['message']) ) return false;
		return $data;
	}
	
	private static function load_profile_from_api() {
		$curl = curl_init();
		
		$username = self::$username;
		$token = self::get_token();
		
		// Get recent repositories
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.github.com/users/$username",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'User-Agent: PHP Script',
				'Authorization: token ' . $token
			],
		]);
		
		// Execute the request
		$response = curl_exec($curl);
		curl_close($curl);
		
		// If request failed, return false
		if ( ! $response ) {
			return false;
		}
		
		// Decode the response
		$profile = json_decode($response, true);
		
		return $profile;
	}
	
}

/*
Repository data includes:

// id: 763768137
// name: Radleys-Resume-2024
// full_name: RadGH/Radleys-Resume-2024
// html_url: https://github.com/RadGH/Radleys-Resume-2024
// description: NULL

array(80) {
	["id"]=>
	int(763768137)
	["node_id"]=>
	string(12) "R_kgDOLYYtSQ"
	["name"]=>
	string(19) "Radleys-Resume-2024"
	["full_name"]=>
	string(25) "RadGH/Radleys-Resume-2024"
	["private"]=>
	bool(false)
	["owner"]=>
	array(18) {
		["login"]=>
		string(5) "RadGH"
		["id"]=>
		int(2008464)
		["node_id"]=>
		string(20) "MDQ6VXNlcjIwMDg0NjQ="
		["avatar_url"]=>
		string(51) "https://avatars.githubusercontent.com/u/2008464?v=4"
		["gravatar_id"]=>
		string(0) ""
		["url"]=>
		string(34) "https://api.github.com/users/RadGH"
		["html_url"]=>
		string(24) "https://github.com/RadGH"
		["followers_url"]=>
		string(44) "https://api.github.com/users/RadGH/followers"
		["following_url"]=>
		string(57) "https://api.github.com/users/RadGH/following{/other_user}"
		["gists_url"]=>
		string(50) "https://api.github.com/users/RadGH/gists{/gist_id}"
		["starred_url"]=>
		string(57) "https://api.github.com/users/RadGH/starred{/owner}{/repo}"
		["subscriptions_url"]=>
		string(48) "https://api.github.com/users/RadGH/subscriptions"
		["organizations_url"]=>
		string(39) "https://api.github.com/users/RadGH/orgs"
		["repos_url"]=>
		string(40) "https://api.github.com/users/RadGH/repos"
		["events_url"]=>
		string(51) "https://api.github.com/users/RadGH/events{/privacy}"
		["received_events_url"]=>
		string(50) "https://api.github.com/users/RadGH/received_events"
		["type"]=>
		string(4) "User"
		["site_admin"]=>
		bool(false)
	}
	["html_url"]=>
	string(44) "https://github.com/RadGH/Radleys-Resume-2024"
	["description"]=>
	NULL
	["fork"]=>
	bool(false)
	["url"]=>
	string(54) "https://api.github.com/repos/RadGH/Radleys-Resume-2024"
	["forks_url"]=>
	string(60) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/forks"
	["keys_url"]=>
	string(68) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/keys{/key_id}"
	["collaborators_url"]=>
	string(83) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/collaborators{/collaborator}"
	["teams_url"]=>
	string(60) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/teams"
	["hooks_url"]=>
	string(60) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/hooks"
	["issue_events_url"]=>
	string(77) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/issues/events{/number}"
	["events_url"]=>
	string(61) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/events"
	["assignees_url"]=>
	string(71) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/assignees{/user}"
	["branches_url"]=>
	string(72) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/branches{/branch}"
	["tags_url"]=>
	string(59) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/tags"
	["blobs_url"]=>
	string(70) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/git/blobs{/sha}"
	["git_tags_url"]=>
	string(69) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/git/tags{/sha}"
	["git_refs_url"]=>
	string(69) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/git/refs{/sha}"
	["trees_url"]=>
	string(70) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/git/trees{/sha}"
	["statuses_url"]=>
	string(69) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/statuses/{sha}"
	["languages_url"]=>
	string(64) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/languages"
	["stargazers_url"]=>
	string(65) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/stargazers"
	["contributors_url"]=>
	string(67) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/contributors"
	["subscribers_url"]=>
	string(66) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/subscribers"
	["subscription_url"]=>
	string(67) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/subscription"
	["commits_url"]=>
	string(68) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/commits{/sha}"
	["git_commits_url"]=>
	string(72) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/git/commits{/sha}"
	["comments_url"]=>
	string(72) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/comments{/number}"
	["issue_comment_url"]=>
	string(79) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/issues/comments{/number}"
	["contents_url"]=>
	string(71) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/contents/{+path}"
	["compare_url"]=>
	string(78) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/compare/{base}...{head}"
	["merges_url"]=>
	string(61) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/merges"
	["archive_url"]=>
	string(77) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/{archive_format}{/ref}"
	["downloads_url"]=>
	string(64) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/downloads"
	["issues_url"]=>
	string(70) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/issues{/number}"
	["pulls_url"]=>
	string(69) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/pulls{/number}"
	["milestones_url"]=>
	string(74) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/milestones{/number}"
	["notifications_url"]=>
	string(94) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/notifications{?since,all,participating}"
	["labels_url"]=>
	string(68) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/labels{/name}"
	["releases_url"]=>
	string(68) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/releases{/id}"
	["deployments_url"]=>
	string(66) "https://api.github.com/repos/RadGH/Radleys-Resume-2024/deployments"
	["created_at"]=>
	string(20) "2024-02-26T22:09:07Z"
	["updated_at"]=>
	string(20) "2024-02-26T22:10:03Z"
	["pushed_at"]=>
	string(20) "2024-02-26T22:09:58Z"
	["git_url"]=>
	string(46) "git://github.com/RadGH/Radleys-Resume-2024.git"
	["ssh_url"]=>
	string(44) "git@github.com:RadGH/Radleys-Resume-2024.git"
	["clone_url"]=>
	string(48) "https://github.com/RadGH/Radleys-Resume-2024.git"
	["svn_url"]=>
	string(44) "https://github.com/RadGH/Radleys-Resume-2024"
	["homepage"]=>
	NULL
	["size"]=>
	int(0)
	["stargazers_count"]=>
	int(0)
	["watchers_count"]=>
	int(0)
	["language"]=>
	string(3) "PHP"
	["has_issues"]=>
	bool(true)
	["has_projects"]=>
	bool(true)
	["has_downloads"]=>
	bool(true)
	["has_wiki"]=>
	bool(true)
	["has_pages"]=>
	bool(false)
	["has_discussions"]=>
	bool(false)
	["forks_count"]=>
	int(0)
	["mirror_url"]=>
	NULL
	["archived"]=>
	bool(false)
	["disabled"]=>
	bool(false)
	["open_issues_count"]=>
	int(0)
	["license"]=>
	NULL
	["allow_forking"]=>
	bool(true)
	["is_template"]=>
	bool(false)
	["web_commit_signoff_required"]=>
	bool(false)
	["topics"]=>
	array(0) {
	}
	["visibility"]=>
	string(6) "public"
	["forks"]=>
	int(0)
	["open_issues"]=>
	int(0)
	["watchers"]=>
	int(0)
	["default_branch"]=>
	string(6) "master"
	["permissions"]=>
	array(5) {
		["admin"]=>
		bool(true)
		["maintain"]=>
		bool(true)
		["push"]=>
		bool(true)
		["triage"]=>
		bool(true)
		["pull"]=>
		bool(true)
	}
}
*/