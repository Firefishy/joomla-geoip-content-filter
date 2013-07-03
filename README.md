joomla-geoip-content-filter
===========================

joomla-geoip-content-filter

Install
--------
1.  Download and uncompress http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz and save to maxmind-data/GeoIP.dat
2.  ZIP up all files to a file called GeoIPContent.zip (with GeoIPContent.xml, GeoIPContent.php in root of zip file)
3.  Joomla Admin -> Extension Manager -> Install -> Upload Package File
4.  Joomla Admin -> Extension Manager -> Manage -> "GeoIPContent" enable

Example Usage
--------
  {GEO GB}TEXT FOR United Kingdom ONLY{/GEO}
  
  {GEO !GB}TEXT FOR ALL COUNTRIES except United Kingdom{/GEO}
  
  {GEO AU}TEXT FOR Australia{/GEO}
  
  {GEO NZ}TEXT FOR New Zealand{/GEO}
  

Only 1 country can be specified per {GEO}. Nesting is not supported.
