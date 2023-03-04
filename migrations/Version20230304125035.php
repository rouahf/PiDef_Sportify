<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304125035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_utilisateur DROP FOREIGN KEY FK_B92954D21EBAF6CC');
        $this->addSql('ALTER TABLE articles_utilisateur DROP FOREIGN KEY FK_B92954D2FB88E14F');
        $this->addSql('DROP TABLE articles_utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_utilisateur (articles_id INT NOT NULL, utilisateur_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B92954D2FB88E14F (utilisateur_id), INDEX IDX_B92954D21EBAF6CC (articles_id), PRIMARY KEY(articles_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE articles_utilisateur ADD CONSTRAINT FK_B92954D21EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_utilisateur ADD CONSTRAINT FK_B92954D2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }
}
