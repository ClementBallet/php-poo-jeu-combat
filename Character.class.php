<?php

class Character
{
    private int $id;
    private string $name;
    private int $health;
    private int $damage;
    private int $force;
    private int $power;
    private bool $shield;

    public function __construct(string $name, int $health = 100)
    {
        $this->name = $name;
        $this->health = $health;
    }

    // Fonction qui permet d'attaquer un monstre
    public function attack (int $dice): int
    {
        return $dice * $this->force;
    }

    // Fonction qui retire le nombre de points de vie correspondants
    public function takeDamage (int $damages): void
    {
        if ($this->shield)
        {
            $this->health = $this->health - $damages / 2;
        }
        else
        {
            $this->health = $this->health - $damages;
        }
    }

    // Fonction qui permet d'activer le bouclier
    public function activateShield (int $dice): void
    {
        if ($dice <= 4)
        {
            $this->shield = false;
        }
        else
        {
            $this->shield = true;
        }
    }

    // Fonction qui indique si le joueur est toujours vivant
    public function isAlive (): bool
    {
        if ($this->health <= 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Renvoie false si le nom du personnage créé est vide
     * @return bool
     */
    public function isValidName(): bool
    {
        return !empty($this->name);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth(int $health): void
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getDamage(): int
    {
        return $this->damage;
    }

    /**
     * @param int $damage
     */
    public function setDamage(int $damage): void
    {
        $this->damage = $damage;
    }

    /**
     * @return int
     */
    public function getForce(): int
    {
        return $this->force;
    }

    /**
     * @param int $force
     */
    public function setForce(int $force): void
    {
        $this->force = $force;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power): void
    {
        $this->power = $power;
    }
}