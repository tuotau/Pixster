<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
		<?php
		echo form_open('admin_users');
		echo form_hidden('submit', 'submit');
		?>
		<table id="user_table">
		<tr><td>Id</td><td>Username</td><td>Delete</td></tr>
		<?php
			foreach($users->result() as $row)
				echo "<tr><td>".$row->user_id."</td><td>".$row->username."</td><td>".form_submit("user_".$row->user_id, 'Delete user')."</td></tr>";
		?>
		</table>
	</div>
</div>
