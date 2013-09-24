<div class="page-header">
    <h1>Players</h1>
</div>
<?php
$playerq = $db->query("SELECT *, IF ( deaths = 0 AND (civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv) = 0, 0, IF(civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, 1) / IF( deaths, deaths, 1)) as KDR, (civilian_kills + neutral_kills + rival_kills) AS kills, IF ( clan = '-1', '-1', (SELECT tag FROM sc2_clans WHERE id=sc2_players.clan) ) AS clantag FROM sc2_players order by KDR DESC");
if (!empty($db->error)) {
    echo '<div class="alert alert-danger">' . $db->error . '</div>';
}
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th colspan="2">Name</th>
            <th>Clan</th>
            <th>KDR</th>
            <th>Kills</th>
            <th>Deaths</th>
            <th>Join Date</th>
            <th>Last Seen</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x = 1;
        while ($row = $playerq->fetch_array(MYSQLI_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $x . '.</td>';
            echo '<td width="40"><img src="images/avatar.php?name=' . $row["name"] . '&size=24"></td>';
            echo '<td><a data-toggle="modal" onclick="ajaxModal(\'' . $row["name"] . '\', \'player\');" href="#Detail">' . $row["name"] . '</a></td>';
            echo ($row["clan"] != "-1") ? '<td>' . addcolors($row["clantag"]) . '</td>' : '<td></td>';
            echo '<td>' . round($row["KDR"], 1) . '</td>';
            echo '<td>' . $row["kills"] . '</td>';
            echo '<td>' . $row["deaths"] . '</td>';
            echo '<td>' . $row["join_date"] . '</td>';
            echo '<td>' . $row["last_seen"] . '</td>';
            echo '</tr>';
            $x++;
        }
        ?>
    </tbody>
</table>