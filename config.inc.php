<?php
/* ===================== Database Settings =====================
 * Database from SimpleClans2 (Same values as in your config.yml)
 */
$dbhost = 'mc.realpvp.eu';
$dbport = 3306;
$dbuser = 'ni16467_1_DB';
$dbpass = '18WMpsph';
$dbname = 'ni16467_1_DB';

/* ===================== Website Settings =====================
 * $sitelogo <- There you can set your logo. If you haven't one
 *              just leave it empty.
 * $sitename <- This only appears if the $sitelogo variable is
 *              empty.
 */
$sitelogo = "";
$sitename = "SimpleClansStats2";

/* ======================== Kill Weights ========================
 * Can be found arround line 42 in your config.yml.
 * Default values already set, no need to change.
 */
$civ = 1.0;   // = civilian: 0.5 
$neu = 1.0;   // = neutral: 1.0
$riv = 2.0;   // = rival: 2.0

/* ======================= DynMap Settings =======================
 * Here you can set your DynMap URL.
 * If you don't need it just leave 'none'.
 * May be broken, I haven't tested, as I don't use.
 * Contact me if you have issues: l.postiglione@gmx.at
 */
$dynmap = 'none'; //Example: '92.51.171.14:8123'

/* ====== End of Configuration (DO NOT EDIT BELOW THIS LINE) ====== */
@$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);
if ($db->connect_errno) {
    echo $db->connect_error;
    exit();
}
$db->set_charset("UTF8");
?>