<?php
function DbConnexion()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=bdd_musicaly;charset=utf8', 'root', '');
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
