<?php
error_reporting(E_ERROR);
require_once '../config.inc.php';
require_once '../includes/functions.inc.php';

$name = $db->real_escape_string($_GET["name"]);

$playerq = $db->query("SELECT *, IF (deaths = 0 AND (civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv) = 0, 0, IF(civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, 1) / IF( deaths, deaths, 1)) AS kdr, (civilian_kills + neutral_kills + rival_kills) AS kills, IF ( clan = '-1', '-1', (SELECT name FROM sc2_clans WHERE id=sc2_players.clan) ) AS clanname FROM sc2_players WHERE name LIKE '$name'");
if (!$playerq or $playerq->num_rows != 1) {
    echo '<div class="alert alert-danger">This player was not found!</div>';
    if (!empty($db->error)) {
        echo '<div class="alert alert-danger">' . $db->error . '</div>';
    }
} else {
    $info = $playerq->fetch_object();
    $flags = json_decode($info->flags);
    $lastclans = $flags->pastClans;
    ?>
    <table width="100%">
        <tbody>
            <tr>
                <td valign="top" width="150"><img src="images/skin.php?name=<?php echo $name; ?>&size=8"></td>
                <td>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <td><?php echo $info->name; ?></td>
                        </tr>
                        <tr>
                            <th>Join Date</th>
                            <td><?php echo date("j. M Y", strtotime($info->join_date)); ?></td>
                        </tr>
                        <tr>
                            <th>Last Seen</th>
                            <td><?php echo date("j.n.Y G:i", strtotime($info->last_seen)); ?></td>
                        </tr>
                        <tr>
                            <th>KDR</th>
                            <td><?php echo round($info->kdr, 1); ?></td>
                        </tr>
                        <tr>
                            <th>Rival Kills</th>
                            <td><?php echo $info->rival_kills; ?></td>
                        </tr>
                        <tr>
                            <th>Neutral Kills</th>
                            <td><?php echo $info->neutral_kills; ?></td>
                        </tr>
                        <tr>
                            <th>Civilian Kills</th>
                            <td><?php echo $info->civilian_kills; ?></td>
                        </tr>
                        <tr>
                            <th>All Kills</th>
                            <td><?php echo $info->kills; ?></td>
                        </tr>
                        <tr>
                            <th>Deaths</th>
                            <td><?php echo $info->deaths; ?></td>
                        </tr>
                        <tr>
                            <th>Clan</th>
                            <td><?php echo ($info->clanname == "-1") ? "Kein Clan" : $info->clanname; ?> </td>
                        </tr>
                        <?php if (!empty($lastclans)) { ?>
                            <tr>
                                <th>Past Clans</th>
                                <td>
                                    <?php
                                    $bool = true;
                                    foreach ($lastclans as $oldclan) {
                                        echo ($bool) ? addcolors($oldclan) : ", " . addcolors($oldclan);
                                        $bool = false;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
            <tr>
                <td width="50%" valign="top">
                    <?php
                    $killtypes = array("Civillian", "Neutral", "Rival");
                    $last5kills = $db->query("SELECT *, (SELECT tag FROM sc2_clans WHERE id = victim_clan) AS victim_clantag, (SELECT name FROM sc2_players WHERE victim = id ) AS `victim_name` FROM sc2_kills WHERE attacker = " . $info->id . " ORDER BY date DESC LIMIT 5");
                    if (!empty($db->error)) {
                        echo '<div class="alert alert-danger">' . $db->error . '</div>';
                    }
                    ?>
                    <h4>Last 5 Kills</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Victim</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $last5kills->fetch_array(MYSQLI_ASSOC)) {
                                echo '<tr><td>';
                                echo ($row["victim_clan"] != "-1") ? addcolors($row["victim_clantag"]) . " " : NULL;
                                echo '<a class="text-success" data-toggle="modal" onclick="ajaxModal(\'' . $row["victim_name"] . '\', \'player\');" href="#Detail">' . $row["victim_name"] . '</a></td>';
                                echo '<td>' . $killtypes[$row["type"]] . '</td>';
                                echo '</tr>';
                                $x++;
                            }
                            ?>
                        </tbody>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <?php
                    $last5deaths = $db->query("SELECT *, (SELECT tag FROM sc2_clans WHERE id = attacker_clan) AS attacker_clantag, (SELECT name FROM sc2_players WHERE attacker = id ) AS `attacker_name` FROM sc2_kills WHERE victim = " . $info->id . " ORDER BY date DESC LIMIT 5");
                    if (!empty($db->error)) {
                        echo '<div class="alert alert-danger">' . $db->error . '</div>';
                    }
                    ?>
                    <h4>Last 5 Deaths</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Attacker</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $last5deaths->fetch_array(MYSQLI_ASSOC)) {
                                echo '<tr><td>';
                                echo ($row["victim_clan"] != "-1") ? addcolors($row["attacker_clantag"]) . " " : NULL;
                                echo '<a class="text-danger" data-toggle="modal" onclick="ajaxModal(\'' . $row["attacker_name"] . '\', \'player\');" href="#Detail">' . $row["attacker_name"] . '</a></td>';
                                echo '<td>' . $killtypes[$row["type"]] . '</td>';
                                echo '</tr>';
                                $x++;
                            }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>