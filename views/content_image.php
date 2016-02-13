<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container" class="center_child">
	
	<?php
		echo "<h2>".$image->caption."</h2>";
		echo '<div id="image_box">';
			if($login && ($userId == $image->user_id || $role == 0)){
				echo '<div id="admin_box">';
					echo 'You can delete this image <br />';
					echo '<button type="button" id="delete" onclick="confirm_delete('."'".$image->image_id."'".', 0)">Delete</button>';
				echo '</div>';
			}
			echo '<div id="image">';
				echo '<a href="'.base_url()."index.php/main".'"><img src="'.base_url()."images/".$image->image_id.'" alt="full_picture"></a>';
			echo '</div>';
			echo '<div id="vote_box">';
				echo '<h3>Like it?</h3>';
				echo '<button type="button" id="plus" '.($login && $vote && $vote == 1 ? 'disabled ="disabled" ' : "").'onclick="'. ($login ? ('vote(1, '."'".$image->image_id."')") : "alert('You must log in to vote!')" ).'">+1</button>';
				echo '<button type="button" id="minus" '.($login && $vote && $vote == -1 ? 'disabled ="disabled" ' : "").'onclick="'. ($login ? ('vote(-1, '."'".$image->image_id."')") : "alert('You must log in to vote!')" ).'">-1</button><br />';
				echo '<input type="text" name="points" id="points" disabled="disabled" value="'.$image->vote.'">';
			echo '</div>';
		echo '</div>';
		echo  '</br><div id="grey">'.$image->description . "</div><br />";
		echo  "<div> This picture was sent by $username (created: ".$image->created.")". "</div>";
		echo  '<div id="comments">';
			if($comments->num_rows() == 0)
				echo '<p> No comments posted yet. Be first one to do so!</p>';
			else{
				foreach($comments->result() as $row){
					echo '<h3>'.$row->username.':</h3> '.$row->comment.'<small> (commented:'.$row->created.')</small>';
					if($login && ($userId == $image->user_id || $userId == 1)){
						echo '<button type="button" class="delete_comment" onclick="confirm_delete('."'".$row->comment_id."'".', 1)">Delete this comment</button><br />';
					}
					echo "<br />";
				}
			}
		if($login){
			echo '</div><span class="err">';
			echo validation_errors()."</span>";
			$field = array(
				'name' => 'comment_form',
				'id' => 'comment_form',
			);
			$hidden = array('image_id' => $image->image_id);
			echo form_open("image/".$image->image_id, $field, $hidden);
			$field = array(
				'name' => 'comment',
				'id' => 'comment',
				'placeholder' => 'Your comment',
				'rows' => 3,
				'cols' => 50
			);
			echo form_textarea($field, set_value('comment'));
			echo form_submit('submit', 'Submit comment!');
			echo form_close();
		}
	?>
</div>
