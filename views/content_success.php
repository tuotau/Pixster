<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	<div id="success">
		<h1><?php echo $success_title ?></h1>
		You will be redirected to the front page after 5 seconds.
	</div>
</div>
<script>$(document).ready(function () {
		delayRedirectFront(<?php echo isset($redirect) ? '"'.$redirect.'"': "" ?>);
});</script>
