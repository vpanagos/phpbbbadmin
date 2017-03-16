<?php require('header.inc.php'); ?>

<h1>Server information</h1>

<table class="table table-hover">
	<tbody>
		<tr>
			<td><strong>BBB Server</strong></td>
			<td><?php echo $hostname; ?></td>
		</tr>
		<tr>
			<td><strong>Salt</strong></td>
			<td><?php echo $salt; ?></td>
		</tr>
		<tr>
			<td><strong>Allowed ip addresses</strong></td>
			<td><?php foreach ($allowedips as &$ip) { echo $ip."<br>"; } ?></td>
		</tr>
		<tr>
			<td><strong>Your ip address</strong></td>
			<td><?php echo $remoteip; ?></td>
		</tr>
	</tbody>
</table>


<?php require('footer.inc.php'); ?>
