# Goosle

A fast, privacy oriented meta search engine that just works.
Kept simple so everyone can use it and to make sure it works on most (basic) webservers.

Host for yourself and friends, with a access hash key. Or set up a public search website.

After-all, finding things should be easy and not turn into a chore.

[![Goosle Mainpage](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-mainpage-960x593.png)](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-mainpage.png)

## Features

- Search on DuckDuckGo
- Search on Google.com
- Image search through Qwant
- Search for magnet links on popular Torrent sites
- Special searches for; Currency conversion, Dictionary, Wikipedia and php.net
- Instant password generator on the home page
- Randomized user-agents for to prevent profiling by search providers
- Works on *any* hosting package that does PHP7.4 or newer
- Optional: Access key as a very basic way to keep your server to yourself
- Optional: Speed up repeat searches with APCu cache if your server has it

What Goosle does *not* have.

- Trackers and Cookies
- User profiles or user controllable settings
- Javascripts or Frameworks

And yet it just works...

## Screenshots

[![Goosle Mainpage](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-mainpage-150x150.png)](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-mainpage.png)
[![Goosle Search results](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-search-150x150.png)](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-search.png)
[![Goosle Torrent results](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-torrentsearch-150x150.png)](https://ajdg.solutions/wp-content/uploads/2023/12/goosle-torrentsearch.png)

## Requirements

Any basic webserver/webhosting package with PHP7.4 or newer.
Tested to work on Apache with PHP8.2.

## Installation

1. Unzip the download.
2. Edit the config.php file with your preferences.
3. Upload all files to your webserver, for example to the root folder of a subdomain (eg. search.example.com) or a sub-folder on your main site (eg. example.com/search/)
4. Rename goosle.htaccess to .htaccess
5. Load the site in your browser. If you've enabled the access hash add ?a=YOURHASH to the url.
6. Let me know where you installed Goosle :-)

### Notes

- The .htaccess file has a redirect to force HTTPS as well as browser caching instructions ready to go.
- The robots.txt has a rule to prevent all crawlers from crawling Goosle. But keep in mind that not every crawler obeys this file.
- The access hash is NOT meant as a super secure measure and only works for surface level prying eyes.

Have fun finding things!

## Disclaimer

Goosle started as a fork of LibreY, and ended up as a rewrite and something different completely. While the code structure remains largely the same, most functions have been rewritten or altered to work as I need it to.
Search results take design cues from DuckDuckGo and the torrent search has been modified to show more useful information where possible.
Goosle does not index, store or distribute torrent files. If you like, or found a use for, what you downloaded, you should probably buy a legal copy of it.

THe name Goosle is my last name with an L added in. Translate it from Dutch. Not in any way a derivation of Google and DuckDuckGo combined :wink:.

## Support

