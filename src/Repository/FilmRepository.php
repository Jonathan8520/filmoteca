<?php

namespace App\Repository;

use PDO;

class filmRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer tous les films
    public function findAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM film");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un film par son ID
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM film WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

        /* 
            $stmt = $this->pdo->prepare("SELECT * FROM film WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
        
            $film = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $film ?: null; // Retourne null si aucun film n'est trouvé
         */
    }

    // Ajouter un nouveau film
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO film (title, year, genre, synopsis, director, created_at) 
            VALUES (:title, :year, :genre, :synopsis, :director, NOW())
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':year' => $data['year'],
            ':genre' => $data['genre'],
            ':synopsis' => $data['synopsis'],
            ':director' => $data['director']
        ]);
    }

    // Mettre à jour un film existant
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE film 
            SET title = :title, year = :year, genre = :genre, synopsis = :synopsis, director = :director
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':year' => $data['year'],
            ':genre' => $data['genre'],
            ':synopsis' => $data['synopsis'],
            ':director' => $data['director']
        ]);
    }

    // Supprimer un film par son ID
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM film WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
