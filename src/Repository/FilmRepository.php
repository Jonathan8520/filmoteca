<?php

namespace App\Repository;

use App\Core\DatabaseConnection;
use App\Entity\Film;
use App\Service\EntityMapper;

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

        return $this->entityMapperService->mapToEntities($films, Film::class);
    }

    // Récupérer un film grâce à son ID
    public function findById($id)
    {
        $query = 'SELECT * FROM film WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $film = $stmt->fetch();

        return $this->entityMapperService->mapToEntity($film, Film::class);
    }

    // Ajouter un nouveau film
    public function create($data)
    {
        // Réinitialiser l'auto-incrément à 1
        $this->db->exec("ALTER TABLE film AUTO_INCREMENT = 1");

        $stmt = $this->db->prepare("
            INSERT INTO film (title, year, type, synopsis, director, created_at)
            VALUES (:title, :year, :type, :synopsis, :director, NOW())
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':year' => $data['year'],
            ':type' => $data['type'],
            ':synopsis' => $data['synopsis'],
            ':director' => $data['director'],
        ]);
    }

    // Mettre à jour un film existant
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE film
            SET title = :title, year = :year, type = :type, synopsis = :synopsis, director = :director
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':year' => $data['year'],
            ':type' => $data['type'],
            ':synopsis' => $data['synopsis'],
            ':director' => $data['director'],
        ]);
    }

    // Supprimer un film grâce à son ID
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM film WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if ($result) {
            // Réinitialiser l'auto-incrément
            $this->db->exec("ALTER TABLE film AUTO_INCREMENT = 1");
        }

        return $result;
    }
}
