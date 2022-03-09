<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309115228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actualite_categorie (actualite_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_EC878E9DA2843073 (actualite_id), INDEX IDX_EC878E9DBCF5E72D (categorie_id), PRIMARY KEY(actualite_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, actualites_id INT NOT NULL, contenu LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, rgpd TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_67F068BC2EDF1993 (actualites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite_categorie ADD CONSTRAINT FK_EC878E9DA2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actualite_categorie ADD CONSTRAINT FK_EC878E9DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC2EDF1993 FOREIGN KEY (actualites_id) REFERENCES actualite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite_categorie DROP FOREIGN KEY FK_EC878E9DA2843073');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2EDF1993');
        $this->addSql('ALTER TABLE actualite_categorie DROP FOREIGN KEY FK_EC878E9DBCF5E72D');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE actualite_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
