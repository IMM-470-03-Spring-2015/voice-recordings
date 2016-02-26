<?php
/* save a Twilio recording to Soundcloud 
* useful for creating phone-based oral histories along with timeline.js etc
*/

// usage http://somehost.com/save2sc.php?recid=xxxxxxxxxxxx[&tag=sometag%20anothertag]
if( isset($_REQUEST["recid"]) && !empty($_REQUEST["recid"]) ) {
    
    // include the SoundCloud library
    require('Services/Soundcloud.php');

    // Twilio stuff
    $accountSID = 'xxxxxxxxxxxxxxxxxxxxxxx';
    $recordingSID = htmlspecialchars($_REQUEST["recid"]);
    // space seperated list of tags
    $tags = ( isset($_REQUEST["tag"]) && !empty($_REQUEST["tag"]) ) ? $_REQUEST["tag"] : "general" ;

    // download the twilio recording
    $remotefile = "https://api.twilio.com/2010-04-01/Accounts/".$accountSID."/Recordings/".$recordingSID.".mp3?Download=true";

    if(!@copy($remotefile,'./downloaded.mp3')) {
        $errors= error_get_last();
        echo "COPY ERROR: ".$errors['type']."<br />";
        echo "<br />\n".$errors['message'];
    } else {
        echo "File copied from remote!<br />";
    }

    // set the path to the sound file
    $file = '@'.realpath(dirname(__FILE__)).'/'.'downloaded.mp3';

    // SoundCloud stuff

    // create a new SoundCloud Object...
    $soundcloud = new Services_Soundcloud('8c2973e42617de13c93c6d601b018b16', '6a56c849d46a4a650523de87701b2108', null);
    // and get an authentication token bypassing the Oauth connect flow
    $soundcloud->credentialsFlow('your-soundcloud-username','your-soundcloud-password');

    // create the track meta data
    $track = array(
        'track[title]' => $recordingSID,
        'track[tag_list]' => $tags,
        'track[asset_data]' => $file,
        'track[sharing]' => 'private' //'public'
    );

    echo '<pre>'.print_r($track,1).'</pre>';

    // try to upload it to SoundCloud
    try {
        $response = $soundcloud->post('/tracks', $track);
    } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
        exit($e->getMessage());
    }
} else {
    echo "You need to provide a recording sid: e.g. wwww.yourserver.com/save2sc.php?recid=xxxxxxxxxxxx&tag=oral-histories";
}
