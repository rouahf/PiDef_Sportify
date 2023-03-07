<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307130424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, articles_id INT DEFAULT NULL, INDEX IDX_653627B81EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like_articles (post_like_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_2987343B8734D01 (post_like_id), INDEX IDX_29873431EBAF6CC (articles_id), PRIMARY KEY(post_like_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B81EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE post_like_articles ADD CONSTRAINT FK_2987343B8734D01 FOREIGN KEY (post_like_id) REFERENCES post_like (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like_articles ADD CONSTRAINT FK_29873431EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64919EB6921 ON user (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B81EBAF6CC');
        $this->addSql('ALTER TABLE post_like_articles DROP FOREIGN KEY FK_2987343B8734D01');
        $this->addSql('ALTER TABLE post_like_articles DROP FOREIGN KEY FK_29873431EBAF6CC');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE post_like_articles');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('DROP INDEX IDX_8D93D64919EB6921 ON user');
        $this->addSql('ALTER TABLE user DROP client_id');
    }
}
