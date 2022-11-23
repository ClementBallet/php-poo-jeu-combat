<?php

class Dice
{
    private int $faces;

    /**
     * Constructeur de la classe dé
     * @param int $faces Nombre de faces souhaitées
     */
    public function __construct (int $faces = 6)
    {
        $this->faces = $faces;
    }

    /**
     * Permet de lancer le dé et de récupérer une valeur entre 1 et 6 (ou le nombre souhaité)
     * @return int
     */
    public function roll (): int
    {
        return rand(1, $this->faces);
    }
}