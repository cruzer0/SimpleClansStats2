<?php
error_reporting(E_ERROR);
require_once 'config.inc.php';
require_once 'includes/functions.inc.php';
?>
<!DOCTYPE html>
<head>
    <title><?php echo $sitename; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- Le JavaScript -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detail.js"></script>
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
                <a class="navbar-brand" href="#"><?php echo empty($sitelogo) ? $sitename : '<img src="' . $sitelogo . '" alt="' . $sitename . '">'; ?></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?show=home">Home</a></li>
                    <li><a href="index.php?show=clans">Clans</a></li>
                    <li><a href="index.php?show=players">Players</a></li>
                    <li><a href="index.php?show=info">Info</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
        <?php
        switch ($_GET['show']) {
            case "info":
                include("includes/info.php");
                break;
            case "players":
                include("includes/players.php");
                break;
            case "clans":
                include("includes/clans.php");
                break;
            case "home":
                include("includes/home.php");
                break;
            default:
                include("includes/home.php");
                break;
        }
        ?>
    </div>
    <div id="footer">
        <div class="container">
            <p class="text-muted credit"><a href='http://dev.bukkit.org/server-mods/simpleclansstats' target='_blank'>SimpleClansStats2</a> by <a href="http://www.postiglione.at/" target="_blank">Luca Postiglione</a>.</p>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Detail" tabindex="-1" role="dialog" aria-labelledby="DetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
</body>
</html>