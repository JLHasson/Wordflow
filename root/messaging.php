<form action="javascript:sendPM();" name="pmform" id="pmform" method="post">
        	<font size="+1">Sending Message to <strong><em><?php echo "$firstname $lastname"; ?></em></strong><br /><br />
        	Subject:
        	<input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;" />
        	Message:
        	<textarea name="pmTextArea" id="pmTextArea" rows="8" style="width:98%;"></textarea>
        	<input name="pm_sender_id" id="pm_sender_id" type="hidden" value="<?php echo $_SESSION['idx'];?>" />
        	<input name="pm_sender_name" id="pm_sender_name" type="hidden" value="<?php echo $_SESSION['firstname'];?>" />
        	<input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $id ;?>" />
			<input name="pm_rec_name" id="pm_rec_name" type="hidden" value="<?php echo $firstname ;?>" />
        	<br />
        	<input name="pmSubmit" type="submit" value="Submit" /> or <a href="#" onclick="return false" onmousedown="javascript:toggleInteractContainers('messages');">Close</a>
        	</form>