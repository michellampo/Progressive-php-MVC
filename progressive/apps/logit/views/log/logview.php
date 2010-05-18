<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<base href="<?php echo BASE_URL; ?>" ></base>
		<script type="text/javascript" src="js/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.taconite.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<link rel='stylesheet' type='text/css' href='style.css'></link>
		<!--[if IE]>
			<style type="text/css">
				.ie {
					display: block !important;
				}
			</style>
		<![endif]-->
		<script type="text/javascript">
			var url = '<?php echo BASE_URL; ?>';
			var currentlog = '<?php echo $activeapp; ?>';
		</script>
		<title>Logit - Log analyser</title>
	</head>
	<body>
		<div id="wrapper">
			<div id="main">
				<div id="logo">
					<h1>Logit</h1>
					<div id="sign"></div>
					<h2>Log analyser</h2>
				</div>
				<div id="menu" class="fixable fixed">
					<div id="menu_fixer" class="fixer"><a href="#">Unfix</a></div>
					<ul id="menulist">
						<?php if (count($apps) == 1) { ?>
							<!-- 1 location, show direct all logs -->
							<?php foreach ($apps as $name => $logs): ?>
								<?php foreach ($logs as $log): ?>
									<li><span><a href="#" class="log" title="<?php echo $log; ?>" ><?php echo ucfirst($log); ?></a></span></li>
								<?php endforeach; ?>
							<?php endforeach; ?>
						<?php } else {?>
							<!-- multiple locations, show groupnames with their respective logs -->
							<?php foreach ($apps as $name => $logs): ?>
							<li><span><a href="#" class="loggroup" ><?php echo $name; ?></a></span>
								<ul>
									<?php foreach ($logs as $log => $logtypes): ?>
										<li><span><a href="#" class="log" title="<?php echo $log; ?>" ><?php echo ucfirst($log); ?></a></span></li>
									<?php endforeach; ?>
								</ul>
							</li>
							<?php endforeach; ?>
						<?php } ?>
					</ul>
				 	<ul id="sidebar">
						<li id="cloud">
							<ul>
								<li><span><a href="#" class="action" id="reindex" >Reindex</a></span></li>
							</ul>
						</li>
					</ul>
				</div>
				<div id="body">
			<!-- 	<div class="message post_background">
						<p>Hello, test message</p>
					</div>  -->
					<div class="ie message post_background">
						<p>This site is optimized for other browsers, like firefox</p>
					</div>
					<div class="message post_background alert no-js">
						<p>Please turn on javascript or use a javascript enabled browser for the full experience</p>
					</div>
					<div id="post_1" class="post_background">
						<h1>Lorem ipsum</h1>
						<table>
							<tr><th>Header 1</th><th>Header 2</th><th>Header 3</th></tr>
							<tr><td>1</td><td>2</td><td>3</td></tr>
							<tr><td>4</td><td>5</td><td>6</td></tr>
						</table>
						<p class="post_footer">Generated <?php echo date('j F Y \a\t H:i'); ?></p>
					</div>
					<div class="message post_background">
						<p>Design and logic <span>&#169;</span> Creating Future 2010</p>
					</div>
				</div>
			</div>
			<div id="extrabar" class="fixable fixed">
				<div id="extrabar_fixer" class="fixer"><a href="#">Unfix</a></div>
				<div class="extrabar_widget">
					<h1>Charts</h1>
					<ul>
						<li><a href="#">Lorem ipsum</a></li>
					</ul>
				</div>
				<div class="extrabar_widget">
					<h1>Logs</h1>
					<ul>
						<?php $first = true; foreach($logsforapp as $log): ?>
							<li><input type="radio" value="log<?php echo $log; ?>" name="log" <?php if ($first) { echo 'checked="checked" '; $first = false; } ?> /><label for="log<?php echo $log; ?>" ><?php echo ucfirst($log); ?></label></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="extrabar_widget">
					<h1>Timespan</h1>
					<select id="timespan" >
						<option value="1" >Today</option>
						<option value="3" >Last 3 days</option>
						<option value="7" >Last 7 days</option>
						<option value="30" >Last month</option>
						<option value="all" >All</option>
					</select>
				</div>
			</div>
		</div>
	</body>
</html>
