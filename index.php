<?
require_once 'config.inc.php';
?>
<!DOCTYPE html>
<head>
    <title><? echo $sitename; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- Le JavaScript -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/stats.js"></script>
</head>

<body>
    <div class="container">
        <div class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><? echo empty($sitelogo) ? $sitename : '<img src="' . $sitelogo . '" alt="' . $sitename . '">'; ?></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<? echo $_SERVER["PHP_SELF"]; ?>?show=home">Home</a></li>
                    <li><a href="<? echo $_SERVER["PHP_SELF"]; ?>?show=clans">Clans</a></li>
                    <li><a href=="<? echo $_SERVER["PHP_SELF"]; ?>?show=players">Players</a></li>
                    <li><a href=="<? echo $_SERVER["PHP_SELF"]; ?>?show=Info">Info</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
        <?php
        switch ($_GET['content']) {
            case "showInfo":
                include("showInfo.php");
                break;
            case "showPlayers":
                include("showPlayers.php");
                break;
            case "showClans":
                include("showClans.php");
                break;
            case "showHome":
                include("showDefault.php");
                break;
            default:
                include("showDefault.php");
                break;
        }
        ?>
    </div> <!-- /container -->
    <a href='http://dev.bukkit.org/server-mods/simpleclansstats' target='_blank' style='font-size:0.8em;color:black;text-decoration:none;'>SimpleClansStats</a></td>
</body>
</html>


