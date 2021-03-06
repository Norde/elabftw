<?php
/********************************************************************************
*                                                                               *
*   Copyright 2012 Nicolas CARPi (nicolas.carpi@gmail.com)                      *
*   http://www.elabftw.net/                                                     *
*                                                                               *
********************************************************************************/

/********************************************************************************
*  This file is part of eLabFTW.                                                *
*                                                                               *
*    eLabFTW is free software: you can redistribute it and/or modify            *
*    it under the terms of the GNU Affero General Public License as             *
*    published by the Free Software Foundation, either version 3 of             *
*    the License, or (at your option) any later version.                        *
*                                                                               *
*    eLabFTW is distributed in the hope that it will be useful,                 *
*    but WITHOUT ANY WARRANTY; without even the implied                         *
*    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR                    *
*    PURPOSE.  See the GNU Affero General Public License for more details.      *
*                                                                               *
*    You should have received a copy of the GNU Affero General Public           *
*    License along with eLabFTW.  If not, see <http://www.gnu.org/licenses/>.   *
*                                                                               *
********************************************************************************/
// Count number of experiments for each status
// SUCCESS
// get all status name and id
$sql = "SELECT * FROM status";
$req = $pdo->prepare($sql);
$req->execute();

$status_arr = array();
$count_arr = array();

while ($status = $req->fetch()) {
    $status_arr[$status['id']] = $status['name'];
}

foreach ($status_arr as $key => $value) {
    $sql = "SELECT COUNT(id)
        FROM experiments
        WHERE userid = :userid
        AND status = :status";
    $req = $pdo->prepare($sql);
    $req->bindParam(':userid', $_SESSION['userid']);
    $req->bindParam(':status', $key);
    $req->execute();
    $count_arr[$key] = $req->fetchColumn();
}

// MAKE TOTAL
$sql = "SELECT COUNT(id) FROM experiments WHERE userid = :userid";
$req = $pdo->prepare($sql);
$req->bindParam(':userid', $_SESSION['userid']);
$req->execute();
$total = $req->fetchColumn();


// Make percentage
if ($total != 0) {
    foreach ($status_arr as $key => $value) {
        $percent_arr[$value] = round(($count_arr[$key]/$total)*100);
    }

    // BEGIN CONTENT
    echo "<img src='themes/".$_SESSION['prefs']['theme']."/img/statistics.png' alt='' /> <h4>STATISTICS</h4>";
    ?>
    <script src='js/google-jsapi.js'></script>
    <script>
          //google.load('visualization', '1', {packages:['imagepiechart']});
          google.load('visualization', '1', {packages:['corechart']});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'status');
            data.addColumn('number', 'Experiments number');
            data.addRows([
            <?php
                foreach ($percent_arr as $name => $percent) {
                    echo "['$name', $percent],";
                }
            ?>
                          ]);

            var options = {
                title: 'Experiments for <?php echo $_SESSION['username'];?>',
                backgroundColor: '#EEE'
            }
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>
     <div id="chart_div" class='center'></div>
    <?php
} else { //end fix division by zero
    echo 'No statistics available yet.';
}
