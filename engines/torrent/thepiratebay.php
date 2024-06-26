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
class PirateBayRequest extends EngineRequest {
    public function get_request_url() {
        return "https://apibay.org/q.php?q=".urlencode($this->query);
    }

    public function parse_results($response) {
        $results = array();
        $json_response = json_decode($response, true);

		// No response
        if(empty($json_response)) return $results;

		$categories = array(
			100 => "Audio",
			101 => "Music",
			102 => "Audio Book",
			103 => "Sound Clips",
			104 => "Audio FLAC",
			199 => "Audio Other",

			200 => "Video",
			201 => "Movie",
			202 => "Movie DVDr",
			203 => "Music Video",
			204 => "Movie Clip",
			205 => "TV Show",
			206 => "Handheld",
			207 => "HD Movie",
			208 => "HD TV Show",
			209 => "3D Movie",
			210 => "CAM/TS",
			211 => "UHD/4K Movie",
			212 => "UHD/4K TV Show",
			299 => "Video Other",
			
			300 => "Applications",
			301 => "Apps Windows",
			302 => "Apps Apple",
			303 => "Apps Unix",
			304 => "Apps Handheld",
			305 => "Apps iOS",
			306 => "Apps Android",
			399 => "Apps Other OS",

			400 => "Games",
			401 => "Games PC",
			402 => "Games Apple",
			403 => "Games PSx",
			404 => "Games XBOX360",
			405 => "Games Wii",
			406 => "Games Handheld",
			407 => "Games iOS",
			408 => "Games Android",
			499 => "Games Other OS",
			
			500 => "Porn",
			501 => "Porn Movie",
			502 => "Porn Movie DVDr",
			503 => "Porn Pictures",
			504 => "Porn Games",
			505 => "Porn HD Movie",
			506 => "Porn Movie Clip",
			507 => "Porn UHD/4K Movie",
			599 => "Porn Other",

			600 => "Other",
			601 => "Other E-Book",
			602 => "Other Comic",
			603 => "Other Pictures",
			604 => "Other Covers",
			605 => "Other Physibles",
			699 => "Other Other"
		);

		// Use API result
        foreach($json_response as $response) {
			// Nothing found
            if($response["name"] == "No results returned") break;

            // Block these categories
            if(in_array($response["category"], $this->opts->piratebay_categories_blocked)) continue;

            $name = sanitize($response["name"]);
            $magnet = "magnet:?xt=urn:btih:".sanitize($response["info_hash"])."&dn=".$name."&tr=".implode("&tr=", $this->opts->torrent_trackers);

            array_push($results, array (
                // Required
                "source" => "thepiratebay.org",
                "name" => $name,
                "magnet" => $magnet,
				"seeders" => sanitize($response["seeders"]),
                "leechers" => sanitize($response["leechers"]),
                "size" => human_filesize(sanitize($response["size"])),
				// Optional
				"category" => $categories[sanitize($response["category"])],
                "url" => "https://thepiratebay.org/description.php?id=".sanitize($response["id"]),
 				"date_added" => sanitize($response["added"]),
           ));
        }

        return $results;
    }
}
?>
