<?php
require('header.inc.php');
require('settings.inc.php');
?>

<h2>Active sessions</h2>
<p>

<?php


$bbbaction="getMeetings";
$parameters="random=432874329847";
$checksum=sha1("${bbbaction}${parameters}${salt}");
$url="http://{$hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";


$xml_str = file_get_contents($url,0);
$xmlarr=xml2array($xml_str);

echo "<table>";
echo "<tr><th>meeting id</th><th>attendee pw</th><th>moderator pw</th><th>running</th><th>actions</th></tr>";
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
			$checksum=sha1("${bbbaction}${parameters}${salt}");
			$urljoin="http://${hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";

			$bbbaction="getMeetingInfo";
			$parameters="meetingID=${meetingid}&password=${moderatorpw}";
			$checksum=sha1("${bbbaction}${parameters}${salt}");
			$urlinfo="http://${hostname}/bigbluebutton/api/${bbbaction}?${parameters}&checksum=${checksum}";

			echo "<tr align=center><td align=left style='border=color:#aaaaaa'>$meetingid</td><td>$attendeepw</td><td>$moderatorpw</td><td>$running</td>";
			echo "<td><a href=\"${urljoin}\">join</a> <a href=\"${urlinfo}\">info</a> <a href=\"${urlend}\">end</a></td>";
			echo "</tr>";
		}
	}

}
echo "</table>";
?>

<?php require('footer.inc.php'); ?>
            
