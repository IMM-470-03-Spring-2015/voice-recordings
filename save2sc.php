<?php
// must include a Twilio recording id to continue
if( isset($_REQUEST["recid"]) && !empty($_REQUEST["recid"]) ) {
    
    // include the SoundCloud library
    require('Services/Soundcloud.php');

    // Twilio account info & the recording id to download
    $accountSID = 'ACc97cde1b267c161a9e1d2f916b75d22b';
    $recordingSID = htmlspecialchars($_REQUEST["recid"]);
    
    // sparse the optional tag paramentpace seperated list of tags
    $tags = ( isset($_REQUEST["tag"]) && !empty($_REQUEST["tag"]) ) ? $_REQUEST["tag"] : "general" ;

    // built the recording url to download from twilio
    $remotefile = "https://api.twilio.com/2010-04-01/Accounts/".$accountSID."/Recordings/".$recordingSID.".mp3?Download=true";
    
    // download from Twilio
    // use cuRL to download it
    $ch = curl_init($remotefile);
    $fp = fopen('./downloaded.mp3', 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    
    // upload to SoundCloud
    // set the path to the downloaded file to upload it
    $file = '@'.realpath(dirname(__FILE__)).'/'.'downloaded.mp3';

    // SoundCloud stuff
    // create a new SoundCloud Object using the client id & secret id
    $soundcloud = new Services_Soundcloud('8c2973e42617de13c93c6d601b018b16', '6a56c849d46a4a650523de87701b2108', null);
    // and get an authentication token using SOund CLoud uername & password
    $soundcloud->credentialsFlow('thomesoni@gmail.com','0D1NRULEs');

    // set the track meta data
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
// user didn't supply a recording id to download, provide usage notes
} else {
    echo "You need to provide a recording sid: e.g. http://".$_SERVER['SERVER_NAME']."".$_SERVER['PHP_SELF']."?recid=xxxxxxxxxxxx&tag=mytag%2ndtag";
}
