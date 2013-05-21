<?php
/**
* ContentGeoIP plugin
* Inspired by DirectPHP plugin
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.event.plugin' );

class plgContentGeoIPContent extends JPlugin {
	
	//PHP4 Compatibility
	function plgContentGeoIP( &$subject, $params ) {
		parent::__construct( $subject, $params );
	}

	function onContentPrepare( $context, &$article, &$params, $limitstart=0 ) {
		$pluginParams = $this->params;

		require_once('geoip-api-php/geoip.inc');
		$maxmind_geoip_file = dirname(__FILE__).'/maxmind-data/GeoIP.dat';
		$gi = geoip_open($maxmind_geoip_file, GEOIP_STANDARD);
		$client_ip = $this->getClientIp();
		$client_ip_code = geoip_country_code_by_addr($gi, $client_ip);
		geoip_close($gi);
	
		$contents = $article->text;
		$output = '';
		$regexp = '/(.*?)'.'\{GEO ([\!A-Za-z]{2,4})\}'.'\s*(.*?)'.'\{\/GEO\}'.'(.*)/s';
		$found = preg_match($regexp, $contents, $matches);
		while ($found) {
			$output .= $matches[1];
			$country = $matches[2];
			if ($country[0] == '!') {
				if (strtoupper(substr($country,1)) != $client_ip_code) {
					$output .= $matches[3];
				}			
			} else {
				if (strtoupper($country) == $client_ip_code) {
					$output .= $matches[3];
				}
			}
	
			$contents = $matches[4];
			$found = preg_match($regexp, $contents, $matches);
		}
		$output .= $contents;
		$article->text = $output;
		return true;
	}

    function getClientIp() {
		//FIXME handling for proxy chain needed
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
