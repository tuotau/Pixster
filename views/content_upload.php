<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	<div id="login_container">
		<h2>Upload your own image!</h2>
		<br class="clearfix"/>
		<span class="err">
		<?php
			echo validation_errors()."</span>";
			$field = array(
				'name' => 'upload_form',
				'id' => 'upload_form',
			);
			echo form_open_multipart('upload/do_upload', $field);
			$field = array(
				'name' => 'title',
				'id' => 'title',
				'placeholder' => 'Give a title to your image!',
			);
			echo form_input($field, set_value('title'))."<br/>";
			echo $error;
		?>

		<input type="file" name="userfile" size="20" /><br />
		<?php
			$field = array(
				'name' => 'description',
				'id' => 'description',
				'placeholder' => 'Your description!',
			);
			echo form_textarea($field, set_value('description'))."<br/>";
		?>
		<br /><br />

		<input type="submit" value="Upload" />

		</form>
	</div>
</div>

<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						