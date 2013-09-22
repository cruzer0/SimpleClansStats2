<div class="page-header">
    <h1>Clans</h1>
</div>
<?php
$clanq = $db->query("SELECT *, IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id) = 0 AND (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id) = 0, 0, ROUND(IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id),  (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id), 1)/IF ( (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id),  (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id), 1 ),2)) AS KDR, (SELECT count(clan) FROM sc2_players WHERE clan=sc2_clans.id) AS members FROM sc2_clans ORDER BY KDR DESC");
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tag</th>
            <th>Name</th>
            <th>KDR</th>
            <th>Mitglieder</th>
            <th>Gegründet</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x = 1;
        while ($row = $clanq->fetch_array(MYSQLI_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $x . '.</td>';
            echo '<td>' . addcolors($row["tag"]) . '</td>';
            echo '<td><a href="index.php?site=clan&id=' . $row["id"] . '">' . $row["name"] . '</a></td>';
            echo '<td>' . $row["KDR"] . '</td>';
            echo '<td>' . $row["members"] . '</td>';
            echo '<td>' . $row["founded"] . '</td>';
            echo '</tr>';
            $x++;
        }
        ?>
    </tbody>
</table>