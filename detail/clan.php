<?php
error_reporting(E_ERROR);
require_once '../config.inc.php';
require_once '../includes/functions.inc.php';

$name = $db->real_escape_string($_GET["name"]);

$clanq = $db->query("SELECT * FROM sc2_clans WHERE name = '$name'");
if (!$clanq or $clanq->num_rows != 1) {
    echo '<div class="alert alert-danger">Dieser Clan befindet sich nicht in unserem System!</div>';
}
$info = $clanq->fetch_object();

$memberq = $db->query("SELECT *, IF (deaths = 0 AND (civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv) = 0, 0, IF(civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, 1) / IF( deaths, deaths, 1)) AS kdr, (SELECT online FROM online_players WHERE player = sc2_players.name) AS online FROM sc2_players WHERE clan = " . $info->id);
if (!$memberq && !empty($db->error) && $_SESSION["username"] == "LegendaryCruzer") {
    echo '<div class="alert alert-danger">' . $db->error . '</div>';
}

$clankdr = 0;
while ($mem = $memberq->fetch_array(MYSQLI_ASSOC)) {
    $members[] = array("name" => $mem["name"], "online" => $mem["online"]);
    $clankdr = $clankdr + $mem["kdr"];
    if ($mem["leader"] == "1") {
        $clanleader = array("name" => $mem["name"], "id" => $mem["id"]);
    }
}
$flags = json_decode($info->flags);
?>
<table width="100%">
    <tbody>
        <tr>
            <td valign="top">
                <h3>Members</h3>
                <table class="table table-striped">
                    <tbody>
                        <?php
                        foreach ($members as $member) {
                            echo '<tr>';
                            echo '<td><img src="images/avatar.php?name=' . $member["name"] . '"></td>';
                            echo '<td><a data-toggle="modal" onclick="ajaxModal(\'' . $member["name"] . '\', \'player\');" href="#Detail">' . $member["name"] . '</a></td>';
                            echo '<td>';
                            echo ($member["online"] == 1) ? '<span class="text-success">Online</span>' : '<span class="text-danger">Offline</span>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <h3>Info</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td><?php echo $info->name; ?></td>
                        </tr>
                        <tr>
                            <th>Clantag</th>
                            <td><?php echo addcolors($info->tag); ?></td>
                        </tr>
                        <tr>
                            <th>Verified</th>
                            <td><?php echo ($info->verified == "1") ? "Ja" : "Nein"; ?></td>
                        </tr>
                        <tr>
                            <th>Founded</th>
                            <td><?php echo date("j. M Y", strtotime($info->founded)); ?></td>
                        </tr>
                        <tr>
                            <th>Leader</th>
                            <td><?php echo '<a data-toggle="modal" onclick="ajaxModal(\'' . $clanleader["name"] . '\', \'player\');" href="#Detail">' . $clanleader["name"] . '</a>'; ?></td>
                        </tr>
                        <tr>
                            <th>Members</th>
                            <td><?php echo count($members); ?></td>
                        </tr>
                        <tr><td colspan="2"><br></td></tr>
                        <tr>
                            <th>Balance</th>
                            <td><?php echo number_format($info->balance, 0, ".", " "); ?> MineCoins</td>
                        </tr>
                        <tr>
                            <th>KDR</th>
                            <td><?php echo round($clankdr, 1); ?></td>
                        </tr>
                        <tr>
                            <th>Allies</th>
                            <td><?php echo empty($info->allies) ? "No allies" : $info->allies; ?></td>
                        </tr>
                        <tr>
                            <th>Rivals</th>
                            <td><?php echo empty($info->rivals) ? "No rivals" : $info->rivals; ?></td>
                        </tr>
                        <tr>
                            <th>Wars</th>
                            <td><?php echo empty($info->warring) ? "No wars" : $info->warring; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>