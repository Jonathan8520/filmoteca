<?php

namespace App\Repository;

use App\Core\DatabaseConnection;
use App\Service\EntityMapper;
use App\Entity\FilmEntity;

class FilmRepository
{
    private \PDO $db;
    private EntityMapper $entityMapperService;

    public function __construct()
    {
        $this->db = DatabaseConnection::getConnection();
        $this->entityMapperService = new EntityMapper();
    }

    // Récupérer tous les films
    public function findAll()
    {
        $query = 'SELECT * FROM film';
        $stmt = $this->db->query($query);

        $films = $stmt->fetchAll();

        return $this->entityMapperService->mapToEntities($films, FilmEntity::class);
    }

    // Récupérer un film par son ID
    public function findById($id)
    {
        $query = 'SELECT * FROM film WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $film = $stmt->fetch();

        return $this->entityMapperService->mapToEntity($film, FilmEntity::class);
    }

    // Ajouter un nouveau film
    public function create($data)
    {
        $stmt = $this->db->prepare("
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
        $stmt = $this->db->prepare("
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
        $stmt = $this->db->prepare("DELETE FROM film WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
