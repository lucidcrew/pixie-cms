<?php 
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_upload.                                              //
//*****************************************************************//

// Author: Based on Easy PHP Upload - version 2.29 - Copyright (c) 2004 - 2006, Olaf Lederer
// Web:  	 www.finalwebsites.com 
// Desc: 	 A easy to use class for your (multiple) file uploads

//------------------------------------------------------------------ 

// This new Pixie function is used by both uploaders to inform the user their max upload file size php setting
// The failing of a too large file still needs to be logged. Someone please do it. Currently it just fails silently with no error message.

/* This file needs language strings */

/**
 * Convert a shorthand byte value from a PHP configuration directive to an integer value
 * @param    string   $value
 * @return   int
 */
function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
        $value_length = strlen( $value );
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k' :
                $qty *= 1024;
                break;
            case 'm' :
                $qty *= 1048576;
                break;
            case 'g' :
                $qty *= 1073741824;
                break;
        }
        return $qty;
    }
}

// End function convertBytes

class file_upload {

	var $the_file;
	var $the_temp_file;
	var $upload_dir;
	var $replace;
	var $do_filename_check;
	var $max_length_filename = 100;
	var $extensions;
	var $ext_string;
	var $language;
	var $http_error;
	var $rename_file;
	var $file_copy; 
	var $message = array();
	var $create_directory = TRUE;
	
