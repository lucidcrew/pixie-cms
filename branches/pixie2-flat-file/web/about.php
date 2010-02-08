<?php define('FNAME', basename(__FILE__));
class Page {
  public $time=1265282295;
  public $title='Architecture';
  public $text='%3Cp%3EThe+main+script+is+called+%3Cstrong%3Epixie.php%A0%3C%2Fstrong%3Eand+is+in+the+root+directory%3C%2Fp%3E%3Cp%3E%3Cimg+src%3D%22..%2Ffiles%2Fimages%2Fgvim.jpg%22+%2F%3E%3C%2Fp%3E%3Cp%3EThis+file+is+included+by+the+current+%3Cem%3Efile%2Furl%A0%3C%2Fem%3E%3C%2Fp%3E%3Cp%3EAll+the+public+files+are+kept+in+%3Cem%3Eweb%2F%A0%3C%2Fem%3Edir.+You+can+call+it+anything+you+like+..+it%27s+not+hard-coded.%3C%2Fp%3E%3Cp%3Eeg.+http%3A%2F%2Fexample.com%2Fweb%2F%3Cem%3Eslug.php%3C%2Fem%3E%3Cbr+%2F%3Eso+all+relative+url%27s+are+from+%3Cem%3Eweb%2F%3C%2Fem%3E+.+It+is+of+course+possible+to+%27remove+this+directory%27+with+a+rewriting+rule+in+a+htaccess+file.%3C%2Fp%3E%3Cp%3EThe+file+data+is+stored+in+the+following+format%3A%3C%2Fp%3E%3Cp%3EClass+Page%7B%3Cbr+%2F%3Epublic+%24title+%3D+%27%27%3B%3Cbr+%2F%3Epublic+%24text+%3D+%27%27%3B%3Cbr+%2F%3E%7D%3C%2Fp%3E%3Cp%3EThis+encapsulates+the+data%2C+and+is+unique+to+that+url.+A+template+in+the+%3Cem%3Ethemes+dir.%3C%2Fem%3E+which+can+be+chosen+in+the+global+config+file%2C+is+then+parsed+and+rendered+by+function+PrintFmt%28%29%3A%3C%2Fp%3E%3Cp%3E%3Cimg+src%3D%22..%2Ffiles%2Fimages%2Fcode.jpg%22+%2F%3E%3C%2Fp%3E';
}
include '../pixie.php';
?>