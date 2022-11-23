<?php

class Database
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbName;
    private PDO $connexion;
    private false|PDOStatement $request;

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
    public function prepReq(string $query, array $array = []): bool|PDOStatement|null|PDOException
    {
        try
        {
            $this->request = $this->connexion->prepare($query);
            $this->request->execute($array);
            return $this->request;
        }
        catch (PDOException $e)
        {
            $existingKey = "Integrity constraint violation: 1062";

            if (str_contains($e->getMessage(), $existingKey))
            {
                $url  = $_SERVER["HTTP_ORIGIN"];
                $url .= "?register_same_pseudo=1";

                return header('Location: ' . $url);
            }
            else
            {
                throw new PDOException( $e->getMessage() , (int)$e->getCode() );
            }
        }
    }

    /**
     * Récupère les données
     * @return bool|array
     */
    public function fetchData(): bool|array
    {
        return $this->request->fetchAll();
    }

    public function createCharacter (Character $character)
    {
        $params = [
            "nom" => $character->getName()
        ];
        $request = $this->prepReq('INSERT INTO game_character SET name = :nom', $params);
        var_dump($this->connexion->lastInsertId());
        $character->setId($this->connexion->lastInsertId());

        return $request;
    }
}