	function file_upload() {
		$this->language = 'en';
		$this->rename_file = FALSE;
		$this->ext_string = "";
	}
	function show_error_string() {
		$msg_string = "";
		foreach ($this->message as $value) {
			$msg_string = $value . "";
		}
		return $msg_string;
	}
	function set_file_name($new_name = "") { 
		if ($this->rename_file) {
			if ($this->the_file == "") return;
			$name = ($new_name == "") ? strtotime('now') : $new_name;
			$name = $name.$this->get_extension($this->the_file);
		} else {
			$name = $this->the_file;
		}
		return $name;
	}
	function upload($to_name = "") {
		$new_name = $this->set_file_name($to_name);
		if ($this->check_file_name($new_name)) {
			if ($this->validateExtension()) {
				if (is_uploaded_file($this->the_temp_file)) {
					$this->file_copy = $new_name;
					if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
						$this->message[] = $this->error_text($this->http_error);
						if ($this->rename_file) $this->message[] = $this->error_text(16);
						return TRUE;
					}
				} else {
					$this->message[] = $this->error_text($this->http_error);
					return FALSE;
				}
			} else {
				$this->show_extensions();
				$this->message[] = $this->error_text(11);
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	function check_file_name($the_name) {
		if ($the_name != "") {
			if (strlen($the_name) > $this->max_length_filename) {
				$this->message[] = $this->error_text(13);
				return FALSE;
			} else {
				if ($this->do_filename_check == 'y') {
					if (preg_match("/^[^<>:\"\/\\|\?\*]*$/i", $the_name)) {
						return TRUE;
					} else {
						$this->message[] = $this->error_text(12);
						return FALSE;
					}
				} else {
					return TRUE;
				}
			}
		} else {
			$this->message[] = $this->error_text(10);
			return FALSE;
		}
	}
	function get_extension($from_file) {
		$ext = strtolower(strrchr($from_file, '.'));
		return $ext;
	}
	function validateExtension() {
		$extension = $this->get_extension($this->the_file);
		$ext_array = $this->extensions;
		if (in_array($extension, $ext_array)) { 
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function show_extensions() {
		$this->ext_string = implode(" ", $this->extensions);
	}
	function move_upload($tmp_file, $new_file) {
		umask(0);
		if ($this->existing_file($new_file)) {
			$newfile = $this->upload_dir . $new_file;
			if ($this->check_dir($this->upload_dir)) {
				if (move_uploaded_file($tmp_file, $newfile)) {
					if ($this->replace == 'y') {
						//system("chmod 0777 $newfile");
						chmod($newfile , 0777);
					} else {
						// system("chmod 0755 $newfile");
						chmod($newfile , 0755);
					}
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				$this->message[] = $this->error_text(14);
				return FALSE;
			}
		} else {
			$this->message[] = $this->error_text(15);
			return FALSE;
		}
	}
	function check_dir($directory) {
		if (!is_dir($directory)) {
			if ($this->create_directory) {
				umask(0);
				mkdir($directory, 0777);
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return TRUE;
		}
	}
	function existing_file($file_name) {
		if ($this->replace == 'y') {
			return TRUE;
		} else {
			if (file_exists($this->upload_dir . $file_name)) {
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
	function get_uploaded_file_info($name) {
		$str = 'File name: ' . basename($name) . "\n";
		$str .= "File size: ".filesize($name)." bytes\n";
		if (function_exists('mime_content_type')) {
			$str .= 'Mime type: ' . mime_content_type($name) . "\n";
		}
		if ($img_dim = getimagesize($name)) {
			$str .= 'Image dimensions: x = ' . $img_dim[0] . 'px, y = ' . $img_dim[1] . "px\n";
		}
		return $str;
	}
	function del_temp_file($file) {
		$delete = @unlink($file); 
		clearstatcache();
		if (@file_exists($file)) { 
			$filesys = str_replace('/', '\\', $file); 
			$delete = @system("del $filesys");
			clearstatcache();
			if (@file_exists($file)) {
				$delete = @chmod ($file, 0775); 
				$delete = @unlink($file); 
				$delete = @system("del $filesys");
			}
		}
	}
	// some error (HTTP)reporting, change the messages or remove options if you like. need some better handling of this with language file
	function error_text($err_num) {
		switch ($this->language) {
			default:
			// start http errors
			$error[0] = "" . $this->the_file.' was successfully uploaded.';
			$error[1] = 'The uploaded file exceeds the max. upload filesize directive in the server configuration.';
			$error[2] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.';
			$error[3] = 'The uploaded file was only partially uploaded. Try uploading the file again.';
			$error[4] = 'No file was uploaded.';
			// end  http errors
			$error[10] = 'Please select a file for upload.';
			$error[11] = 'Only files with the following extensions are allowed: ' . $this->ext_string . "";
			$error[12] = 'The filename contains invalid characters. Use only alphanumerical chars and separate parts of the name (if needed) with an underscore. A valid filename ends with one dot followed by the extension.';
			$error[13] = 'The filename exceeds the maximum length of ' . $this->max_length_filename . ' characters.';
			$error[14] = 'The upload directory does not exist';
			$error[15] = 'A file with that name already exist.';
			$error[16] = 'The uploaded file was renamed to ' . $this->file_copy . '.';
			
		}
		return $error[$err_num];
	}
}

class muli_files extends file_upload {
	
	var $number_of_files = 0;
	var $names_array;
	var $tmp_names_array;
	var $error_array;
	var $wrong_extensions = 0;
	var $bad_filenames = 0;
	
	function extra_text($msg_num) {
		switch ($this->language) {
			default:
			$extra_msg[1] = 'Error for: ' . $this->the_file . "";
			$extra_msg[2] = 'You have tried to upload ' . $this->wrong_extensions . ' files with a bad extension, the following extensions are allowed: ' . $this->ext_string . "";
			$extra_msg[3] = 'Select a file for upload.';
			$extra_msg[4] = 'Select the file(s) for upload.';
			$extra_msg[5] = 'You have tried to upload ' . $this->bad_filenames . ' files with invalid characters inside the filename.';
		}
		return $extra_msg[$msg_num];
	}
	function count_files() {
		foreach ($this->names_array as $test) {
			if ($test != "") {
				$this->number_of_files++;
			}
		}
		if ($this->number_of_files > 0) {
			return TRUE;
		} else {
			return FALSE;
		} 
	}
	function upload_multi_files () {
		$this->message = "";
		if ($this->count_files()) {
			foreach ($this->names_array as $key => $value) { 
				if ($value != "") {
					$this->the_file = $value;
					$new_name = $this->set_file_name();
					if ($this->check_file_name($new_name)) {
						if ($this->validateExtension()) {
							$this->file_copy = $new_name;
							$this->the_temp_file = $this->tmp_names_array[$key];
							if (is_uploaded_file($this->the_temp_file)) {
								if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
									$this->message[] = $this->error_text($this->error_array[$key]);
									if ($this->rename_file) $this->message[] = $this->error_text(16);
									sleep(1);
								}
							} else {
								$this->message[] = $this->extra_text(1);
								$this->message[] = $this->error_text($this->error_array[$key]);
							}
						} else {
							$this->wrong_extensions++;
						}
					} else {
						$this->bad_filenames++;
					}
				} 
			}
			if ($this->bad_filenames > 0) $this->message[] = $this->extra_text(5);
			if ($this->wrong_extensions > 0) {
				$this->show_extensions();
				$this->message[] = $this->extra_text(2);
			}
		} else {
			$this->message[] = $this->extra_text(3);
		}
	}
}

?>