<?php
class Robots
{
	const ROBOTS_TXT_LIFETIME = "-1 Day";
	protected $site;
	protected $robotsTxt;
	protected $robotsTxtLastUpdated;
	protected $lastCrawled;

	public function __construct($site)
	{
		$this->site = $site;
	}

	/**
	 * Checks whether it is OK to crawl a given URI at this time.
	 * @param   $uri                  string  URL to check, e.g. /my/page
	 * @param   $ignoreCrawlDelays    bool    Ignore crawl delays - Used to check whether or not a page can be crawled at any time.
	 * @return  bool
	 */
	public function isOkToCrawl($uri, $ignoreCrawlDelays = false)
	{
		// Check that our robots.txt is sufficiently up to date:
		$botUserAgent               = $this->_getBotUserAgent();
		$lastRobotsUpdateThreshold  = new \DateTime(self::ROBOTS_TXT_LIFETIME);

		if(empty($this->robotsTxtLastUpdated) || $this->robotsTxtLastUpdated < $lastRobotsUpdateThreshold) {             $this->robotsTxt            = $this->_parseRobotsTxt($this->_fetchRobotsTxt());
			$this->robotsTxtLastUpdated = new \DateTime();
		}

		// No rules? Free for all:
		if(!count($this->robotsTxt)) {
			return true;
		}

		foreach($this->robotsTxt as $userAgent => $botRules)
		{
			// No disallows and no crawl delay? Ignore this ruleset.
			if((empty($botRules['disallow']) || !count($botRules['disallow'])) && empty($botRules['crawl-delay'])) {
				continue;
			}

			// If the user agent matches ours, or is a catch-all, then process the rules:
			if($userAgent == '*' || preg_match('/' . $userAgent . '/i', $botUserAgent)) {
				foreach($botRules['disallow'] as $rule) {
					$disallow = $rule;
					$disallow = preg_quote($disallow, '/');
					$disallow = (substr($disallow, -1) != '*' && substr($disallow, -1) != '$') ? $disallow . '*' : $disallow;
					$disallow = str_replace(array('\*', '\$'), array('*', '$'), $disallow);
					$disallow = str_replace('*', '(.*)?', $disallow);

					if(preg_match('/^' . $disallow . '/i', $uri)) {
						return false;
					}
				}

				// Process crawl delay rules (unless we are ignoring them):
				if(!$ignoreCrawlDelays && !empty($botRules['crawl-delay'])) {
					$lastCrawlThreshold = new \DateTime('-' . $botRules['crawl-delay'] . ' SECOND');

					if(!empty($this->lastCrawled) && $this->lastCrawled > $lastCrawlThreshold) {
						return false;
					}

				}
			}
		}

		return true;
	}

	/**
	 * Gets our crawler user agent.
	 * @return string
	 */
	protected function _getBotUserAgent()
	{
		return 'Mozilla/5.0 (compatible; SearchProtect/1.0; +https://www.tannwestlake.com)';
	}

	/**
	 * Fetches the contents of a the site's robots.txt:
	 * @return string
	 * @throws \RuntimeException
	 */
	protected function _fetchRobotsTxt()
	{   
		$controller = new Controller();
		$parsed = parse_url($this->site);
		if( $controller->is_404( $parsed['scheme']. '://' . $parsed['host'] . '/robots.txt' ) ) {
			return false;        
		} else {
			return file_get_contents( $parsed['scheme']. '://' . $parsed['host'] . '/robots.txt');
		}
		
	}

	/**
	 * Parses the robots.txt file content into a rules array.
	 * @param $rules string
	 * @return array
	 */
	protected function _parseRobotsTxt($rules)
	{
		$rules      = explode("\n", str_replace("\r", "", $rules));
		$outRules   = array();

		$lastUserAgent = '*';
		foreach($rules as $rule)
		{
			if(trim($rule) == '') {
				continue;
			}

			if(strpos($rule, ':') === false) {
				continue;
			}

			$key = strtolower(trim(substr($rule, 0, strpos($rule, ':'))));
			$val = trim(substr($rule, strpos($rule, ':') + 1));

			if($key == 'user-agent') {
				$lastUserAgent = $val;
			}

			if(!isset($outRules[$lastUserAgent])) {
				$outRules[$lastUserAgent] = array();
			}

			if($key == 'disallow') {
				$outRules[$lastUserAgent]['disallow'][] = $val;
			}

			if($key == 'crawl-delay') {
				$outRules[$lastUserAgent]['crawl-delay'] = (float)$val;
			}
		}

		// Empty 'Disallow' means, effectively, allow all - so clear other rules.
		foreach($outRules as $ua => &$userAgent)
		{
			if(!isset($userAgent['disallow'])){
				continue;
			}

			foreach($userAgent['disallow'] as $rule) {
				if($rule == '') {
					$userAgent['disallow'] = array();
					break;
				}
			}
		}

		return $outRules;
	}
}
