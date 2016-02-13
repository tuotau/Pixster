<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	<div id="login_container">
		<h2>Change your registeration information:</h2><br/>
		You can leave any field empty except your old password.<br/>
		Your current username and email are shown in the fields.<br/>
		<br class="clearfix"/>
		<span class="err">
		<?php
			echo validation_errors()."</span>";
			$field = array(
				'name' => 'signup_form',
				'id' => 'signup_form',
			);
			echo form_open("user", $field);
			$field = array(
				'name' => 'username',
				'id' => 'username',
				'placeholder' => $this->session->userdata('username'),
			);
			echo form_input($field, set_value('username')).'<br/><div id="password_div">';
			$field = array(
				'name' => 'password',
				'id' => 'password',
				'placeholder' => 'Your new password',
			);
			echo form_password($field)."</div>";

			$field = array(
				'name' => 'email',
				'id' => 'email',
				'placeholder' => $this->session->userdata('email'),
			);
			echo form_input($field, set_value('email'))."<br/>";
			$field = array(
				'name' => 'old_password',
				'id' => 'old_password',
				'placeholder' => 'Your old password',
			);
			echo form_password($field)."<br/>";
			echo form_submit("submit", 'Update!');
			echo form_close();
		?>
	
		<?php
		/*echo $this->session->userdata('user_id').$this->session->userdata('username').$this->session->userdata('email');*/
		?>
	</div>
</div>
