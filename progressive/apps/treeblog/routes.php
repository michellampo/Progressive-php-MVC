<?php

function getRoutes() {
	return array(
		'hello-world' => 'hello_world',
		'hello-world/:name' => 'hello_world',
		'index' => 'index' // direct to view (as long as you don't create a index_controller.php)
	);
}