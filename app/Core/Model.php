<?php

namespace App\Core;

use PDOStatement;

class Model extends Db
{
    protected $table;

    private $db;

    public function dbQuery(string $sql, ?array $params = null)
    {
        // On récupère l'instance de base de données
        $this->db = Db::getInstance();

        // On vérifie si des paramètres existent
        if($params === null){
            // Pas de paramètres, requête classique
            return $this->db->query($sql);
        }else{
            // Des paramètres, requête préparée
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
    }

    public function findAll(): array
    {
        $stmt = $this->dbQuery('SELECT * FROM ' . $this->table);
        return $stmt->fetchAll();
    }

    public function find(int $id): array|bool
    {
        $stmt = $this->dbQuery('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $stmt->fetch();
    }

    public function findBy(array $criterias, int $limit = 0): array
    {
        // SELECT * FROM table WHERE champ1=valeur1 AND champ2=valeur2 LIMIT 3
        $champs = [];
        $valeurs = [];

        foreach($criterias as $champ => $valeur){
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $liste_champs = implode(' AND ', $champs);

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs;

        if($limit > 0){
            $sql .= ' LIMIT ' . $limit;
        }


        return $this->dbQuery($sql, $valeurs)->fetchAll();
    }

    public function findOneBy(array $criterias): array
    {
        return $this->findBy($criterias, 1)[0];
    }

    public function create(array $data): bool|PDOStatement
    {
        // INSERT INTO articles (title, content) VALUES (?, ?)
        // $data = ['title' => 'Article 4', 'content' => 'Contenu']

        // On initialise 3 variables
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle sur $data
        foreach($data as $champ => $valeur){
            $champs[] = $champ;
            $valeurs[] = $valeur;
            $inter[] = '?';
        }

        // On transforme les tableaux champs et inter en chaines de caractères
        $liste_champs = implode(',', $champs);
        $liste_inter = implode(',', $inter);

        // On exécute la requête
        $stmt = $this->dbQuery('INSERT INTO ' . $this->table . '(' . $liste_champs . ') VALUES (' . $liste_inter . ');', $valeurs);

        return $stmt;
    }

    /**public function update(array $data): bool|PDOStatement
    {
        // UPDATE table SET colonne=valeur, colonne2=valeur2 WHERE id=?
        $champs = [];
        $valeurs = [];

        foreach($data as $champ => $valeur){
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $valeurs[] = $id;

        $liste_champs = implode(',', $champs);

        return $this->dbQuery('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?;', $valeurs);
    }*/
    public function update(array $data): bool|PDOStatement
    {
        if (!isset($data['id'])) {
            throw new \InvalidArgumentException("L'ID est requis pour une mise à jour.");
        }

        $id = $data['id'];
        unset($data['id']); // on enlève l'id des champs à mettre à jour

        $champs = [];
        $valeurs = [];

        foreach($data as $champ => $valeur){
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $valeurs[] = $id; // on ajoute l'id à la fin pour le WHERE

        $liste_champs = implode(', ', $champs);

        return $this->dbQuery(
            'UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?;',
            $valeurs
        );
    }
    public function delete(int $id): bool|PDOStatement
    {
        return $this->dbQuery('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }
}