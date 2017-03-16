<?php require('header.inc.php'); ?>
<?php
$meetingid=$_GET['id'];
?>

<h1><?php echo $meetingid; ?></h1>



<?php
$bbbaction="getMeetingInfo";
$parameters="random=432874329847&meetingID=$meetingid";
$parameters=str_replace(" ","%20",$parameters);


$checksum=sha1("${bbbaction}${parameters}${salt}");

$url="http://{$hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";

$xml_str = file_get_contents($url,0);
$xmlarr=xml2array($xml_str);

//print_r($xmlarr);

$returncode=$xmlarr['response']['returncode'];

if ($returncode!="SUCCESS") {
	echo "<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-warning-sign' aria-hidden='true'></span> Παρουσιάστηκε κάποιο πρόβλημα</div>";
	require('footer.inc.php');
	die();
}

?>
<h2>Information</h2>
<table class="table table-hover">
	<tbody>
		<tr><td><strong>Meeting name</strong></td><td><?php echo $xmlarr['response']['meetingName']; ?></td></tr>
		<tr><td><strong>Meeting id</strong></td><td><?php echo $xmlarr['response']['meetingID']; ?></td></tr>
		<tr><td><strong>Internal id</strong></td><td><?php echo $xmlarr['response']['internalMeetingID']; ?></td></tr>
		<tr><td><strong>Create date</strong></td><td><?php echo $xmlarr['response']['createDate']; ?></td></tr>

		<tr><td><strong>Attendee password</strong></td><td><?php echo $xmlarr['response']['attendeePW']; ?></td></tr>
		<tr><td><strong>Moderator password</strong></td><td><?php echo $xmlarr['response']['moderatorPW']; ?></td></tr>
		<tr><td><strong>Participant count</strong></td><td><?php echo $xmlarr['response']['participantCount']; ?></td></tr>
		<tr><td><strong>Max users</strong></td><td><?php echo $xmlarr['response']['maxUsers']; ?></td></tr>
	</tbody>
</table>

<?php


echo "<h2>Attendees</h2>";
echo "<table class='table table-hover'>";
echo "<thead>";
echo "<tr><th>#</th><th>user id</th><th>full name</th><th>role</th><th>isPresenter</th><th>isListeningOnly</th><th>hasJoinedVoice</th><th>hasVideo</th></tr>";
echo "</thead>";
foreach ($xmlarr as $meeting) {

	$attendees=$xmlarr['response']['attendees'];

	$i=0;
	foreach ($attendees as $attendee) {
		foreach ($attendee as $m) {
			$i++;
			$userid=$m['userID'];
			$fullname=$m['fullName'];
			$role=$m['role'];
			$ispresenter=$m['isPresenter'];
			$islisteningonly=$m['isListeningOnly'];
			$hasjoinedvoice=$m['hasJoinedVoice'];
			$hasvideo=$m['hasVideo'];


			echo "<tr>";
			echo "<td>$i</td>";
			echo "<td>$userid</td>";
			echo "<td>$fullname</td>";
			echo "<td>$role</td>";

			echo "<td>".(($ispresenter=="true")?"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>":"")."</td>";
			echo "<td>".(($islisteningonly=="true")?"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>":"")."</td>";
			echo "<td>".(($hasjoinedvoice=="true")?"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>":"")."</td>";
			echo "<td>".(($hasvideo=="true")?"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>":"")."</td>";



			echo "</tr>";
		}
	}
}
echo "</table>";
?>

<?php require('footer.inc.php'); ?>
            
