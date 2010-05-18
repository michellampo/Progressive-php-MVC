<?php header('Content-type: text/xml'); ?>
<taconite>
	<eval>
		alert('reindexed');
	</eval>
	<remove select="#taconitemessage" /> 
	<prepend select="#body"> 
		<div id="taconitemessage" class="message post_background">
			<p>Log: <?php echo $log; ?> reindexed</p>
		</div>
	</prepend> 
</taconite> 