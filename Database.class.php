<?php

class Database
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbName;
    private PDO $connexion;
    private PDOStatement $request;

    /**
     * Constructeur de la classe Database
     * @param string $host Le host de la base de données
     * @param string $user L'utilisateur de la base de données
     * @param string $dbName Le nom de la base de données
     * @param string $pass Le mot de passe de la base de données
     */
    public function __construct(string $host, string $user, string $dbName, string $pass)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
    }

    /**
     * Connexion à la base de données à l'aide de PDO
     * @return PDO|PDOException
     */
    public function connect (): PDO|PDOException
    {
        $path = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8";

        try
        {
            $this->connexion = new PDO($path, $this->user, $this->pass);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connexion;
        }
        catch (PDOException $e)
        {
            throw new PDOException($e->getMessage() , (int)$e->getCode());
        }
    }

    /**
     * Requête préparée
     * @param string $query La requête SQL
     * @param array $array Les paramètres SQL
     * @return bool|PDOStatement
     */
    public function prepReq(string $query, array $array = []): bool|PDOStatement
    {
        $this->request = $this->connexion->prepare($query);
        $this->request->execute($array);
        return $this->request;
    }

    public function add (Character $character): PDOException|bool|PDOStatement|null
    {
        $params = [
            "name" => $character->getName()
        ];
        $req = $this->prepReq('INSERT INTO game_character SET name = :name', $params);
        $character->setId($this->connexion->lastInsertId());

        return $req;
    }

    public function exists ($name): bool
    {
        $params = [
            "name" => $name
        ];
        $this->prepReq('SELECT COUNT(*) FROM game_character WHERE name = :name', $params);
        $count = $this->request->fetchColumn();

        if ($count === 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getCharacterList (): array
    {
        $characterList = array();

        $req = $this->prepReq('SELECT name FROM game_character');
        $characters = $req->fetchAll(PDO::FETCH_OBJ);

        foreach ($characters as $character)
        {
            $characterList[] = $character->name;
        }

        return $characterList;
    }
}