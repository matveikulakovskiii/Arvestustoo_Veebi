<?php if (isset($_GET['code'])){die(highlight_file(__FILE__,1));} ?>
<?php
require_once ('conf.php');
session_start();

//lisame ostukorva joogid
if(!empty($_REQUEST["lisa"])){
    global $yhendus;
    $insert_kask = $yhendus->prepare("INSERT INTO ostukorv (joogid_id) VALUES(?)");
    $insert_kask->bind_param("s", $_REQUEST["lisa"]);
    $insert_kask->execute();

    $update_kask = $yhendus->prepare("UPDATE joogid SET joogid_kogus = joogid_kogus-1 WHERE joogid_id = ?");
    $update_kask->bind_param("s", $_REQUEST["lisa"]);
    $update_kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
//lisame ostukorva lihatooted
if(!empty($_REQUEST["lisa2"])){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (lihatooted_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa2"]);
    $kask->execute();

    $update_kask = $yhendus->prepare("UPDATE lihatooted SET lihatooted_kogus = lihatooted_kogus-1 WHERE lihatooted_id = ?");
    $update_kask->bind_param("s", $_REQUEST["lisa2"]);
    $update_kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    //exit();
}
//lisame ostukorva teraviljatooted
if(!empty($_REQUEST["lisa3"])){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (teraciljatooted_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa3"]);
    $kask->execute();

    $update_kask = $yhendus->prepare("UPDATE teraciljatooted SET teraciljatooted_kogus = teraciljatooted_kogus-1 WHERE teraciljatooted_id = ?");
    $update_kask->bind_param("s", $_REQUEST["lisa3"]);
    $update_kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    //exit();
}

if(isset($_REQUEST["kustuta_ostukorv"])){
    global $yhendus;

    $select_teraciljatooted_id = $yhendus->prepare("SELECT teraciljatooted_id FROM ostukorv WHERE ostukorv_id=?");
    $select_teraciljatooted_id->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $select_teraciljatooted_id->execute();
    $select_teraciljatooted_id->store_result();
    $num_rows = $select_teraciljatooted_id->num_rows;

    if ($num_rows > 0){
        $select_teraciljatooted_id->bind_result($teraciljatooted_id);
        $select_teraciljatooted_id->fetch();

        $update_kask = $yhendus->prepare("UPDATE teraciljatooted SET teraciljatooted_kogus = teraciljatooted_kogus + 1 WHERE teraciljatooted_id = ?");
        $update_kask->bind_param("i", $teraciljatooted_id);
        $update_kask->execute();
    }

    $select_joogid_id = $yhendus->prepare("SELECT joogid_id FROM ostukorv WHERE ostukorv_id=?");
    $select_joogid_id->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $select_joogid_id->execute();
    $select_joogid_id->store_result();
    $num_rows_2 = $select_joogid_id->num_rows;

    if ($num_rows_2 > 0){
        $select_joogid_id->bind_result($joogid_id);
        $select_joogid_id->fetch();

        $update_kask_2 = $yhendus->prepare("UPDATE joogid SET joogid_kogus = joogid_kogus + 1 WHERE joogid_id = ?");
        $update_kask_2->bind_param("i", $joogid_id);
        $update_kask_2->execute();
    }

    $select_lihatooted_id = $yhendus->prepare("SELECT lihatooted_id FROM ostukorv WHERE ostukorv_id=?");
    $select_lihatooted_id->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $select_lihatooted_id->execute();
    $select_lihatooted_id->store_result();
    $num_rows_3 = $select_lihatooted_id->num_rows;

    if ($num_rows_3 > 0){
        $select_lihatooted_id->bind_result($lihatooted_id);
        $select_lihatooted_id->fetch();

        $update_kask_3 = $yhendus->prepare("UPDATE lihatooted SET lihatooted_kogus = lihatooted_kogus + 1 WHERE lihatooted_id = ?");
        $update_kask_3->bind_param("i", $lihatooted_id);
        $update_kask_3->execute();
    }

    $paring = $yhendus->prepare("DELETE FROM ostukorv WHERE ostukorv_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $paring->execute();
}

function isAdmin(){
    if (isset($_SESSION['onAdmin'])) {
        return $_SESSION['onAdmin'];
    } else {
        return;
    }
}

?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veebipood</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:black;
            background-size: cover;
            background-position: unset;
            background-repeat: no-repeat;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #444;
            overflow: hidden;
        }

        nav ul li {
            float: left;
        }

        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav ul li a:hover {
            background-color: #111;
        }

        h2 {
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th,td {
            background-color: darkgrey;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<header>
    <h1>Veebipood</h1>
    <?php
    if(isset($_SESSION['kasutaja'])){
        ?>
        <h1>Tere, <?="$_SESSION[kasutaja]"?></h1>
        <a href="logout.php">Logi välja</a>
        <?php
    } else {
        ?>
        <a href="#" id="loginLink">Logi sisse</a>
        <?php
    }
    ?>
</header>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php include('login.php'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<nav>
    <ul>
        <li><a href="haldusLeht.php">Kasutaja leht</a></li>
        <?php
        if(isAdmin()) { ?>
            <li><a href="adminLeht.php">Admin leht</a></li>
        <?php }     ?>
    </ul>
</nav>
<h2 >Kasutaja Leht</h2>
<?php
if(isset($_SESSION['kasutaja']))
?>
<table>
    <tr>
        <th>Lihatooted</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
    </tr>
    <?php
    global $yhendus;
    $kask2=$yhendus->prepare("SELECT lihatooted_id, lihatooted_nimi, lihatooted_hind, lihatooted_kogus FROM lihatooted");
    $kask2->bind_result($lihatooted_id, $lihatooted_nimi, $lihatooted_hind, $lihatooted_kogus);
    $kask2->execute();
    while($kask2->fetch()){
        echo "<tr>";
        echo "<td>".$lihatooted_nimi."</td>";
        echo "<td>".$lihatooted_hind."</td>";
        echo "<td>".$lihatooted_kogus."</td>";
        echo "<td><a href='?lisa2=$lihatooted_id'>Lisa Ostukorva</a></td>";
        if(isAdmin()) {
            echo "<td><a href='?kustuta=$lihatooted_id'>Kustuta</a></td>";
        }
    }
    ?>
    <tr>
        <th>Joogid</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
    </tr>
    <?php
    global $yhendus;
    $kask=$yhendus->prepare("SELECT joogid_id, joogid_nimi, joogid_hind, joogid_kogus FROM joogid");
    $kask->bind_result($joogid_id, $joogid_nimi, $joogid_hind, $joogid_kogus);
    $kask->execute();
    while($kask->fetch()){
        echo "<tr>";
        echo "<td>".$joogid_nimi."</td>";
        echo "<td>".$joogid_hind."</td>";
        echo "<td>".$joogid_kogus."</td>";
        echo "<td><a href='?lisa=$joogid_id'>Lisa Ostukorva</a></td>";
        if(isAdmin()) {
            echo "<td><a href='?kustuta=$joogid_id'>Kustuta</a></td>";
        }
    }
    ?>
    <tr>
        <th>Teraviljatooted</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
    </tr>
    <?php
    global $yhendus;
    $kask3=$yhendus->prepare("SELECT teraciljatooted_id, teraciljatooted_nimi, teraciljatooted_hind, teraciljatooted_kogus FROM teraciljatooted");
    $kask3->bind_result($teraviljatooted_id, $teraviljatooted_nimi, $teraviljatooted_hind, $teraviljatooted_kogus);
    $kask3->execute();
    while($kask3->fetch()){
        echo "<tr>";
        echo "<td>".$teraviljatooted_nimi."</td>";
        echo "<td>".$teraviljatooted_hind."</td>";
        echo "<td>".$teraviljatooted_kogus."</td>";
        echo "<td><a href='?lisa3=$teraviljatooted_id'>Lisa Ostukorva</a></td>";
        if(isAdmin()) {
            echo "<td><a href='?kustuta=$teraviljatooted_id'>Kustuta</a></td>";
        }
    }
    ?>
</table>

<table>
    <tr>
        <th>Ostukorv</th>
        <th>Hind (€/kg)</th>
    </tr>
    <?php
    global $yhendus;

    $kask3 = $yhendus->prepare("SELECT ostukorv_id, teraciljatooted_id, joogid_id, lihatooted_id FROM ostukorv");
    $kask3->execute();
    $kask3->bind_result($ostukorv_id, $teraciljatooted_id, $joogid_id, $lihatooted_id);

    $teraviljatooted_nimed = array();
    $teraviljatooted_hinded = array();
    $lihatooted_nimed = array();
    $lihatooted_hinded = array();
    $joogid_nimed = array();
    $joogid_hinded = array();
    while ($kask3->fetch()) {
        $teraviljatooted_nimed[$teraciljatooted_id] = null;
        $lihatooted_nimed[$lihatooted_id] = null; 
        $joogid_nimed[$joogid_id] = null; 
        $teraviljatooted_hinded[$teraciljatooted_id] = null;
        $lihatooted_hinded[$lihatooted_id] = null; 
        $joogid_hinded[$joogid_id] = null;
    }

    $kask3->close();

    $kask4 = $yhendus->prepare("SELECT teraciljatooted_id, teraciljatooted_nimi, teraciljatooted_hind FROM teraciljatooted");
    $kask4->execute();
    $kask4->bind_result($id, $name, $hind);
    while ($kask4->fetch()) {
        $teraviljatooted_nimed[$id] = $name;
        $teraviljatooted_hinded[$id] = $hind;
    }
    $kask4->close();

    $kask5 = $yhendus->prepare("SELECT lihatooted_id, lihatooted_nimi, lihatooted_hind FROM lihatooted");
    $kask5->execute();
    $kask5->bind_result($id2, $name2, $hind2);
    while ($kask5->fetch()) {
        $lihatooted_nimed[$id2] = $name2;
        $lihatooted_hinded[$id2] = $hind2;
    }
    $kask5->close();

    $kask6 = $yhendus->prepare("SELECT joogid_id, joogid_nimi, joogid_hind FROM joogid");
    $kask6->execute();
    $kask6->bind_result($id3, $name3, $hind3);
    while ($kask6->fetch()) {
        $joogid_nimed[$id3] = $name3;
        $joogid_hinded[$id3] = $hind3;
    }
    $kask6->close();


    $kask3 = $yhendus->prepare("SELECT ostukorv_id, teraciljatooted_id, joogid_id, lihatooted_id FROM ostukorv");
    $kask3->execute();
    $kask3->bind_result($ostukorv_id2, $teraciljatooted_id2, $joogid_id2, $lihatooted_id2);

    while ($kask3->fetch()) {
        echo "<tr>";
        echo "<td>".$lihatooted_nimed[$lihatooted_id2].$joogid_nimed[$joogid_id2].$teraviljatooted_nimed[$teraciljatooted_id2]."</td>";
        echo "<td>".$lihatooted_hinded[$lihatooted_id2].$joogid_hinded[$joogid_id2].$teraviljatooted_hinded[$teraciljatooted_id2]."</td>";
        echo "<td><a href='?kustuta_ostukorv=$ostukorv_id'>Kustuta toote</a></td>";
        echo "</tr>";
        
    }
    $kask3->close();
    $yhendus->close();
    ?>    
</table>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    document.getElementById('loginLink').addEventListener('click', function () {
        $('#loginModal').modal('show');
    });
</script>
</body>
</html>
