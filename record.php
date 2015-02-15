<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$recording = $_REQUEST['RecordingUrl'];
$duration = $_REQUEST['RecordingDuration'];
?>
<Response>
    <Say>Thanks for calling. Your message was <?php echo $duration; ?> seconds long. Here's the message you left.</Say>
    <Play><?php echo $recording; ?></Play>
</Response>