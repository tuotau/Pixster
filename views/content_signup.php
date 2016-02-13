<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	<div id="login_container">
		<h1>Welcome!</h1>
		<h2 class="clearfix">First we need your information:</h2>
		<br class="clearfix"/>
		<span class="err">
		<?php
			echo validation_errors()."</span>";
			$field = array(
				'name' => 'signup_form',
				'id' => 'signup_form',
			);
			echo form_open("signup", $field);
			$field = array(
				'name' => 'username',
				'id' => 'username',
				'placeholder' => 'Your username',
			);
			echo form_input($field, set_value('username')).'<br/><div id="password_div">';
			$field = array(
				'name' => 'password',
				'id' => 'password',
				'placeholder' => 'Your password',
			);
			echo form_password($field)."</div>";
			$field = array(
				'name' => 'email',
				'id' => 'email',
				'placeholder' => 'Your email',
			);
			echo form_input($field, set_value('email'))."<br/>";
			echo form_submit("submit", 'Sign up!');
			echo form_close();
			echo '<a href="'.base_url().'index.php/login"> Or log in! </a>';
		?>
	</div>
</div>
