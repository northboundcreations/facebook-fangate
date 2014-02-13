<?php 
require 'src/facebook.php';
$app_id = "XXXXXXXXXXXXXX"; //your id
$app_secret = "XXXXXXXXXXXXXX"; //your app secret
$facebook = new Facebook(array(
'appId' => $app_id,
'secret' => $app_secret,
'cookie' => true
));

$signed_request = $facebook->getSignedRequest();
function parsePageSignedRequest() {
    if (isset($_REQUEST['signed_request'])) {
      $encoded_sig = null;
      $payload = null;
      list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
      $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
      $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
      return $data;
    }
    return false;
  }
?>
<html>
<head>

<title>Facebook Fangate</title>

<link rel="stylesheet" type="text/css" media="all" href="style.css" />

</head>
<body>

	<div id="fb-root"></div>
    <script src="https://connect.facebook.net/en_US/all.js"></script>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId : 'XXXXXXXXXXXXXX', //Your facebook APP here
          cookie : true, // enable cookies to allow the server to access the session
		  xfbml  : true  // parse XFBML
        });
		FB.Canvas.setAutoGrow();		
      }
    </script>

	<?php
	//show content if page is liked
	if($signed_request = parsePageSignedRequest()) 
	{
		if($signed_request->page->liked) {
	?>

		<div class=header">

		</div>

		<div class=main">

			<img src="after.jpg" />

		</div>

		<div class=footer">

		</div>
		
		<?php
			} 
			else 
			{
		?>

		<div class=header">

		</div>

		<div class=main">

			<img src="before.jpg" />

		</div>

		<div class=footer">
	
		</div>

	<?php	
		}//end if
	}//end if	
	?>

</body>
</html>