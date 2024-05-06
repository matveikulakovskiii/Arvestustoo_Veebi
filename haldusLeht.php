<?php if (isset($_GET['code'])){die(highlight_file(__FILE__,1));} ?>
<?php
require_once ('conf.php');
session_start();

if(!empty($_REQUEST["lisa2"])){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (vebipood_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa2"]);
    $kask->execute();

    $update_kask = $yhendus->prepare("UPDATE veebipood SET veebipoodi_toote_kogus = veebipoodi_toote_kogus-1 WHERE vebipood_id = ?");
    $update_kask->bind_param("s", $_REQUEST["lisa2"]);
    $update_kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

if(isset($_REQUEST["kustuta_ostukorv"])){
    global $yhendus;

    $select_toote_id = $yhendus->prepare("SELECT vebipood_id FROM ostukorv WHERE ostukorv_id=?");
    $select_toote_id->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $select_toote_id->execute();
    $select_toote_id->store_result();
    $num_rows = $select_toote_id->num_rows;

    if ($num_rows > 0){
        $select_toote_id->bind_result($toote_id);
        $select_toote_id->fetch();

        $update_kask = $yhendus->prepare("UPDATE veebipood SET veebipoodi_toote_kogus = veebipoodi_toote_kogus + 1 WHERE vebipood_id = ?");
        $update_kask->bind_param("i", $toote_id);
        $update_kask->execute();
    }

    $paring = $yhendus->prepare("DELETE FROM ostukorv WHERE ostukorv_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta_ostukorv"]);
    $paring->execute();
}

?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
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
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: left;}

        th,td {
            background-color: darkgrey;
            background-color: red;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
        .tables {
            margin-top: 530px;
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
    </ul>
</nav>
<h2 >Kasutaja Leht</h2>
<?php
if(isset($_SESSION['kasutaja']))
?>
<div class="tables">
<table>
    <tr>
        <th>Lihatooted</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
        <th>Kategooria</th>
    </tr>
    <?php
    $kask2=$yhendus->prepare("SELECT vebipood_id, veebipoodi_toote_nimetus, veebipoodi_toote_hind, veebipoodi_toote_kogus, veebipoodi_toote_kategooria FROM veebipood");
    $kask2->bind_result($veebipood_id, $veebipoodi_toote_nimi, $veebipoodi_toote_hind, $veebipoodi_toote_kogus, $veebipoodi_toote_kategooria);
    $kask2->execute();
    while($kask2->fetch()){
        echo "<tr>";
        echo "<td>".$veebipoodi_toote_nimi."</td>";
        echo "<td>".$veebipoodi_toote_hind."</td>";
        echo "<td>".$veebipoodi_toote_kogus."</td>";
        echo "<td>".$veebipoodi_toote_kategooria."</td>";
        echo "<td><a href='?lisa2=$veebipood_id'>Lisa Ostukorva</a></td>";
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

    $kask3 = $yhendus->prepare("SELECT ostukorv_id, vebipood_id FROM ostukorv");
    $kask3->execute();
    $kask3->bind_result($ostukorv_id, $vebipood_id);

    $tooted_nimed = array();
    $tooted_hinded = array();
    while ($kask3->fetch()) {
        $tooted_nimed[$vebipood_id] = null; 
        $tooted_hinded[$vebipood_id] = null;
    }

    $kask3->close();

    $kask4 = $yhendus->prepare("SELECT vebipood_id, veebipoodi_toote_nimetus, veebipoodi_toote_hind FROM veebipood");
    $kask4->execute();
    $kask4->bind_result($id, $name, $hind);
    while ($kask4->fetch()) {
        $tooted_nimed[$id] = $name;
        $tooted_hinded[$id] = $hind;
    }
    $kask4->close();

    $kask3 = $yhendus->prepare("SELECT ostukorv_id, vebipood_id FROM ostukorv");
    $kask3->execute();
    $kask3->bind_result($ostukorv_id2, $tooted_id2);

    while ($kask3->fetch()) {
        echo "<tr>";
        echo "<td>".$tooted_nimed[$tooted_id2]."</td>";
        echo "<td>".$tooted_hinded[$tooted_id2]."</td>";
        echo "<td><a href='?kustuta_ostukorv=$ostukorv_id'>Kustuta toote</a></td>";
        echo "</tr>";
        
    }
    $kask3->close();
    $yhendus->close();
    ?>    
</table>
</div>
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

