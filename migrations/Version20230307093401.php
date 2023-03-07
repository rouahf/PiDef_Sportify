<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307093401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31687374D5A1');
        $this->addSql('DROP INDEX IDX_BFDD31687374D5A1 ON articles');
        $this->addSql('ALTER TABLE articles DROP id_categ_a_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD id_categ_a_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31687374D5A1 FOREIGN KEY (id_categ_a_id) REFERENCES categorie_a (id)');
        $this->addSql('CREATE INDEX IDX_BFDD31687374D5A1 ON articles (id_categ_a_id)');
    }
}
