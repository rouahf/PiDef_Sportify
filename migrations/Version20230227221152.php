<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227221152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, phone VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, postal INT NOT NULL, pays VARCHAR(255) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, transport_name VARCHAR(255) NOT NULL, transport_price DOUBLE PRECISION NOT NULL, livraison_adresse LONGTEXT NOT NULL, is_paid TINYINT(1) NOT NULL, more_informations LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quantity INT NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_details (id INT AUTO_INCREMENT NOT NULL, carts_id INT DEFAULT NULL, product_name VARCHAR(255) NOT NULL, product_price DOUBLE PRECISION NOT NULL, product_quantity INT NOT NULL, subtotal_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_89FCC38DBCB5C6F5 (carts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, orders_id INT DEFAULT NULL, product_name VARCHAR(255) NOT NULL, product_price DOUBLE PRECISION NOT NULL, product_quantity INT NOT NULL, subtotal_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_845CA2C1CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, transport_name VARCHAR(255) NOT NULL, transport_price DOUBLE PRECISION NOT NULL, livraison_adresse LONGTEXT NOT NULL, is_paid TINYINT(1) NOT NULL, more_informations LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quantity INT NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL, stripe_session_id VARCHAR(255) DEFAULT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews_product (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, note INT NOT NULL, comment LONGTEXT NOT NULL, INDEX IDX_E0851D6CA76ED395 (user_id), INDEX IDX_E0851D6C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, name_transport VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_details ADD CONSTRAINT FK_89FCC38DBCB5C6F5 FOREIGN KEY (carts_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reviews_product ADD CONSTRAINT FK_E0851D6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reviews_product ADD CONSTRAINT FK_E0851D6C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_details DROP FOREIGN KEY FK_89FCC38DBCB5C6F5');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1CFFE9AD6');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE reviews_product DROP FOREIGN KEY FK_E0851D6CA76ED395');
        $this->addSql('ALTER TABLE reviews_product DROP FOREIGN KEY FK_E0851D6C4584665A');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
    }
}
