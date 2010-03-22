<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../');
	exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: MySQL database backup class, version 1.0.0
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @author Vagharshak Tozalakyan (vagh@armdex.com)
 * @link http://www.getpixie.co.uk
 * @link http://www.phpclasses.org/browse/package/2779.html
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
//------------------------------------------------------------------
define('MSB_VERSION', '1.0.0');
define('MSB_NL', "\r\n");
define('MSB_STRING', 0);
define('MSB_DOWNLOAD', 1);
define('MSB_SAVE', 2);
class MySQL_Backup {
	var $server = 'localhost';
	var $port = 3306;
	var $username = 'root';
	var $password = '';
	var $database = '';
	var $link_id = -1;
	var $connected = FALSE;
	var $tables = array();
	var $drop_tables = TRUE;
	var $struct_only = FALSE;
	var $comments = TRUE;
	var $backup_dir = '';
	var $fname_format = 'd_m_y__H_i_s';
	var $error = '';
	function Execute($task = MSB_STRING, $fname = '', $compress = FALSE) {
		if (!($sql = $this->_Retrieve())) {
			return FALSE;
		}
		if ($task == MSB_SAVE) {
			if (empty($fname)) {
				$fname = $this->backup_dir;
				$fname .= date($this->fname_format);
				$fname .= ($compress ? '.sql.gz' : '.sql');
			}
			return $this->_SaveToFile($fname, $sql, $compress);
		} elseif ($task == MSB_DOWNLOAD) {
			if (empty($fname)) {
				$fname = date($this->fname_format);
				$fname .= ($compress ? '.sql.gz' : '.sql');
			}
			return $this->_DownloadFile($fname, $sql, $compress);
		} else {
			return $sql;
		}
	}
	function _Connect() {
		$value = FALSE;
		if (!$this->connected) {
			$host          = $this->server . ':' . $this->port;
			$this->link_id = mysql_connect($host, $this->username, $this->password);
		}
		if ($this->link_id) {
			if (empty($this->database)) {
				$value = TRUE;
			} elseif ($this->link_id !== -1) {
				$value = mysql_select_db($this->database, $this->link_id);
			} else {
				$value = mysql_select_db($this->database);
			}
		}
		if (!$value) {
			$this->error = mysql_error();
		}
		return $value;
	}
	function _Query($sql) {
		if ($this->link_id !== -1) {
			$result = mysql_query($sql, $this->link_id);
		} else {
			$result = mysql_query($sql);
		}
		if (!$result) {
			$this->error = mysql_error();
		}
		return $result;
	}
	function _GetTables() {
		$value = array();
		if (!($result = $this->_Query('SHOW TABLES'))) {
			return FALSE;
		}
		while ($row = mysql_fetch_row($result)) {
			if (empty($this->tables) or in_array($row[0], $this->tables)) {
				$value[] = $row[0];
			}
		}
		if (!sizeof($value)) {
			$this->error = 'No tables found in database.';
			return FALSE;
		}
		return $value;
	}
	function _DumpTable($table) {
		$value = '';
		$this->_Query('LOCK TABLES ' . $table . ' WRITE');
		if ($this->comments) {
			$value .= '#' . MSB_NL;
			$value .= '# Table structure for table `' . $table . '`' . MSB_NL;
			$value .= '#' . MSB_NL . MSB_NL;
		}
		if ($this->drop_tables) {
			$value .= 'DROP TABLE IF EXISTS `' . $table . '`;' . MSB_NL;
		}
		if (!($result = $this->_Query('SHOW CREATE TABLE ' . $table))) {
			return FALSE;
		}
		$row = mysql_fetch_assoc($result);
		$value .= str_replace("\n", MSB_NL, $row['Create Table']) . ';';
		$value .= MSB_NL . MSB_NL;
		if (!$this->struct_only) {
			if ($this->comments) {
				$value .= '#' . MSB_NL;
				$value .= '# Dumping data for table `' . $table . '`' . MSB_NL;
				$value .= '#' . MSB_NL . MSB_NL;
			}
			$value .= $this->_GetInserts($table);
		}
		$value .= MSB_NL . MSB_NL;
		$this->_Query('UNLOCK TABLES');
		return $value;
	}
	function _GetInserts($table) {
		$value = '';
		if (!($result = $this->_Query('SELECT * FROM ' . $table))) {
			return FALSE;
		}
		while ($row = mysql_fetch_row($result)) {
			$values = '';
			foreach ($row as $data) {
				$values .= '\'' . addslashes($data) . '\', ';
			}
			$values = substr($values, 0, -2);
			$value .= 'INSERT INTO ' . $table . ' VALUES (' . $values . ');' . MSB_NL;
		}
		return $value;
	}
	function _Retrieve() {
		$value = '';
		if (!$this->_Connect()) {
			return FALSE;
		}
		if ($this->comments) {
			$value .= '#' . MSB_NL;
			$value .= '# MySQL database dump' . MSB_NL;
			$value .= '# Created by MySQL_Backup class, ver. ' . MSB_VERSION . MSB_NL;
			$value .= '#' . MSB_NL;
			$value .= '# Host: ' . $this->server . MSB_NL;
			$value .= '# Generated: ' . date('M j, Y') . ' at ' . date('H:i') . MSB_NL;
			$value .= '# MySQL version: ' . mysql_get_server_info() . MSB_NL;
			$value .= '# PHP version: ' . phpversion() . MSB_NL;
			if (!empty($this->database)) {
				$value .= '#' . MSB_NL;
				$value .= '# Database: `' . $this->database . '`' . MSB_NL;
			}
			$value .= '#' . MSB_NL . MSB_NL . MSB_NL;
		}
		if (!($tables = $this->_GetTables())) {
			return FALSE;
		}
		foreach ($tables as $table) {
			if (!($table_dump = $this->_DumpTable($table))) {
				$this->error = mysql_error();
				return FALSE;
			}
			$value .= $table_dump;
		}
		return $value;
	}
	function _SaveToFile($fname, $sql, $compress) {
		if ($compress) {
			if (!($zf = gzopen($fname, 'w9'))) {
				$this->error = 'Can\'t create the output file.';
				return FALSE;
			}
			gzwrite($zf, $sql);
			gzclose($zf);
		} else {
			if (!($f = fopen($fname, 'w'))) {
				$this->error = 'Can\'t create the output file.';
				return FALSE;
			}
			fwrite($f, $sql);
			fclose($f);
		}
		return TRUE;
	}
	function _DownloadFile($fname, $sql, $compress) {
		header('Content-disposition: filename=' . $fname);
		header('Content-type: application/octetstream');
		header('Pragma: no-cache');
		header('Expires: 0');
		echo ($compress ? gzencode($sql) : $sql);
		return TRUE;
	}
}
?>