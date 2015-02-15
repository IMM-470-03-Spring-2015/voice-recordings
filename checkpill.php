<?php
$pill = $_REQUEST['Digits'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

if($pill == 1){ // red pill
    echo "<Response>";
    echo "<Say></Say>";
    echo "</Response>";
} else if($pill = 2) { // blue pill
    echo "<Response>";
    echo "<Say></Say>
    echo "</Response>";
} else { // other
    echo "<Response>";
    echo "<Say>Sorry, I didn't understand your selection. Please try again.</Say>"; 
    echo "<Redirect method="POST">http://yourserver/matrix.xml</Redirect>";
    echo "</Response>";
}