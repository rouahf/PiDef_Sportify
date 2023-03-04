<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304103946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_utilisateur ADD CONSTRAINT FK_B92954D21EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_utilisateur ADD CONSTRAINT FK_B92954D2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_utilisateur DROP FOREIGN KEY FK_B92954D21EBAF6CC');
        $this->addSql('ALTER TABLE articles_utilisateur DROP FOREIGN KEY FK_B92954D2FB88E14F');
    }
}
