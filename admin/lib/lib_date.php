<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_date.                                                //
//*****************************************************************//


// ------------------------------------------------------------------
// Converts an Unix-timestamp to a mysql-timestamp
	function returnSQLtimestamp($timestamp)
	{
	return strftime('%Y%m%d%H%M%S', $timestamp);
	}
// ------------------------------------------------------------------
// Converts an mysql-timestamp to a Unix-timestamp
	function returnUnixtimestamp($timestamp)
	{
	$timestamp = str_replace('-', "", $timestamp); //introduced after mysql started to format time strangely
	$timestamp = str_replace(" ", "", $timestamp);
	$timestamp = str_replace(':', "", $timestamp);
	
	$year = substr($timestamp, 0, 4);
	$month = substr($timestamp, 4, 2);
	$day = substr($timestamp, 6, 2);
	$hour = substr($timestamp, 8, 2);
	$min = substr($timestamp, 10, 2);
	$sec = substr($timestamp, 12, 2);
	return mktime($hour, $min, $sec, $month, $day, $year);
	} 
// -------------------------------------------------------------
// Format a time, respecting the local time zone
	function safe_strftime($format, $time = '')
	{
		if ($format == 'since') {
			$str = since($time);
			return $str;
		} else {
			$str = strftime($format, $time);		
			return $str;
		}
	}
// -------------------------------------------------------------
	function since($stamp) 
	{
		global $lang;
		
		$diff = (time() - $stamp);
		if ($diff <= 3600) {
			$mins = round($diff / 60);
			$since = ($mins <= 1) 
			?	($mins==1)
				?	$lang['a_minute']
				:	$lang['a_few_seconds']
			:	"$mins " . $lang['minutes'];
		} else if (($diff <= 86400) && ($diff > 3600)) {
			$hours = round($diff / 3600);
			if ($hours <= 1) {
				$since = $lang['a_hour'];
			} else {
				$since = "$hours " . $lang['hours'];
			}
		} else if ($diff >= 86400) {
			$days = round($diff / 86400);
			if ($days <= 1) {
				$since = $lang['a_day'];
			} else {
				$since = "$days " . $lang['days'];
			}
		}
		return $since . ' ' . $lang['ago'];
	}
// -------------------------------------------------------------
// Calculate the offset between the server local time and the
// user's selected time zone
	function tz_offset()
	{	
		global $timezone, $dst;

		extract(getdate());
		$serveroffset = gmmktime(0, 0, 0, $mon, $mday, $year) - mktime(0, 0, 0, $mon, $mday, $year);
		$offset = $timezone - $serveroffset;
		if ($dst == "no") { $dst = 0; }
		return $offset + ($dst ? 3600 : 0);
	}
// ------------------------------------------------------------------
// creates a drop down selection for date input
	function date_dropdown($date) 
	{

	$months = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

	if (!$date) {
		$unixtime = time() + tz_offset();
		$this_day = date('d' , $unixtime);
		$this_month = date('n' , $unixtime);
		$this_year = date('Y' , $unixtime);
		$time = date('H' . ':' . 'i' , $unixtime);
	} else {
		$unixtime = returnUnixtimestamp($date);
		$this_day = date('d' , $unixtime);
		$this_month = date('n' , $unixtime);
		$this_year = date('Y' , $unixtime);
		$time = date('H' . ':' . 'i' , $unixtime);
	}

	$max_day = 31;
	$min_day = 1;

	echo "\t\t\t\t\t\t\t\t<select class=\"form_select\" id=\"date\" name=\"day\">\n";
	while ($min_day <= $max_day) {
		if ($min_day == $this_day) {
			echo "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$min_day\">$min_day</option>\n";
		} else {
			echo "\t\t\t\t\t\t\t\t\t<option value=\"$min_day\">$min_day</option>\n";
		}
		$min_day++;
	}
	echo "\t\t\t\t\t\t\t\t</select>\n";
 
  $max_month = 12;
  $min_month = 1;
  
	echo "\t\t\t\t\t\t\t\t<select class=\"form_select\" name=\"month\">\n";
	while ($min_month <= $max_month) {
		if ($min_month == $this_month) {
			echo "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$min_month\">$months[$min_month]</option>\n";
		} else {
			echo "\t\t\t\t\t\t\t\t\t<option value=\"$min_month\">$months[$min_month]</option>\n";
		}
		$min_month++;
	}
	echo "\t\t\t\t\t\t\t\t</select>\n";

	$max_year = $this_year + 5;
	$min_year = $this_year - 5;

	echo "\t\t\t\t\t\t\t\t<select class=\"form_select\" name=\"year\">\n";
	while ($min_year <= $max_year) {
		if ($min_year == $this_year) {
			echo "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$min_year\">$min_year</option>\n";
		} else {
			echo "\t\t\t\t\t\t\t\t\t<option value=\"$min_year\">$min_year</option>\n";
		}
		$min_year++;
	}
	echo "\t\t\t\t\t\t\t\t</select>\n";

	echo "\n\t\t\t\t\t\t\t\t@ <input type=\"text\" class=\"form_text\" name=\"time\" value=\"$time\" size=\"5\" maxlength=\"5\" />";

	}
?>