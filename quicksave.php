<?php
/******************************************************************************
*   Copyright 2012 Nicolas CARPi
*   This file is part of eLabFTW. 
*
*    eLabFTW is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    eLabFTW is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with eLabFTW.  If not, see <http://www.gnu.org/licenses/>.
*
********************************************************************************/
require_once('inc/common.php');
// get $id from $_POST['id']
if (is_pos_int($_POST['id'])) {
    $id = $_POST['id'];
} else {
    die('Bad id value.');
}

// we only update status
if (isset($_POST['status'])) {
    if (is_pos_int($_POST['status'])) {
        $status = $_POST['status'];
    }
    $sql = "UPDATE experiments 
        SET status = :status 
        WHERE userid = :userid 
        AND id = :id";
    $req = $pdo->prepare($sql);
    $result = $req->execute(array(
        'status' => $status,
        'userid' => $_SESSION['userid'],
        'id' => $id
    ));

// we only update visibility
} elseif (isset($_POST['visibility'])) {
    // will return 'team' in case of wrong visibility
    $visibility = check_visibility($_POST['visibility']);
    $sql = "UPDATE experiments 
        SET visibility = :visibility 
        WHERE userid = :userid 
        AND id = :id";
    $req = $pdo->prepare($sql);
    $result = $req->execute(array(
        'visibility' => $visibility,
        'userid' => $_SESSION['userid'],
        'id' => $id
    ));

// or we update date, title, and body
} else {
    // get $title from $_POST['title']
    $title = check_title($_POST['title']);

    // get $body from $_POST['body']
    $body = check_body($_POST['body']);

    // get $date from $_POST['date']
    $date = check_date($_POST['date']);

    // SQL for quicksave
    // we do a usercheck for experiments
    if ($_POST['type'] == 'experiments') {
        $sql = "UPDATE experiments 
            SET title = :title, date = :date, body = :body
            WHERE userid = :userid 
            AND id = :id";
        $req = $pdo->prepare($sql);
        $result = $req->execute(array(
        'title' => $title,
        'date' => $date,
        'body' => $body,
        'userid' => $_SESSION['userid'],
        'id' => $id
        ));

    } elseif ($_POST['type'] == 'items') {
        $sql = "UPDATE items 
            SET title = :title, date = :date, body = :body
            WHERE id = :id";
        $req = $pdo->prepare($sql);
        $result = $req->execute(array(
            'title' => $title,
            'date' => $date,
            'body' => $body,
            'id' => $id
        ));
    }
}
