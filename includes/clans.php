<div class="page-header">
    <h1>Clans</h1>
</div>
<?php
$clanq = $db->query("SELECT *, (SELECT name FROM sc2_players WHERE clan = sc2_clans.id AND leader = 1) AS leader, IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id) = 0 AND (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id) = 0, 0, ROUND(IF ( (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id),  (SELECT count(attacker_clan) FROM sc2_kills WHERE attacker_clan=sc2_clans.id), 1)/IF ( (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id),  (SELECT COUNT(victim_clan) FROM sc2_kills WHERE victim_clan=sc2_clans.id), 1 ),2)) AS KDR, (SELECT count(clan) FROM sc2_players WHERE clan=sc2_clans.id) AS members FROM sc2_clans ORDER BY KDR DESC");
if (!empty($db->error)) {
    echo '<div class="alert alert-danger">' . $db->error . '</div>';
}
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tag</th>
            <th>Name</th>
            <th>KDR</th>
            <th>Leader</th>
            <th>Members</th>
            <th>Founded</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x = 1;
        while ($row = $clanq->fetch_array(MYSQLI_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $x . '.</td>';
            echo '<td>' . addcolors($row["tag"]) . '</td>';
            echo '<td><a data-toggle="modal" onclick="ajaxModal(\'' . $row["name"] . '\', \'clan\');" href="#Detail">' . $row["name"] . '</a></td>';
            echo '<td>' . $row["KDR"] . '</td>';
            echo '<td><a data-toggle="modal" onclick="ajaxModal(\'' . $row["leader"] . '\', \'player\');" href="#Detail">' . $row["leader"] . '</a></td>';
            echo '<td>' . $row["members"] . '</td>';
            echo '<td>' . $row["founded"] . '</td>';
            echo '</tr>';
            $x++;
        }
        ?>
    </tbody>
</table>