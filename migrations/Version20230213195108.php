<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213195108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roleutilisateur (id INT AUTO_INCREMENT NOT NULL, roleut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, roleutilisateur_id INT DEFAULT NULL, nomut VARCHAR(255) NOT NULL, prenomut VARCHAR(255) NOT NULL, emailut VARCHAR(255) NOT NULL, mdput VARCHAR(255) NOT NULL, roleut VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B3DB2969F2 (roleutilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DB2969F2 FOREIGN KEY (roleutilisateur_id) REFERENCES roleutilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DB2969F2');
        $this->addSql('DROP TABLE roleutilisateur');
        $this->addSql('DROP TABLE utilisateur');
    }
}
