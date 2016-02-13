<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	<div id="login_container">
		<h1>Welcome!</h1>
		<h2 class="clearfix">Log in:</h2>
		<br class="clearfix"/>
		<span class="err">
		<?php
			echo validation_errors()."</span>";
			$field = array(
				'name' => 'login_form',
				'id' => 'login_form',
			);
			echo form_open("login", $field);
			$field = array(
				'name' => 'username',
				'id' => 'username',
				'placeholder' => 'Your username',
			);
			echo form_input($field, set_value('username'))."<br/>";
			$field = array(
				'name' => 'password',
				'id' => 'password',
				'placeholder' => 'Your password',
			);
			echo form_password($field)."<br/>";
			echo form_submit("submit", 'Log in!');
			echo form_close();
			echo '<a href="'.base_url().'index.php/signup"> Or sing up! </a>';
		?>
	</div>
</div>
