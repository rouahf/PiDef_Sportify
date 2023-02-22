<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215093011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, returned TINYINT(1) NOT NULL, INDEX IDX_20F33ED1FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED1FD02F13 FOREIGN KEY (evenement_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE utilisateur DROP roleut');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1FD02F13');
        $this->addSql('DROP TABLE tool');
        $this->addSql('ALTER TABLE utilisateur ADD roleut VARCHAR(255) NOT NULL');
    }
}
