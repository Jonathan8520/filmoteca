# Modèle de base de données pour **Filmoteca**

## Table `films`
| Colonne      | Type         | Description                       |
|--------------|--------------|-----------------------------------|
| `id`         | INT, PK, AI  | Identifiant unique du film       |
| `title`      | VARCHAR(255) | Titre du film                    |
| `year`       | YEAR         | Année de sortie                  |
| `type`       | VARCHAR(100) | Genre du film                    |
| `synopsis`   | TEXT         | Résumé du film                   |
| `director`   | VARCHAR(255) | Nom du réalisateur               |
| `deleted_at` | TIMESTAMP    | Date d'archivage dans la collection  |
| `created_at` | TIMESTAMP    | Date d'ajout dans la collection  |
| `updated_at` | TIMESTAMP    | Date de modification dans la collection  |

- **Description** : Contient les informations de base sur chaque film, y compris le titre, l’année de sortie, le genre, un synopsis et le nom du réalisateur.

## Table `reviews`
| Colonne      | Type         | Description                           |
|--------------|--------------|---------------------------------------|
| `id`         | INT, PK, AI  | Identifiant unique de l'avis         |
| `film_id`    | INT, FK      | Identifiant du film (clé étrangère)  |
| `rating`     | TINYINT      | Note sur 5                           |
| `comment`    | TEXT         | Commentaire de l’utilisateur         |
| `created_at` | TIMESTAMP    | Date de l'avis                       |

- **Relation** : Chaque avis est lié à un film spécifique par la colonne `film_id`, qui fait référence à `films.id`. Un film peut donc avoir plusieurs avis.

---

## Exemples de requêtes SQL

- **Récupérer tous les films** :
  ```sql
  SELECT * FROM films;
