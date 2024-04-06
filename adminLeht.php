<?php if (isset($_GET['code'])){die(highlight_file(__FILE__,1));} ?>
<?php
require_once ('conf.php');
session_start();
//lisame ostukorva joogid
if(!empty($_REQUEST["lisa"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (joogid_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
//lisame ostukorva lihatooted
if(!empty($_REQUEST["lisa2"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (lihatooted_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa2"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
//lisame ostukorva teraviljatooted
if(!empty($_REQUEST["lisa3"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO ostukorv (teraciljatooted_id) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["lisa3"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

if(!empty($_REQUEST["add"]) && !empty($_REQUEST["add_jook"]) && !empty($_REQUEST["add_jook_kogus"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO joogid (joogid_nimi, joogid_hind, joogid_kogus) VALUES(?, ?, ?)");
    $kask->bind_param("sdi", $_REQUEST["add"], $_REQUEST["add_jook"], $_REQUEST["add_jook_kogus"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
if(!empty($_REQUEST["add2"]) && !empty($_REQUEST["add2_lihatooted"]) && !empty($_REQUEST["add2_lihatooted_kogus"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO lihatooted (lihatooted_nimi, lihatooted_hind, lihatooted_kogus) VALUES(?, ?, ?)");
    $kask->bind_param("sdi", $_REQUEST["add2"], $_REQUEST["add2_lihatooted"], $_REQUEST["add2_lihatooted_kogus"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}
if(!empty($_REQUEST["add3"]) && !empty($_REQUEST["add3_teraviljatooted"]) && !empty($_REQUEST["add3_teraviljatooted_kogus"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO teraciljatooted (teraciljatooted_nimi, teraciljatooted_hind, teraciljatooted_kogus) VALUES(?, ?, ?)");
    $kask->bind_param("sdi", $_REQUEST["add3"], $_REQUEST["add3_teraviljatooted"], $_REQUEST["add3_teraviljatooted_kogus"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

if(isset($_REQUEST["kustuta1"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $paring = $yhendus->prepare("DELETE FROM joogid WHERE joogid_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta1"]);
    $paring->execute();
}
if(isset($_REQUEST["kustuta2"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $paring = $yhendus->prepare("DELETE FROM lihatooted WHERE lihatooted_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta2"]);
    $paring->execute();
}
if(isset($_REQUEST["kustuta3"]) && $_SESSION['onAdmin']==1){
    global $yhendus;
    $paring = $yhendus->prepare("DELETE FROM teraciljatooted WHERE teraciljatooted_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta3"]);
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veebipood</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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
        <li ><a href="adminLeht.php">Admin leht</a></li>
    </ul>
</nav>
<h2> Administreerimis Leht</h2>
<table>
    <tr>
        <th>Joogid</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
    </tr>
    <?php
    // ! + knopka tab - näitab html koodi algus
    global $yhendus;
    $kask=$yhendus->prepare("SELECT joogid_id, joogid_nimi, joogid_hind, joogid_kogus FROM joogid");
    $kask->bind_result($joogid_id, $joogid_nimi, $joogid_hind, $joogid_kogus);
    $kask->execute();
    while($kask->fetch()) {
        echo "<tr>";
        echo "<td>" . $joogid_nimi . "</td>";
        echo "<td>" . $joogid_hind . "</td>";
        echo "<td>" . $joogid_kogus . "</td>";
        if ($_SESSION['onAdmin'] == 0) {
            echo "<td><a href='?lisa=$joogid_id'>Lisa Ostukorva</a></td>";
        }
        if (isAdmin()) {
            echo "<td><a href='?kustuta1=$joogid_id'>Kustuta</a></td>";
        }
    }
        echo "<tr>";
        echo "<td>";
        if(isAdmin()) { ?>
            <form action="?">
                <input type="text" name="add" id="add" placeholder="joogi nimetus">
                <input type="text" name="add_jook" id="add_jook" placeholder="joogi hind">
                <input type="text" name="add_jook_kogus" id="add_jook_kogus" placeholder="joogi kogus">
                <input type="submit" value="Lisa jook">
            </form>
        <?php }
        echo "</td>";
        echo "</tr>";

    ?>

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
        if($_SESSION['onAdmin']==0) {
            echo "<td><a href='?lisa2=$lihatooted_id'>Lisa Ostukorva</a></td>";
        }
        if(isAdmin()) {
            echo "<td><a href='?kustuta2=$lihatooted_id'>Kustuta</a></td>";
        }
    }
    echo "<tr>";
    echo "<td>";
    if(isAdmin()) { ?>
        <form action="?">
            <input type="text" name="add2" id="add2" placeholder="lihatoote nimetus">
            <input type="text" name="add2_lihatooted" id="add2_lihatooted" placeholder="lihatoote hind">
            <input type="text" name="add2_lihatooted_kogus" id="add2_lihatooted_kogus" placeholder="lihatoote kogus">
            <input type="submit" value="Lisa lihatoote">
        </form>
    <?php }
    echo "</td>";
    echo "</tr>";
    ?>
    <tr>
        <th>Teraviljatooted</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
    </tr>
    <?php
    global $yhendus;
    $kask3=$yhendus->prepare("SELECT teraciljatooted_id, teraciljatooted_nimi, teraciljatooted_hind, teraciljatooted_kogus FROM teraciljatooted");
    $kask3->bind_result($teraviljatooted_id, $teraviljatooted_nimi, $teraviljatooted_hind, $teraciljatooted_kogus);
    $kask3->execute();
    while($kask3->fetch()){
        echo "<tr>";
        echo "<td>".$teraviljatooted_nimi."</td>";
        echo "<td>".$teraviljatooted_hind."</td>";
        echo "<td>".$teraciljatooted_kogus."</td>";
        if($_SESSION['onAdmin']==0) {
            echo "<td><a href='?lisa3=$teraviljatooted_id'>Lisa Ostukorva</a></td>";
        }
        if(isAdmin()) {
            echo "<td><a href='?kustuta3=$teraviljatooted_id'>Kustuta</a></td>";
        }
    }
    echo "<tr>";
    echo "<td>";
    if(isAdmin()) { ?>
        <form action="?">
            <input type="text" name="add3" id="add3" placeholder="teraviljatoote nimetus">
            <input type="text" name="add3_teraviljatooted" id="add3_teraviljatooted" placeholder="teraviljatoote hind">
            <input type="text" name="add3_teraviljatooted_kogus" id="add3_teraviljatooted_kogus" placeholder="teraviljatoote kogus">
            <input type="submit" value="Lisa teraviljatoote">
        </form>
    <?php }
    echo "</td>";
    echo "</tr>";
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



