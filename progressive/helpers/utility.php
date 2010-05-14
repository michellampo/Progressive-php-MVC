<?php

// ---------------------------- ERROR PAGES -------------------
function error_404() {
	error(404);
}

function error($code) {
	$code = decode($code, array(
		404 => 404,
		403 => 403
	), 404);
	$description = decode($code, array(
		404 => 'Not Found',
		403 => 'Forbidden'
	));
	header("HTTP/1.0 $code $description");
	include_once(SITE_PATH . "/views/$code.php");
	exit;
}

// -------------------------- HELPER FUNCTIONS -------------------------
function startsWith($Haystack, $Needle){
	return strpos($Haystack, $Needle) === 0;
}

function requiresHelpers($helpers) {
	foreach ($helpers as $helper) {
		require_once dirname(__FILE__) . '/' . $helper . '.php';
	}
}

function decode($var, $values, $default = '') {
	foreach ($values as $key=>$value) {
		if ($var == $key) return $value;
	}
	return $default;
}

function attributesToString($attributes) {
	if (is_string($attributes)) return $attributes;
	$atts = '';
	foreach ($attributes as $key => $val) {
		$atts .= ' ' . $key . '="' . $val . '"';
	}
	return $atts;
}

// ------------------ Link helpers -----------------------------
function a($action, $text, $id='', $class='', $attr='') {
	$action = Progressive::getUrl($action);
	$link = "<a href=\"$action\" ";
	if (strlen($id) > 0) $link .= "id=\"$id\" ";
	if (strlen($class) > 0) $link .= "class=\"$class\" ";
	$link .= ">$text</a>";
	return $link;
}

function anchor($name, $text='') {
	return "<a name=\"$name\" >$text</a>";
}

function goto_anchor($name, $text) {
	return "<a href=\"#$name\" >$text</a>";
}