# PHP project "Veebipood"  
## Sisukord
1. [Login](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#login)
2. [Admin leht](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#admin-leht)
3. [Haldus Leht](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#haldus-leht)
4. [Kõik failinimed](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#k%C3%B5ik-failinimed)
5. [Ülesanded](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#%C3%BClesanded)
   
# Login
Me kontrollime, kas nende andmetega kasutaja on andmebaasis olemas ja suuname ta seejärel saidile.

![pilt](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/Login.PNG)

### Kood:
```
require_once("conf.php");
global $yhendus;


//kontrollime kas väljad  login vormis on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $cool="superpaev";
    $krypt = crypt($pass, $cool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $kask=$yhendus-> prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja,$onAdmin);
    $kask->execute();
    //kui on, siis loome sessiooni ja suuname
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;
        if($onAdmin==1) {
            header('Location:adminLeht.php'); exit;
        } else {
            header('Location:haldusLeht.php'); exit;
            $yhendus->close();
            exit();
        }
    } else {
        echo "kasutaja $login või parool $krypt on vale";
        $yhendus->close();
    }
}
?>
<h1>Login</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
```

# Admin leht
![pilt](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/admin.PNG)
See on koht, kus saate lisada ja eemaldada objekte

### Kood:
```
<?php if (isset($_GET['code'])){die(highlight_file(__FILE__,1));} ?>
<?php
require_once ('conf.php');
session_start();



if(!empty($_REQUEST["add2"]) && !empty($_REQUEST["add2_toote"]) && !empty($_REQUEST["add2_toote_kategooria"])){
    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO veebipood (veebipoodi_toote_nimetus, veebipoodi_toote_hind, veebipoodi_toote_kogus, veebipoodi_toote_kategooria) VALUES(?, ?, ?, ?)");
    $kask->bind_param("siis", $_REQUEST["add2"], $_REQUEST["add2_toote"], $_REQUEST["add2_toote_kogus"], $_REQUEST["add2_toote_kategooria"]);
    $kask->execute();
    //$yhendus->close();
}

if(isset($_REQUEST["kustuta2"])){
    global $yhendus;
    $paring = $yhendus->prepare("DELETE FROM veebipood WHERE vebipood_id=?");
    $paring->bind_param("i", $_REQUEST["kustuta2"]);
    $paring->execute();
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
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
        <li ><a href="adminLeht.php">Admin leht</a></li>
    </ul>
</nav>
<h2> Administreerimis Leht</h2>
<table>
      <tr>
        <th>Veebipooe tooted</th>
        <th>Hind (€/kg)</th>
        <th>Kogus</th>
        <th>Kategooria</th>
    </tr>
    <?php
    global $yhendus;
    $kask2=$yhendus->prepare("SELECT vebipood_id, veebipoodi_toote_nimetus, veebipoodi_toote_hind, veebipoodi_toote_kogus, veebipoodi_toote_kategooria FROM veebipood");
    $kask2->bind_result($veebipood_id, $veebipoodi_toote_nimi, $veebipoodi_toote_hind, $veebipoodi_toote_kogus, $veebipoodi_toote_kategooria);
    $kask2->execute();
   
    while($kask2->fetch()){
        echo "<tr>";
        echo "<td>".$veebipoodi_toote_nimi."</td>";
        echo "<td>".$veebipoodi_toote_hind."</td>";
        echo "<td>".$veebipoodi_toote_kogus."</td>";
        echo "<td>".$veebipoodi_toote_kategooria."</td>";
        echo "<td><a href='?kustuta2=$veebipood_id'>Kustuta</a></td>";
    }
    //$kask2->close();
    //$yhendus->close();
    echo "<tr>";
    echo "<td>";
    ?>
        <form action="?">
            <input type="text" name="add2" id="add2" placeholder="toote nimetus">
            <input type="text" name="add2_toote" id="add2_toote" placeholder="toote hind">
            <input type="text" name="add2_toote_kogus" id="add2_toote_kogus" placeholder="toote kogus">
            <input type="text" name="add2_toote_kategooria" id="add2_toote_kategooria" placeholder="toote kategooria">
            <input type="submit" value="Lisa toote">
        </form>
    <?php 
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
```

# Haldus Leht
![pilt](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/haldus.PNG)
Siin saate ostukorvi lisada ja sealt eemaldada.

### Kood:
```
require_once("conf.php");
global $yhendus;


//kontrollime kas väljad  login vormis on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    //SIIA UUS KONTROLL
    $cool="superpaev";
    $krypt = crypt($pass, $cool);
    //kontrollime kas andmebaasis on selline kasutaja ja parool
    $kask=$yhendus-> prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja,$onAdmin);
    $kask->execute();
    //kui on, siis loome sessiooni ja suuname
    if ($kask->fetch()) {
        $_SESSION['tuvastamine'] = 'misiganes';
        $_SESSION['kasutaja'] = $login;
        $_SESSION['onAdmin'] = $onAdmin;
        if($onAdmin==1) {
            header('Location:adminLeht.php'); exit;
        } else {
            header('Location:haldusLeht.php'); exit;
            $yhendus->close();
            exit();
        }
    } else {
        echo "kasutaja $login või parool $krypt on vale";
        $yhendus->close();
    }
}
?>
<h1>Login</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
```


# Kõik failinimed
1. adminleht.php
2. haldusLeht.php
3. conf.php
4. style.css
5. login.php
6. logout.php
7. main.php

# Ülesanded
1. Muuta taustavärvi mitmekesisemaks 
2. muuta laua värvus mitmekesisemaks
3. Teha kõik pealkirjad paremale
4. Et tabelid oleksid allosas
5. Et tabelid oleksid väiksemad
6. Lisada üks pilt vastavalt teemale
