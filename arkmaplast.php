<?php
$js = filter_input(INPUT_GET, 'js', FILTER_VALIDATE_BOOLEAN);

require "Predis/autoload.php";
$red = new Predis\Client();

$resp = $red->get("arklivemap");

if ($js) {
    header("Content-Type: text/javascript");
    $dat = json_decode($resp, true);
    $map = $dat['map'];
    // For some reason the tribe markers are flipped here but not in the websocket
    $fixedtrib = $dat['tribe_markers'];
    foreach ($fixedtrib as &$mark) {
        list($mark[1], $mark[0]) = [$mark[0], $mark[1]];
    }
    $fixedplay = $dat['marker'];
    foreach ($fixedplay as &$mark) {
        list($mark[1], $mark[0]) = [$mark[0], $mark[1]];
    }
    ?>
var map = <?= json_encode($map) ?>;
var mark = <?= json_encode($fixedplay) ?>;
var tribe_mark = <?= json_encode($fixedtrib) ?>;
var serverclock = <?= json_encode($dat['serverclock']) ?>;

var mapfile = 'images/island.jpg';

var blueObelisk = [25.5, 25.6, 'Blue obelisk'];
var greenObelisk = [59.0, 72.3, 'Green obelisk'];
var redObelisk = [79.8, 17.4, 'Red obelisk'];

var bounds = [
  [-5, -5],
  [105, 105]
];

<?php if($map === 'Ragnarok'){ ?>
mapfile = 'images/ragnarok.jpg';
blueObelisk = [18.1, 17.3, 'Blue obelisk'];
greenObelisk = [57.0, 38.01, 'Green obelisk'];
redObelisk = [35.0, 85.7, 'Red obelisk'];
<?php } else if ($map === 'TheIsland') { ?>
mapfile = 'images/island.jpg';
blueObelisk = [25.5, 25.6, 'Blue obelisk'];
greenObelisk = [59.0, 72.3, 'Green obelisk'];
redObelisk = [79.8, 17.4, 'Red obelisk'];
<?php } else if ($map === 'Valguero_P') { ?>
mapfile = 'images/valguero.jpg';
blueObelisk = [11, 18.9, 'Blue obelisk'];
greenObelisk = [50.2, 77.8, 'Green obelisk'];
redObelisk = [77.9, 18.6, 'Red obelisk'];
<?php } else if ($map === 'CrystalIsles') { ?>
mapfile = 'images/crystal.jpg';
blueObelisk = [27.1, 57.2, 'Blue obelisk'];
greenObelisk = [51.3, 23.9, 'Green obelisk'];
redObelisk = [62.9, 59.2, 'Red obelisk'];
<?php } else if ($map === 'Aberration_P') { ?>
mapfile = 'images/aberration.jpg';
blueObelisk = [18.9, 16.1, 'Blue obelisk'];
greenObelisk = [22.5, 77.8, 'Green obelisk'];
redObelisk = [80.8, 20.3, 'Red obelisk'];
<?php } else if ($map === 'TheCenter') { ?>
mapfile = 'images/center.jpg';
blueObelisk = [50.3, 81, 'Blue obelisk'];
greenObelisk = [35.6, 15.3, 'Green obelisk'];
redObelisk = [8.2, 57.4, 'Red obelisk'];
<?php } else if ($map === 'ScorchedEarth_P') { ?>
mapfile = 'images/scorched.jpg';
blueObelisk = [21.5, 33.5, 'Blue obelisk'];
greenObelisk = [53, 74.3, 'Green obelisk'];
redObelisk = [74, 40.5, 'Red obelisk'];
<?php } else if ($map === 'Extinction') { ?>
mapfile = 'images/extinction.jpg';
blueObelisk = [21.8, 78.2, 'Blue obelisk'];
greenObelisk = [50.6, 29.7, 'Green obelisk'];
redObelisk = [77.6, 76.9, 'Red obelisk'];
<?php } else if ($map === 'Genesis') { ?>
mapfile = 'images/genesis.jpg';
<?php } else if ($map === 'Fjordur') { ?>
mapfile = 'images/fjoerdur.jpg';
blueObelisk = [74.7, 7.9, 'Blue obelisk'];
greenObelisk = [17.7, 80.7, 'Green obelisk'];
redObelisk = [21.5, 67.0, 'Red obelisk'];
<?php } else if ($map === 'Olympus') { ?>
mapfile = 'images/olympus.jpg';
blueObelisk = [38.7, 12.3, 'Blue obelisk'];
greenObelisk = [66.8, 77.2, 'Green obelisk'];
redObelisk = [18.3, 74.9, 'Red obelisk'];
<?php } else if ($map === 'Gen2') { ?>
mapfile = 'images/gen2.jpg';
<?php } else if ($map === 'LostIsland') { ?>
mapfile = 'images/lostisland.jpg';
blueObelisk = [25.2, 34.4, 'Blue obelisk'];
greenObelisk = [62.7, 56.9, 'Green obelisk'];
redObelisk = [28.6, 63.8, 'Red obelisk'];
<?php } else if ($map === 'Caballus_P') { ?>
mapfile = 'images/caballus.jpg';
blueObelisk = [18.8, 17.7, 'Blue obelisk']; // blau2 39.2, 49.3
greenObelisk = [67.3, 37.0, 'Green obelisk'];
redObelisk = [45.0, 88.0, 'Red obelisk'];
<?php } else if ($map === 'TheIsland_WP') { ?>
mapfile = 'images/TheIsland_WP.jpg';
bounds = [
  [7, 7],
  [93, 93]
];
blueObelisk = [25.5, 25.6, 'Blue obelisk'];
greenObelisk = [59.0, 72.3, 'Green obelisk'];
redObelisk = [79.8, 17.4, 'Red obelisk'];
<?php } else if ($map === 'Svartalfheim_WP') { ?>
mapfile = 'images/svartalheim.jpg';
bounds = [
  [-0.3, -1.5],
  [101.5, 99.3]
];
blueObelisk = [50.9, 63.4, 'Blue obelisk'];
greenObelisk = [34, 40.8, 'Green obelisk'];
redObelisk = [45.6, 28.5, 'Red obelisk'];
<?php } else if ($map === 'ScorchedEarth_WP') { ?>
mapfile = 'images/scorched.jpg';
blueObelisk = [21.5, 33.5, 'Blue obelisk'];
greenObelisk = [53, 74.3, 'Green obelisk'];
redObelisk = [74, 40.5, 'Red obelisk'];
<?php } else if ($map === 'Aberration_WP') { ?>
mapfile = 'images/aberration.jpg';
blueObelisk = [18.9, 16.1, 'Blue obelisk'];
greenObelisk = [22.5, 77.8, 'Green obelisk'];
redObelisk = [80.8, 20.3, 'Red obelisk'];
<?php } else if ($map === 'TheCenter_WP') { ?>
mapfile = 'images/center.jpg';
blueObelisk = [50.3, 81, 'Blue obelisk'];
greenObelisk = [35.6, 15.3, 'Green obelisk'];
redObelisk = [8.2, 57.4, 'Red obelisk'];
<?php } else if ($map === 'Extinction_WP') { ?>
mapfile = 'images/extinction.jpg';
blueObelisk = [21.8, 78.2, 'Blue obelisk'];
greenObelisk = [50.6, 29.7, 'Green obelisk'];
redObelisk = [77.6, 76.9, 'Red obelisk'];
<?php } else if ($map === 'Astraeos_WP') { ?>
mapfile = 'images/astraeos.jpg';
// blueObelisk = [18.9, 16.1, 'Blue obelisk'];
// greenObelisk = [22.5, 77.8, 'Green obelisk'];
// redObelisk = [80.8, 20.3, 'Red obelisk'];
<?php } else if ($map === 'Forglar_WP') { ?>
mapfile = 'images/forglar.jpg';
blueObelisk = [7.4, 14.5, 'Blue obelisk'];
greenObelisk = [74.2, 61.6, 'Green obelisk'];
redObelisk = [26.8, 52.2, 'Red obelisk'];
<?php } else if ($map === 'Ragnarok_WP') { ?>
mapfile = 'images/ragnarok.jpg';
blueObelisk = [18.1, 17.3, 'Blue obelisk'];
greenObelisk = [57.0, 38.01, 'Green obelisk'];
redObelisk = [35.0, 85.7, 'Red obelisk'];
<?php }

} else {
    header("Content-Type: application/json");
    echo $resp, "\n";
}
