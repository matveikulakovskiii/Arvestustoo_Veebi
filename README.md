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
# Haldus Leht
![pilt](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/haldus.PNG)
Siin saate ostukorvi lisada ja sealt eemaldada.

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
