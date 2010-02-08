<?php if(!defined('FNAME')) exit;

//***********************************************************************//
// Pixie: The Small, Simple, Site Maker.                                 //
// ----------------------------------------------------------------------//
// Licence: GNU General Public License v3                                //
// Copyright (C) 2010, Scott Evans                                       //
//                                                                       //
// This program is free software: you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation, either version 3 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          //
// GNU General Public License for more details.                          //
//                                                                       //
// You should have received a copy of the GNU General Public License     //
// along with this program. If not, see http://www.gnu.org/licenses/     // 
//                                                                       //
// ----------------------------------------------------------------------//
// Title: pixie.php --- Main script                                      //
// Author: M.Isa                                                         //
//                                                                       //
//***********************************************************************//

date_default_timezone_set('UTC');
$Marker['start'] = microtime();
$Now = time();
$PageFmt = "<?php define('FNAME', basename(__FILE__));
class Page {
  public \$time={time};
  public \$title='{title}';
  public \$text='{text}';
}
include '../pixie.php';
?>";
$SideFmt = "<?php 
class Side {
  public \$time={time};
  public \$title='{title}';
  public \$text='{text}';
}
\$Side = new Side();
";
$Pageparm = array(
  '{last_mod}' => "strftime(\$TimeFmt, \$Page->time)"
  );
$Editparm = array(
  '{head}' => '"<legend>{fname}</legend>
<div class=\"form_label\"><p><label for=\"title\">Title <span class=\"form_required\">*</span></label>
	<input type=\"text\" class=\"form_text\" name=\"title\" id=\"title\" value=\"{title}\" size=\"50\" maxlength=\"235\" />
	<input type=\"hidden\" class=\"form_text\" name=\"file_name\" value=\"{fname}\" />
</p></div>"',
  );
$Sideparm = array(
  '{head}' => '"<legend>sidebar.php</legend>
<div><p>
        <input type=\"hidden\" class=\"form_text\" name=\"file_name\" value=\"sidebar.php\" />
</p></div>"',
  );
$Newparm = array(
  '{head}' => '"<legend>New</legend>
<div class=\"form_label\"><p><label for=\"title\">Slug (file name) <span class=\"form_required\">*</span></label>
        <input type=\"text\" class=\"form_text\" name=\"file_name\" value=\"\" size=\"15\" maxlength=\"15\" /> .php</p>
<p><label for=\"title\">Title <span class=\"form_required\">*</span></label>
        <input type=\"text\" class=\"form_text\" name=\"title\" id=\"title\" value=\"\" size=\"50\" maxlength=\"235\" /></p>
</div>"',
  );

include_once('sidebar.php');
include_once('admin/config.php');
if(file_exists('admin/local/'.FNAME))
  include_once('admin/local/'.FNAME);

if (isset($_POST['submit_edit'])) {
  if ($_POST['submit_edit'] === 'Update') {
    if ($_POST['file_name'] === 'sidebar.php') {
      $New = &$Side;
      WritePage($SideFmt, 'sidebar.php');
    }
    else {
      $New = new Page();
      $Fname = preg_replace('/.php/', '', strtolower($_POST['file_name']));
      $Fname = preg_replace('/[^a-z]/', '', $Fname).'.php';
      WritePage($PageFmt, $Fname);
      $Page = &$New;
    }
  }
}
if (isset($_GET['op'])) {
  if ($_GET['op'] === 'side') {
    $Page = &$Side;
    PrintFmt('edit', $Sideparm);
  }
  elseif ($_GET['op'] === 'new') {
    PrintFmt('edit', $Newparm);
  }
  else {
    $Page = new Page();
    PrintFmt('edit', $Editparm);
  }
}
else {
  if (!isset($Page)) $Page = new Page();
  PrintFmt('main', $Pageparm);
}
return;
###############################################################################

function PrintFmt($tmpl, &$parm) {
  global $Page, $Side, $TimeFmt, $Fname, $Theme;
  if (!isset($Fname)) $Fname = FNAME;

  $parm['{title}'] = "urldecode(\$Page->title)";
  $parm['{cur_time}'] = "strftime(\$TimeFmt)";
  $parm['{fname}'] = "\$Fname";
  $parm['{theme}'] = "\$Theme";
  if(!isset($_GET['op'])) {
    $parm['{side_text}'] = "urldecode(\$Side->text)";
    $parm['{main_text}'] = "urldecode(\$Page->text)";
  }
  else
    $parm['{main_text}'] = "htmlspecialchars(urldecode(\$Page->text), ENT_NOQUOTES)";

  ob_start();
  include "../admin/themes/$Theme/$tmpl.txt";
  $out = ob_get_contents();
  @ob_end_clean();
  foreach ($parm as $k => $v)
    $out = str_replace($k, eval('return('.$v.');'), $out);
  $elapsed = elapsed_time('start');
  $out = str_replace('{elapsed_time}', $elapsed, $out);
  echo $out;
}

function Lock($op) {
  static $lockfp, $curop=0;
  if(!$lockfp) {
    $lockfp=fopen(".flock","w") or 
      trigger_error("Cannot acquire lockfile", E_USER_ERROR);
  }
  if($op==1 && $curop<1) {
    flock($lockfp,LOCK_EX);
    $curop=1;
  }else {
    flock($lockfp,LOCK_UN);
    $curop=0;
  }
}

function WritePage($fmt, $fname) {
  global $Now, $New;

  $New->time = $Now;
  $New->title = urlencode(stripslashes($_POST['title']));
  $New->text = urlencode(stripslashes($_POST['content']));

  $out = $fmt;
  $out = str_replace('{time}', $New->time, $out);
  $out = str_replace('{title}', $New->title, $out);
  $out = str_replace('{text}', $New->text, $out);
  Lock(1);
  if ($fp = fopen($fname,"w")) {
    fputs($fp, $out); 
    fclose($fp);
  } else { trigger_error("Cannot write text", E_USER_ERROR); }
  Lock(0);
}

function elapsed_time($pt1 = '', $pt2 = '', $dec = 4) {
  global $Marker;
  if ( ! isset($Marker[$pt1]))
    return '';
  if ( ! isset($Marker[$pt2]))
    $Marker[$pt2] = microtime();

  list($sm, $ss) = explode(' ', $Marker[$pt1]);
  list($em, $es) = explode(' ', $Marker[$pt2]);

  return number_format(($em + $es) - ($sm + $ss), $dec);
}

