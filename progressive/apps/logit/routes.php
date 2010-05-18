<?php

function getRoutes() {
	return array(
//		'admin' => 'admin',
//		'admin/:page' => 'admin',
		'log' => 'log',
		'log/[action]/:page' => 'log',
		'taconite/[action]/:log' => 'taconite',
		'taconite' => 'taconite',
		'auth/[action]' => 'auth'
//		'index' => 'public'
	);
}