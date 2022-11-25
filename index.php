<?php
// Autoloader : charge automatiquement les classes
spl_autoload_register(function ($class) {
    include $class . '.class.php';
});

$database = new Database("localhost", "root", "fight_game", "");
$database->connect();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jeu de combat avec la Programmation Orientée Objet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form action="/" method="post">
    <p>
        <label>Créer un personnage :</label>
        <input type="text" name="create-player-name" value="">
    </p>
    <input type="submit" value="Créer ce personnage" name="create-player">
    <p>
        <label for="">Sélectionner un joueur :</label>
        <select name="select-player">
            <option value=""></option>
            <?php echo buildCharacterDropdown($database) ?>
        </select>
    </p>
    <p>
        <label for="">Sélectionner un adversaire :</label>
        <select name="select-enemy">
            <option value=""></option>
            <?php echo buildCharacterDropdown($database) ?>
        </select>
    </p>
    <input type="submit" name="submit" value="Fight !">
</form>
<?php

/**
 * Construit le dropdown avec les balises HTML <option>
 * @param Database $db La connexion avec la base de données
 * @return string
 */
function buildCharacterDropdown (Database $db): string
{
    $options = "";
    foreach ($db->getCharacterList() as $character) {
        $options .= "<option value='$character'>$character</option>";
    }
    return $options;
}

//$gandalf = new Character("Gandalf");
//$database->createCharacter($gandalf);
//var_dump($gandalf->getId());

fight($database);

/**
 * Lance le jeu
 * @param Database $db La connexion avec la base de données
 * @return void
 */
function fight (Database $db): void
{
    $createdPlayerName = htmlspecialchars($_POST["create-player-name"]);
    $player = new Character($createdPlayerName);

    if (!$player->isValidName())
    {
        echo 'Le nom choisi est invalide.';
        unset($player);
        return;
    }

    if ($db->exists($player->getName()))
    {
        echo "Ce personnage existe déjà. Merci d'en créer un autre.";
        unset($player);
        return;
    }

    $db->add($player);

    if (!empty($_POST["create-player-name"]) && !empty($_POST["select-player"]))
    {
        echo "Vous avez créé un joueur et sélectionné un joueur existant. Merci de choisir entre les 2 !";
        return;
    }

    if (empty($_POST["select-enemy"]))
    {
        echo "Veuillez sélectionner un ennemi pour jouer...";
        return;
    }

    if ((empty($_POST["create-player-name"]) && empty($_POST["select-player"])))
    {
        echo "Veuillez sélectionner un personnage pour jouer...";
        return;
    }

    if ($_POST["select-player"] === $_POST["select-enemy"])
    {
        echo "Vous ne pouvez pas combattre contre vous-même, voyons !";
        return;
    }

    echo 'fight';

}




?>

</body>
</html>
