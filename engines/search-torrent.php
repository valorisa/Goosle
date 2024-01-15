<?php
/* ------------------------------------------------------------------------------------
*  Goosle - A meta search engine for private and fast internet fun.
*
*  COPYRIGHT NOTICE
*  Copyright 2023-2024 Arnan de Gans. All Rights Reserved.
*
*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any 
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */
class TorrentSearch extends EngineRequest {
	protected $requests;
	
	public function __construct($opts, $mh) {
		require "engines/torrent/1337x.php";
		require "engines/torrent/lime.php";
		require "engines/torrent/thepiratebay.php";
		require "engines/torrent/yts.php";
		require "engines/torrent/nyaa.php";
		require "engines/torrent/eztv.php";
		
		$this->requests = array(
			new LeetxRequest($opts, $mh), // 1337x
			new LimeRequest($opts, $mh), // Limetorrents
			new PirateBayRequest($opts, $mh),
			new YTSRequest($opts, $mh),
			new NyaaRequest($opts, $mh),
			new EZTVRequest($opts, $mh)
		);
	}

    public function parse_results($response) {
        $results = $results_temp = array();

        foreach($this->requests as $request) {
            if($request->request_successful()) {
				$engine_result = $request->get_results();

				if(!empty($engine_result)) {
					// No merging of results
//					$results_temp = array_merge($results_temp, $engine_result);

					// Merge duplicates and apply relevance scoring
					foreach($engine_result as $result) {
						if(count($results_temp) > 1 && !is_null($result['hash'])) {
							$result_urls = array_column($results_temp, "hash", "id");
							$found_key = array_search($result['hash'], $result_urls);
						} else {
							$found_key = false;
						}

						if($found_key !== false) {
							// Duplicate result from another source
							// If seeders and/or leechers mismatch, assume they're different users
							if($results_temp[$found_key]['seeders'] != $result['seeders']) $results_temp[$found_key]['combo_seeders'] += $result['seeders'];
							if($results_temp[$found_key]['leechers'] != $result['leechers']) $results_temp[$found_key]['combo_leechers'] += $result['leechers'];

							$results_temp[$found_key]['combo_source'][] = $result['source'];
						} else {
							// First find, rank and add to results
							$result['combo_seeders'] = $result['seeders'];
							$result['combo_leechers'] = $result['leechers'];
							$result['combo_source'][] = $result['source'];

							$results_temp[$result['id']] = $result;
						}

						unset($result, $result_urls, $found_key, $social_media_multiplier, $goosle_rank, $match_rank);
					}
				}
			} else {
				$request_result = curl_getinfo($request->ch);
				$http_code_info = ($request_result['http_code'] >= 200 && $request_result['http_code'] <= 600) ? " - <a href=\"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/".$request_result['http_code']."\" target=\"_blank\">What's this</a>?" : "";
				
	            $results['error'][] = array(
	                "message" => "<strong>Ohno! A search query ran into some trouble.</strong> Usually you can try again in a few seconds to get a result!<br /><strong>Engine:</strong> ".get_class($request)."<br /><strong>Error code:</strong> ".$request_result['http_code'].$http_code_info."<br /><strong>Request url:</strong> ".$request_result['url']."."
	            );
            }
            
            unset($request);
        }

		if(count($results_temp) > 0) {
			// Sort by highest seeders
	        $seeders = array_column($results_temp, "combo_seeders");
	        array_multisort($seeders, SORT_DESC, $results_temp);
	
			// Cap results to 50
			$results['search'] = array_slice($results_temp, 0, 50);

			// Count results per source
			$sources = array_count_values(array_column($results['search'], 'source'));
			if(count($sources) > 0) $results['sources'] = $sources;

			unset($sources);
		} else {
			// Add error if there are no search results
            $results['error'][] = array(
                "message" => "No results found. Please try with more specific or different keywords!" 
            );
		}

		unset($results_temp);

        return $results; 
    }

    public static function print_results($results, $opts) {
/*
// Uncomment for debugging
echo '<pre>Settings: ';
print_r($opts);
echo '</pre>';
echo '<pre>Search results: ';
print_r($results);
echo '</pre>';
*/

		if(array_key_exists("search", $results)) {
			echo "<ol>";

			// Elapsed time
			$number_of_results = count($results['search']);
			echo "<li class=\"meta\">Fetched ".$number_of_results." results in ".$results['time']." seconds.</li>";

			// Format sources
	        search_sources($results['sources']);

			// Search results
			foreach($results['search'] as $result) {
				// Extra data
				$meta = array();
				if(array_key_exists('quality', $result)) $meta[] = "<strong>Quality:</strong> ".$result['quality'];
				if(array_key_exists('year', $result)) $meta[] = "<strong>Year:</strong> ".$result['year'];
				if(array_key_exists('category', $result)) $meta[] = "<strong>Category:</strong> ".$result['category'];
				if(array_key_exists('runtime', $result)) $meta[] = "<strong>Runtime:</strong> ".date('H:i', mktime(0, $result['runtime']));
				if(array_key_exists('date_added', $result)) $meta[] = "<strong>Added on:</strong> ".date('M d, Y', $result['date_added']);
				if(array_key_exists('url', $result)) $url = " - <a href=\"".$result['url']."\" target=\"_blank\" title=\"Careful - Site may contain intrusive popup ads and malware!\">torrent page</a>";
	
				// Put result together
				echo "<li class=\"result\"><article>";
				echo "<div class=\"title\"><a href=\"".$result['magnet']."\"><h2>".stripslashes($result['name'])."</h2></a></div>";
				echo "<div class=\"description\"><strong>Seeds:</strong> <span class=\"seeders\">".$result['combo_seeders']."</span> - <strong>Peers:</strong> <span class=\"leechers\">".$result['combo_leechers']."</span> - <strong>Size:</strong> ".$result['size']."<br />".implode(" - ", $meta)."</div>";
				if($opts->show_search_source == "on") echo "<div class=\"description\"><strong>Found on:</strong> ".replace_last_comma(implode(", ", $result['combo_source'])).$url."</div>";
				echo "</article></li>";

				unset($result, $meta);
			}

			echo "</ol>";
			echo "<center><small>Goosle does not index, offer or distribute torrent files.</small></center>";
		}

		// No results found
        if(array_key_exists("error", $results)) {
	        foreach($results['error'] as $error) {
            	echo "<div class=\"error\">".$error['message']."</div>";
            }
        }
	}
}
?>