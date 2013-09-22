<p class="text-center"><img src="assets/img/SimpleClansStats2Logo.png"></p>
<hr>
<div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal" style='margin:0'>
            <dt>Member</dt>
            <dd>The player's name.</dd>
            <dt>Leader</dt>
            <dd>Leder or Member.</dd>
            <dt>Civilian Kills</dt>
            <dd>Players in no clan at all.</dd>
            <dt>Neutral Kills</dt>
            <dd>Other Clan Members who are not in a rival clan.</dd>
            <dt>Rival Kills</dt>
            <dd>Rival Players in a Rival Clan.</dd>
            <dt>Deaths</dt>
            <dd>Amount of times the player died.</dd>
            <dt>KDR</dt>
            <dd>Kill Death Ratio.</dd>
        </dl>
    </div>
    <div class="col-md-6">
        <p>
            <b>KDR is calculated with the following formula:</b><br>
            ((Rival_Kills x <?php echo $riv; ?>)+(Neutral Kills x <?php echo $neu; ?>)+(Civilian Kills x <?php echo $civ; ?>) / Deaths )
        </p>
    </div>
</div>
<br><br>