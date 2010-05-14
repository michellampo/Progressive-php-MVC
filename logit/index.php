<?php
require '../progressive/Progressive.php';

$settings = array(
	// Database connection
	'sql' => 'mysql:host=localhost;dbname=oodb', // connection parameters for database (leave empty string for no connection)
    'sqluser' => 'oodb',
    'sqlpasswd' => 'oodb',
	'sqlfrozen' => false, // set to true for production, when the complete database has been generated

	// Application (code)
	'app' => 'logit', // name of the application folder

	// Cache
	'cachename' => 'global', // name of cache used (if multiple apps with same app source) (empty string for no cache)
	'cachetime' => 10, // in seconds
	'cacheignore' => 'log,auth', // don't use cache if query starts with (comma separated)

	// Logging en Benchmarking
	'loglevel' => 1, // the higher, the less it logs (with every uneven number it also logs benchmarks)
				//	1, 2 => DEBUG,
				//	3, 4 => INFO (Database operations are by default logged on level 4),
				//	5, 6 => WARN,
				//	7, 8 => ERROR,
				//	9, 10 => FATAL
	'log_to_file' => true, // force log to file (automaticly done if no database specified)
	'log_benchmark_cached' => false, // enable/disable logging for full page benchmark for pages from cache (always in file)
	'benchmark' => 'main', // automatic full page benchmark (empty string for no benchmark)
	
	// Url
	'url' => 'http://localhost/logit', // URL to this page (without trailing slash or .php)
	'pre_query_url' => '', // part that has to be added before the actual query to come to this page
       // used if there are parts added inside the htaccess to control applications or databases
    'defaultcontroller' => 'auth', // controller for requests to "/"
       
	// Folders
    'appfolder' => 'c:/xampplite/htdocs/progressive/apps', // folder with apps (no trailing slash)
	'logfolder' => 'c:/xampplite/htdocs/progressive/logs', // folder for logs, needs to be writeable (no trailing slash)
	'cachefolder' => 'c:/xampplite/htdocs/progressive/cache', // folder for cache, needs to be writeable (no trailing slash)
	
//	'accessloglevel' => 1, // if "____loglevel" not defined: logs all levels
	'accessloglevels' => array( // if "____loglevels" not defined: uses the numbers
		1 => 'VISIT',
		2 => 'VISIT',
		3 => 'ACCESS ALLOWED',
		4 => 'ACCESS ALLOWED',
		5 => 'LOGIN',
		6 => 'LOGIN',
		7 => 'ACCESS DENIED',
		8 => 'ACCESS DENIED',
		9 => 'PAGE NOT FOUND',
		10 => 'PAGE NOT FOUND'
	),
	
	'appsettings' => array(
		'loglocations' => array(
			'main' => 'c:/xampplite/htdocs/progressive/logs'
		),
		'logdb' => 'c:/xampplite/htdocs/progressive/apps/logit/logs.db'
	)
);

if($_SERVER['HTTPS']){
	$settings['url'] = 'https' . substr($settings['url'], 4); 
}

new Progressive($settings);