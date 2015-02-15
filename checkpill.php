<?php
$pill = $_REQUEST['Digits'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

if($pill == 1){ // red pill
    echo "<Response>";
    echo "<Play>http://www.mediamesis.net/imm/bluepill.mp3</Play>";
    echo "</Response>";
} else if($pill == 2) { // blue pill
    echo "<Response>";
    echo "<Play>http://www.mediamesis.net/imm/matrix66.mp3</Play>";
    echo "</Response>";
} else { // other
    echo "<Response>";
    echo "<Say>Sorry, I didn't understand your selection. Please try again.</Say>"; 
    echo "<Redirect method=\"POST\">http://www.tcnj.edu/~thompsom/imm-470-03/voice-recordings/matrix.xml</Redirect>";
    echo "</Response>";
}