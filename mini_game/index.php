<?php

require 'vendor/autoload.php';

Use MiniGame\PersoManager;
Use Player\Personnages;

$db = new PDO('mysql:host=localhost;dbname=mini_game', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new PersoManager($db);

if(isset($_POST['create']) && isset($_POST['name'])){
    $perso = new Personnages(array('name' => $_POST['name']));
    if(!$perso->validName()){
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    }elseif ($manager->exists($perso->getName())){
        $message = 'le nom du personnage est déja pris';
        unset($perso);
    }else{
        $manager->add($perso);
    }
}elseif(isset($_POST['use']) && isset($_POST['name'])){
    if($manager->exists($_POST['name'])){
        $perso = $manager->getInfo($_POST['name']);
    }else{
        $message = 'Ce personnage n\'éxiste pas!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP : Mini jeu de combat</title>
</head>
<body>
    <p>Nombres de personnages créés : <?php echo $manager->count(); ?> </p>
    <?php
        if (isset($message))
            echo '<p>' . $message . '</p>'
    ?>
    <form action=".." method="post">
        <p>
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" maxlength="50"><br><br>
            <input type="submit" value="Créer ce personnage" name="create"><br><br>
            <input type="submit" value="Utiliser ce personnage" name="use"><br><br>
        </p>
    </form>
</body>
</html>
