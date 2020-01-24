<!DOCTYPE HTML>
<html>
	<head>
		<title>Garagentorsteuerung</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
                <meta http-equiv="refresh" content="30">
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

<?php
if(isset($_REQUEST['action'])) {
  if($_REQUEST['action'] == 'toggle') {
    // Taster ausloesen
    $toggle = true;

    $theaders = array("Content-Type: application/json", "Accept: application/json", "Authorization: FlespiToken TOKEN_HIER_EINFUEGEN");
    $data = '{"payload":"on","topic":"shellies/shelly1-SHELLYID/relay/0/command","type":2}';
    $tch = curl_init();
    curl_setopt( $tch, CURLOPT_HTTPHEADER, $theaders );
    curl_setopt( $tch, CURLOPT_URL, 'https://flespi.io/mqtt/messages' );
    curl_setopt( $tch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $tch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $tch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $tch, CURLOPT_POSTFIELDS, $data );
    $tresponse = curl_exec($tch);
    curl_close($tch);
  }
  else {
    $toggle = false;
  } 
}
else {
  $toggle = false;
}
echo '<header id="header"><h1>Status</h1><p>';
$headers = array("Accept: application/json", "Authorization: FlespiToken TOKEN_HIER_EINFUEGEN");
$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_URL, 'https://flespi.io/mqtt/messages/shellies%2Fshelly1-SHELLYID%2Finput%2F0?data=%7B%22recursive%22%3Atrue%7D' );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$response = curl_exec($ch);
curl_close($ch);
$json = json_decode($response, true);
$status = $json['result'][0]['payload'];
if ($status == '1') {
  echo "Die Garage ist geschlossen.</p>";
}
elseif ($status == '0') {
  echo "Die Garage ist offen.</p>";
}
else {
  echo "Fehler.<br>";
}
echo '</header>';
echo '<form id="signup-form" method="post"><input type="hidden" name="action" value="toggle"/><input type="submit" value="Taster bet&auml;tigen" /></form>';
if ($toggle == true) {
  echo '<header id="header"><h5>Taster wurde bet&auml;tigt</h5></header>';
} else {
  echo '<header id="header"><h5>&nbsp;</h5></header>';
}
?>

		<!-- Footer -->
			<footer id="footer">
				<ul class="copyright">
					<li>&copy; 2019.</li>
				</ul>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/main.js"></script>

	</body>
</html>
