<?php
require 'progressive/Progressive.php';

$settings = array(
	// Database connection
	'sql' => 'mysql:host=localhost;dbname=oodb', // connection parameters for database (leave empty string for no connection)
    'sqluser' => 'oodb',
    'sqlpasswd' => '',
	'sqlfrozen' => false, // set to true for production, when the complete database has been generated

	// Application (code)
	'app' => 'treeblog', // name of the application folder

	// Cache
	'cachename' => 'global', // name of cache used (if multiple apps with same app source) (empty string for no cache)
	'cachetime' => 10, // in seconds
	'cacheignore' => 'admin/,dynamic/', // don't use cache if query starts with (comma separated)

	// Logging en Benchmarking
	'loglevel' => 1, // the higher, the less it logs (with every uneven number it also logs benchmarks)
				//	1, 2 => DEBUG,
				//	3, 4 => INFO (Database operations are by default logged on level 4),
				//	5, 6 => WARN,
				//	7, 8 => ERROR,
				//	9, 10 => FATAL
	'log_to_file' => false, // force log to file (automaticly done if no database specified)
	'log_benchmark_cached' => true, // enable/disable logging for full page benchmark for pages from cache (always in file)
	'benchmark' => 'main', // automatic full page benchmark (empty string for no benchmark)
	
	// Url
	'url' => 'http://localhost/progressive', // URL to this page (without trailing slash or .php)
	'pre_query_url' => '', // part that has to be added before the actual query to come to this page
       // used if there are parts added inside the htaccess to control applications or databases
       
	// Folders
    'appfolder' => 'c:/xampplite/htdocs/progressive/progressive/apps', // folder with apps (no trailing slash)
	'logfolder' => 'c:/xampplite/htdocs/progressive/progressive/logs', // folder for logs, needs to be writeable (no trailing slash)
	'cachefolder' => 'c:/xampplite/htdocs/progressive/progressive/cache', // folder for cache, needs to be writeable (no trailing slash)
	
	'appsettings' => array(
		
	)
);

new Progressive($settings);