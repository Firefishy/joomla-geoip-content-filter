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

		$contents = $article->text;
		$output = '';
		$regexp = '/(.*?)'.'\{GEO [a-zA-Z]{2,3}\}'.'\s+(.*?)'.'\{\/GEO\}'.'(.*)/s';
		$found = preg_match($regexp, $contents, $matches);
		while ($found) {
			$output .= $matches[1];
			$country = $matches[2];
			$country_contents = '<div class="Country'.$country.'">'.$matches[3].'</div>';

			$output .= $country_contents;
			
			$contents = $matches[4];
			$found = preg_match($regexp, $contents, $matches);
		}
		$output .= $contents;
		$article->text = $output;
		return true;
	}
}
