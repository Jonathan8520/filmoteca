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
    public function findAll(): array
    {
        $stmt = $this->db->query("
            SELECT * FROM film
        ");

        $films = $stmt->fetchAll();

        return $this->entityMapperService->mapToEntities($films, Film::class);
    }

    // Récupérer un film grâce à son ID
    public function findById($id): Film
    {
        $stmt = $this->db->prepare("
            SELECT * FROM film WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);

        $film = $stmt->fetch();

        return $this->entityMapperService->mapToEntity($film, Film::class);
    }

    // Ajouter un nouveau film
    public function create(Film $film): bool
    {
        // Réinitialiser l'auto-incrément à 1
        $this->db->exec("ALTER TABLE film AUTO_INCREMENT = 1");

        $stmt = $this->db->prepare("
            INSERT INTO film (title, year, type, synopsis, director, created_at)
            VALUES (:title, :year, :type, :synopsis, :director, NOW())
        ");
        return $stmt->execute([
            ':title' => $film->getTitle(),
            ':year' => $film->getYear(),
            ':type' => $film->getType(),
            ':synopsis' => $film->getSynopsis(),
            ':director' => $film->getDirector(),
        ]);
    }

    // Mettre à jour un film existant
    public function update($id, Film $film): bool
    {
        $stmt = $this->db->prepare("
            UPDATE film
            SET title = :title, year = :year, type = :type, synopsis = :synopsis, director = :director
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $film->getTitle(),
            ':year' => $film->getYear(),
            ':type' => $film->getType(),
            ':synopsis' => $film->getSynopsis(),
            ':director' => $film->getDirector(),
        ]); 
    }
    
    // Supprimer un film grâce à son ID
    public function delete($id): bool
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
