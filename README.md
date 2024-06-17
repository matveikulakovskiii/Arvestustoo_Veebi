# PHP project "Veebipood"  
## Sisukord
1. [Login](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#login)
2. [Admin leht](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#admin-leht)
3. [Haldus Leht](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#haldus-leht)
4. [Kõik failinimed](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#k%C3%B5ik-failinimed)
5. [Ülesanded](https://github.com/matveikulakovskiii/Arvestustoo_Veebi/blob/main/README.md#%C3%BClesanded)
   
# Login
Me kontrollime, kas nende andmetega kasutaja on andmebaasis olemas ja suuname ta seejärel saidile.

### Kood:
```
global $yhendus;
if (!empty($_POST['login']) && !empty($_POST['pass'])) {

 $login = htmlspecialchars(trim($_POST['login']));
 $pass = htmlspecialchars(trim($_POST['pass']));


 $cool = 'superpaev';
 $kryp = crypt($pass, $cool);


 $kask2 = $yhendus->prepare("INSERT INTO kasutaja (kasutaja, parool) VALUES (?, ?)");
 $kask2->bind_param("ss", $login, $kryp);
 $kask2->execute();
     
 echo '<script>alert("Registreerimine õnnestus!"); window.location.href = "login.php";</script>';

 $kask2->close();
 $yhendus->close();
 exit();
}
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
