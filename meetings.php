<?php require('header.inc.php'); ?>

<h1>Meetings</h1>

<?php

$bbbaction="getMeetings";
$parameters="random=432874329847";
$checksum=sha1("${bbbaction}${parameters}${salt}");
$url="http://{$hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";

$xml_str = file_get_contents($url,0);
$xmlarr=xml2array($xml_str);

echo "<table class='table table-hover'>";
echo "<thead>";
echo "<tr><th>meeting id</th><th>attendee pw</th><th>moderator pw</th><th>running</th><th>actions</th></tr>";
echo "</thead>";
foreach ($xmlarr as $meeting) {

	$meetings=$xmlarr['response']['meetings'];

	if (isset($meetings['meeting']['meetingID'])) {
		$meetings2['meeting'][0]=$meetings['meeting'];
		$meetings=$meetings2;
	}

	foreach ($meetings as $meeting) {
		foreach ($meeting as $m) {
			$meetingid=$m['meetingID'];

			$attendeepw=$m['attendeePW'];
			$moderatorpw=$m['moderatorPW'];
			$running=$m['running'];

			$bbbaction="join";
			$parameters="fullName=webconfadmin&meetingID=${meetingid}&password=${moderatorpw}";
			$parameters=str_replace(" ","%20",$parameters);
			$checksum=sha1("${bbbaction}${parameters}${salt}");
			$urljoin="http://${hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";

			$bbbaction="getMeetingInfo";
			$parameters="meetingID=${meetingid}&password=${moderatorpw}";
			$parameters=str_replace(" ","%20",$parameters);
			$checksum=sha1("${bbbaction}${parameters}${salt}");
			$urlinfo="http://${hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";



			echo "<tr><td align=left style='border=color:#aaaaaa'>$meetingid</td><td>$attendeepw</td><td>$moderatorpw</td><td>$running</td>";
			echo "<td>";
			echo "<a href=\"${urljoin}\"><button type='button' class='btn btn-default btn-xs' aria-label='Left Align'><span class='glyphicon glyphicon-play' aria-hidden='true'></span></button></a>";
			echo "<a href='info.php?id=$meetingid'><button type='button' class='btn btn-default btn-xs' aria-label='Left Align'><span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span></button></a>";
			echo "<a href=\"javascript:alert('Not yet implemented')\"><button type='button' class='btn btn-default btn-xs' aria-label='Left Align'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></a>";
			echo "</td>";

			echo "</tr>";
		}
	}
}
echo "</table>";
?>

<?php require('footer.inc.php'); ?>
            
