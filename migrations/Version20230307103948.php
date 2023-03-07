<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307103948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, id_article_id INT DEFAULT NULL, contenu_c VARCHAR(255) NOT NULL, date_com DATETIME NOT NULL, nom_c VARCHAR(255) NOT NULL, email_c VARCHAR(255) NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_D9BEC0C4D71E064B (id_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4D71E064B FOREIGN KEY (id_article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31684CF7D40F');
        $this->addSql('DROP INDEX idx_bfdd31684cf7d40f ON articles');
        $this->addSql('CREATE INDEX IDX_BFDD31687374D5A1 ON articles (id_categ_a_id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31684CF7D40F FOREIGN KEY (id_categ_a_id) REFERENCES categorie_a (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4D71E064B');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31687374D5A1');
        $this->addSql('DROP INDEX idx_bfdd31687374d5a1 ON articles');
        $this->addSql('CREATE INDEX IDX_BFDD31684CF7D40F ON articles (id_categ_a_id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31687374D5A1 FOREIGN KEY (id_categ_a_id) REFERENCES categorie_a (id)');
    }
}
