<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307115349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details ADD orders_id INT DEFAULT NULL, ADD product_name VARCHAR(255) NOT NULL, ADD product_price DOUBLE PRECISION NOT NULL, ADD product_quantity INT NOT NULL, ADD subtotal_ht DOUBLE PRECISION NOT NULL, ADD taxe DOUBLE PRECISION NOT NULL, ADD sub_total_ttc DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C1CFFE9AD6 ON order_details (orders_id)');
        $this->addSql('ALTER TABLE orders ADD user_id INT DEFAULT NULL, ADD reference VARCHAR(255) NOT NULL, ADD fullname VARCHAR(255) NOT NULL, ADD transport_name VARCHAR(255) NOT NULL, ADD transport_price DOUBLE PRECISION NOT NULL, ADD livraison_adresse LONGTEXT NOT NULL, ADD is_paid TINYINT(1) NOT NULL, ADD more_informations LONGTEXT DEFAULT NULL, ADD quantity INT NOT NULL, ADD sub_total_ht DOUBLE PRECISION NOT NULL, ADD taxe DOUBLE PRECISION NOT NULL, ADD sub_total_ttc DOUBLE PRECISION NOT NULL, ADD stripe_session_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEA76ED395 ON orders (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP INDEX IDX_E52FFDEEA76ED395 ON orders');
        $this->addSql('ALTER TABLE orders DROP user_id, DROP reference, DROP fullname, DROP transport_name, DROP transport_price, DROP livraison_adresse, DROP is_paid, DROP more_informations, DROP quantity, DROP sub_total_ht, DROP taxe, DROP sub_total_ttc, DROP stripe_session_id');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1CFFE9AD6');
        $this->addSql('DROP INDEX IDX_845CA2C1CFFE9AD6 ON order_details');
        $this->addSql('ALTER TABLE order_details DROP orders_id, DROP product_name, DROP product_price, DROP product_quantity, DROP subtotal_ht, DROP taxe, DROP sub_total_ttc');
    }
}