Goosle comes with limited support. You can post your questions on Github or on my support forum on [ajdg.solutions](https://ajdg.solutions/support/).

## Changelog

1.2.2 - February 16, 2024

- [new] Individual on/off setting for each search engine and torrent site
- [new] YTS Highlights for latest releases, highest rated or most downloaded movies
- [new] EZTV Highlights for latest TV Show episode releases
- [new] Goosle-cron.php file for if you want to clear the file cache in the background
- [change] l33tx torrents disabled by default - They use Cloudflare now, preventing the crawler from working reliably
- [change] Ecosia search disabled by default - They use some kind of bot detector now, preventing the crawler from working once caught
- [change] Now uses an ABSPATH global for file inclusions and paths
- [change] More discrete TV Show and Movie result detection in text search
- [tweak] Filter for eztv search, only include eztv if the search term starts with 'tt' (case insensitive)
- [tweak] Better ecosia link formatting to (hopefully) not get blocked by their bot detector
- [tweak] cURL headers to be (even) more browser-like
- [fix] Variable $url sometimes empty for certain torrent results
- [fix] Blocked category filter for YTS results now actually works

1.2.1 - January 15, 2024

- [new] Merge identical downloads (determined by info hash) from different torrent sites that provide hashes
- [new] Option to cache to flat files instead of APCu, files stored in /cache/ folder
- [new] Blank index.php files in all subfolders to shield from prying eyes
- [tweak] Improved version check
- [fix] Stray periods in some Limetorrent categories
- [fix] Inconsistent size indication for torrent results

1.2 - January 2, 2024

- [new] Preferred language setting for DuckDuckGo results in config.php.
- [new] Preferred language setting for Wikipedia results in config.php.
- [new] Combined DuckDuckGo, Google, Wikipedia and Ecosia (Bing) results into one page.
- [new] Ranking algorithm for search results.
- [new] Option to down-rank certain social media sites in results (Makes them show lower down the page).
- [new] Option to show the Goosle rank along with the search source.
- [new] Crawler for results from Limetorrents.lol.
- [new] Periodic check for updates in footer.
- [change] Moved duckduckgo.php and google.php into the engines/search/ folder.
- [change] Removed Wikipedia special search in favor of actual search results.
- [change] Removed 'Date Added' from 1337x results.
- [change] Removed Chrome based and Mobile user-agents, as they don't work for the WikiPedia API.
- [change] Added more trackers for generating magnet links.
- [tweak] 30-50% faster parsing of search results (couple of ms per search query).
- [tweak] Expanded the season/episode filter to all sources that support TV Shows.
- [tweak] More sensible santization of variables (Searching for html tags/basic code should now work).
- [tweak] Moved 'imdb_id_search' out from special results into its 'own' setting.
- [tweak] Moved 'password_generator' out from special results into its 'own' setting.
- [tweak] More accurate and faster Google scrape.
- [tweak] Reduced paragraph margins.
- [tweak] More code cleanup, making it more uniform.
- [fix] Prevents searching on disabled methods by 'cheating' the search type in the url.
- [fix] Better decoding for special characters in urls for search results.
- [fix] Better validation for special searches trigger words.
- [fix] Better sanitization for DuckDuckGo and Google results.

1.1 - December 21, 2023

- [new] API search for EZTV TV Shows.
- [new] config.default.php with default settings.
- [new] New option 'imdb_id_search' in 'special' settings in config.php.
- [new] New option 'show_zero_seeders' in config.php.
- [new] Special result and torrent redirect for IMDb IDs.
- [new] Replaced image search with Yahoo! Images.
- [new] Styled 'reset' button for search fields.
- [tweak] Removed 'raw_output' option.
- [tweak] Re-arranged results array to be more logical/easy to use.
- [tweak] Re-arranged code for results to do no double checks for search results.
- [tweak] Added more user-agents.
- [tweak] Torrent results page.
- [tweak] Sanitize scraped data earlier in the process.
- [tweak] Consistent single quotes for arrays.
- [tweak] Consistent spaces, tabs and newlines.
- [fix] Inconsistent input height for search field vs search button.
- [fix] Better check if a search is currency conversion or not.
- [fix] Typos in help.php.

1.0.2 - December 7, 2023

- [change] More useful error response when search doesn't work.
- [change] EngineRequest::request_successful() now provides a boolean response.
- [change] Removed versioning indicator from help page.
- [change] Added version indicator to results.php and help.php footer.
- [change] 'Nope, Go away!' for unauthorized users changed to 'Goosle'.
- [fix] Magnet links for torrents no longer opening in new tabs.

1.0.1 - December 5, 2023

- [fix] mktime() getting intermittent strings in 1337x crawler.
- [fix] mktime() getting intermittent strings in nyaa crawler.

1.0 - December 5, 2023

- Initial release

## Acknowledgements and stuff

Goosle started as a fork of LibreY, and ended up as a rewrite and something different completely. While the code structure remains largely the same, most functions have been rewritten or altered to work as I need it to. \
Search results take design cues from DuckDuckGo and the torrent search has been modified to show more useful information where possible. \
Goosle does not index, store or distribute torrent files. If you like, or found a use for, what you downloaded, you should probably buy a legal copy of it.

The name Goosle is my last name with an L added in. Translate it from Dutch. Not in any way a derivation of Google and DuckDuckGo combined.
