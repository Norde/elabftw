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
require_once 'inc/common.php';
$page_title = 'Database';
require_once 'inc/head.php';
require_once 'inc/menu.php';
require_once 'inc/info_box.php';

// Page begin
if (!isset($_GET['mode']) || (empty($_GET['mode'])) || ($_GET['mode'] === 'show')) {
    require_once 'inc/showDB.php';
} elseif ($_GET['mode'] === 'view') {
    require_once 'inc/viewDB.php';
} elseif ($_GET['mode'] === 'edit') {
    require_once 'inc/editDB.php';
} else {
    echo "What are you doing, Dave ?";
}

require_once 'inc/footer.php';

