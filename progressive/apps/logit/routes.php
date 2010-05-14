<?php

function getRoutes() {
	return array(
//		'admin' => 'admin',
//		'admin/:page' => 'admin',
		'log' => 'log',
		'log/[action]/:page' => 'log',
		'taconite/:page' => 'taconite',
		'taconite' => 'taconite',
		'auth/[action]' => 'auth'
//		'index' => 'public'
	);
}