<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
	<?php
		$i=0;
		foreach($images as $row){
			echo '<a href="'.$row.'"><img src="'.$thumbnails[$i].'" alt="pic_'.$i.'"></a>';
			$i++;
		}
	?>
</div>
