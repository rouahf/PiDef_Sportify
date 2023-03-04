<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304141631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_like ADD likes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B82F23775F FOREIGN KEY (likes_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_653627B82F23775F ON post_like (likes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE likes');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B82F23775F');
        $this->addSql('DROP INDEX IDX_653627B82F23775F ON post_like');
        $this->addSql('ALTER TABLE post_like DROP likes_id');
    }
}
