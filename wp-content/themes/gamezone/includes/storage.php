<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage GAMEZONE
 * @since GAMEZONE 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('gamezone_storage_get')) {
	function gamezone_storage_get($var_name, $default='') {
		global $GAMEZONE_STORAGE;
		return isset($GAMEZONE_STORAGE[$var_name]) ? $GAMEZONE_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('gamezone_storage_set')) {
	function gamezone_storage_set($var_name, $value) {
		global $GAMEZONE_STORAGE;
		$GAMEZONE_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('gamezone_storage_empty')) {
	function gamezone_storage_empty($var_name, $key='', $key2='') {
		global $GAMEZONE_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($GAMEZONE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($GAMEZONE_STORAGE[$var_name][$key]);
		else
			return empty($GAMEZONE_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('gamezone_storage_isset')) {
	function gamezone_storage_isset($var_name, $key='', $key2='') {
		global $GAMEZONE_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($GAMEZONE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($GAMEZONE_STORAGE[$var_name][$key]);
		else
			return isset($GAMEZONE_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('gamezone_storage_inc')) {
	function gamezone_storage_inc($var_name, $value=1) {
		global $GAMEZONE_STORAGE;
		if (empty($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = 0;
		$GAMEZONE_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('gamezone_storage_concat')) {
	function gamezone_storage_concat($var_name, $value) {
		global $GAMEZONE_STORAGE;
		if (empty($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = '';
		$GAMEZONE_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('gamezone_storage_get_array')) {
	function gamezone_storage_get_array($var_name, $key, $key2='', $default='') {
		global $GAMEZONE_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($GAMEZONE_STORAGE[$var_name][$key]) ? $GAMEZONE_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($GAMEZONE_STORAGE[$var_name][$key][$key2]) ? $GAMEZONE_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('gamezone_storage_set_array')) {
	function gamezone_storage_set_array($var_name, $key, $value) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if ($key==='')
			$GAMEZONE_STORAGE[$var_name][] = $value;
		else
			$GAMEZONE_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('gamezone_storage_set_array2')) {
	function gamezone_storage_set_array2($var_name, $key, $key2, $value) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if (!isset($GAMEZONE_STORAGE[$var_name][$key])) $GAMEZONE_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$GAMEZONE_STORAGE[$var_name][$key][] = $value;
		else
			$GAMEZONE_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('gamezone_storage_merge_array')) {
	function gamezone_storage_merge_array($var_name, $key, $value) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if ($key==='')
			$GAMEZONE_STORAGE[$var_name] = array_merge($GAMEZONE_STORAGE[$var_name], $value);
		else
			$GAMEZONE_STORAGE[$var_name][$key] = array_merge($GAMEZONE_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('gamezone_storage_set_array_after')) {
	function gamezone_storage_set_array_after($var_name, $after, $key, $value='') {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if (is_array($key))
			gamezone_array_insert_after($GAMEZONE_STORAGE[$var_name], $after, $key);
		else
			gamezone_array_insert_after($GAMEZONE_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('gamezone_storage_set_array_before')) {
	function gamezone_storage_set_array_before($var_name, $before, $key, $value='') {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if (is_array($key))
			gamezone_array_insert_before($GAMEZONE_STORAGE[$var_name], $before, $key);
		else
			gamezone_array_insert_before($GAMEZONE_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('gamezone_storage_push_array')) {
	function gamezone_storage_push_array($var_name, $key, $value) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($GAMEZONE_STORAGE[$var_name], $value);
		else {
			if (!isset($GAMEZONE_STORAGE[$var_name][$key])) $GAMEZONE_STORAGE[$var_name][$key] = array();
			array_push($GAMEZONE_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('gamezone_storage_pop_array')) {
	function gamezone_storage_pop_array($var_name, $key='', $defa='') {
		global $GAMEZONE_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($GAMEZONE_STORAGE[$var_name]) && is_array($GAMEZONE_STORAGE[$var_name]) && count($GAMEZONE_STORAGE[$var_name]) > 0) 
				$rez = array_pop($GAMEZONE_STORAGE[$var_name]);
		} else {
			if (isset($GAMEZONE_STORAGE[$var_name][$key]) && is_array($GAMEZONE_STORAGE[$var_name][$key]) && count($GAMEZONE_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($GAMEZONE_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('gamezone_storage_inc_array')) {
	function gamezone_storage_inc_array($var_name, $key, $value=1) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if (empty($GAMEZONE_STORAGE[$var_name][$key])) $GAMEZONE_STORAGE[$var_name][$key] = 0;
		$GAMEZONE_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('gamezone_storage_concat_array')) {
	function gamezone_storage_concat_array($var_name, $key, $value) {
		global $GAMEZONE_STORAGE;
		if (!isset($GAMEZONE_STORAGE[$var_name])) $GAMEZONE_STORAGE[$var_name] = array();
		if (empty($GAMEZONE_STORAGE[$var_name][$key])) $GAMEZONE_STORAGE[$var_name][$key] = '';
		$GAMEZONE_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('gamezone_storage_call_obj_method')) {
	function gamezone_storage_call_obj_method($var_name, $method, $param=null) {
		global $GAMEZONE_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($GAMEZONE_STORAGE[$var_name]) ? $GAMEZONE_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($GAMEZONE_STORAGE[$var_name]) ? $GAMEZONE_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('gamezone_storage_get_obj_property')) {
	function gamezone_storage_get_obj_property($var_name, $prop, $default='') {
		global $GAMEZONE_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($GAMEZONE_STORAGE[$var_name]->$prop) ? $GAMEZONE_STORAGE[$var_name]->$prop : $default;
	}
}
?>