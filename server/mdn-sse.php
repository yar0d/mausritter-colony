<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");

function sendDice($data) {

}

$time = date('r');
echo "event: ping\n";
// echo "id: ", rand(1, 1000), "\n";
// echo "retry: 15000\n"; // Retry every 15 secondes
echo "data: {\"time\": \"$time\"}\n";

// Send a simple message at random intervals.

// $counter--;

// if (!$counter) {
  // echo 'data: This is a message', "\n\n";
//   $counter = rand(1, 10); // reset random counter
// }

// flush the output buffer and send echoed messages to the browser

// while (ob_get_level() > 0) {
//   ob_end_flush();
// }
echo "\n\n"; // End of message

@ob_flush();
flush();
