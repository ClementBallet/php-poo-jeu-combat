<?php
// Autoloader : charge automatiquement les classes
spl_autoload_register(function ($class) {
    include $class . '.class.php';
});
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jeu de combat avec la Programmation Orientée Objet</title>
</head>
<body>

<form action="/" method="post">
    <p>
        <label>Créer un joueur :</label>
        <input type="text" name="create-player">
    </p>
    <p>
        <label for="">Sélectionner un joueur :</label>
        <select name="select-player">
            <option value=""></option>
            <option value="Gandalf">Gandalf</option>
            <option value="Gimli">Gimli</option>
            <option value="Aragorn">Aragorn</option>
        </select>
    </p>
    <p>
        <label for="">Sélectionner un adversaire :</label>
        <select name="select-enemy">
            <option value=""></option>
            <option value="Sauron">Sauron</option>
            <option value="Saroumane">Saroumane</option>
            <option value="Balrog">Balrog</option>
        </select>
    </p>
    <input type="submit" name="submit" value="Fight !">
</form>
<?php
$dice = new Dice();
var_dump($dice->roll());

//$database = new Database("localhost", "root", "fight_game", "");
//$database->connect();

$gandalf = new Character("Gandalf");
//$database->createCharacter($gandalf);
//var_dump($gandalf->getId());

//if ( isset($_GET["register_same_pseudo"]) && $_GET["register_same_pseudo"] == 1 ) {
//    echo "Pseudo déjà pris";
//}

handleForm();

function handleForm ()
{
    var_dump($_POST);
    if (!empty($_POST["create-player"]) && !empty($_POST["select-player"]))
    {
        echo "Vous avez créé un joueur et sélectionné un joueur existant. Merci de choisir entre les 2 !";
        return;
    }

    if (empty($_POST["select-enemy"]))
    {
        echo "Vous n'avez pas sélectionné d'ennemi...";
        return;
    }

    if ((empty($_POST["create-player"]) && empty($_POST["select-player"])))
    {
        echo "Veuillez sélectionner un personnage pour jouer...";
        return;
    }

    echo "coucou";
}




?>

</body>
</html>
