<div class="page-header">
    <h1>Homepage</h1>
</div>
<div class="row">
    <div class="col-md-4">
        <?php
        $top10clanq = $clanq = $db->query("SELECT name, IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id) = 0 AND (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id) = 0, 0, ROUND(IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id),  (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id), 1)/IF ( (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id),  (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id), 1 ),2)) AS KDR, (SELECT count(clan) FROM sc2_players WHERE clan=sc2_clans.id) AS members FROM sc2_clans ORDER BY KDR DESC LIMIT 10");
        if (!empty($db->error)) {
            echo '<div class="alert alert-danger">' . $db->error . '</div>';
        }
        ?>
        <h4>Top 10 Clans</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Members</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 1;
                while ($row = $top10clanq->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $x . '.</td>';
                    echo '<td><a data-toggle="modal" onclick="ajaxModal(\'' . $row["name"] . '\', \'clan\');" href="#Detail">' . $row["name"] . '</a></td>';
                    echo '<td>' . $row["members"] . '</td>';
                    echo '</tr>';
                    $x++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <?php
        $top10playerq = $db->query("SELECT *, IF ( deaths = 0 AND (civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv) = 0, 0, IF(civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, civilian_kills * $civ + neutral_kills * $neu + rival_kills * $riv, 1) / IF( deaths, deaths, 1)) as KDR, (civilian_kills + neutral_kills + rival_kills) AS kills, IF ( clan = '-1', '-1', (SELECT tag FROM sc2_clans WHERE id=sc2_players.clan) ) AS clantag FROM sc2_players order by KDR DESC LIMIT 10");
        if (!empty($db->error)) {
            echo '<div class="alert alert-danger">' . $db->error . '</div>';
        }
        ?>
        <h4>Top 10 Players</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>KDR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 1;
                while ($row = $top10playerq->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $x . '.</td><td>';
                    echo ($row["clan"] != "-1") ? addcolors($row["clantag"]) . " " : NULL;
                    echo '<a data-toggle="modal" onclick="ajaxModal(\'' . $row["name"] . '\', \'player\');" href="#Detail">' . $row["name"] . '</a></td>';
                    echo '<td>' . round($row["KDR"], 1) . '</td>';
                    echo '</tr>';
                    $x++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <?php
        $last10killq = $db->query("SELECT *, (SELECT name FROM sc2_players WHERE attacker = id ) AS `attacker_name`, (SELECT name FROM sc2_players WHERE victim = id ) AS `victim_name` FROM sc2_kills ORDER BY date DESC LIMIT 10");
        if (!empty($db->error)) {
            echo '<div class="alert alert-danger">' . $db->error . '</div>';
        }
        ?>
        <h4>Last 10 Kills</h4>
        <table class="table pvptable">
            <thead>
                <tr>
                    <th>Attacker</th>
                    <th>&nbsp;</th>
                    <th>Victim</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 1;
                while ($row = $last10killq->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<td>';
                    echo ($row["attacker_clan"] != "-1") ? addcolors($row["clantag"]) . " " : NULL;
                    echo '<a class="text-success" data-toggle="modal" onclick="ajaxModal(\'' . $row["attacker_name"] . '\', \'player\');" href="#Detail">' . $row["attacker_name"] . '</a></td>';
                    echo '<td>vs</td>';
                    echo '<td>';
                    echo ($row["victim_clan"] != "-1") ? addcolors($row["clantag"]) . " " : NULL;
                    echo '<a class="text-danger" data-toggle="modal" onclick="ajaxModal(\'' . $row["victim_name"] . '\', \'player\');" href="#Detail">' . $row["victim_name"] . '</a></td>';
                    echo '</tr>';
                    $x++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>