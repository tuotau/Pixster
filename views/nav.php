<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="nav_bar">
	<ul id="nav_buttons">
		<li><a href="<?php echo base_url()."index.php/main/";?>"> Front page</a></li>
		<?php if($login){
				echo '<li><a href="'.base_url().'index.php/upload"> Upload image!</a></li>';
				
				if($this->model_user->userId() == 1){
					echo '<li><a href="'.base_url().'index.php/user"> User page</a></li>';
					echo '<li><a href="'.base_url().'index.php/admin_users"> Administrate users</a></li>';
				}
				else
					echo '<li><a href="'.base_url().'index.php/user"> User page</a></li>';
				echo '<li class="abs_right"><a href="'.base_url().'index.php/main/logout"> Logout</a></li>';
			}
			else
				echo '<li class="abs_right"><a href="'.base_url().'index.php/login"> Log In!</a></li>';
		?>
	</ul>
</div>
