<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712183215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping_fees (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price INTEGER NOT NULL, discr VARCHAR(255) NOT NULL, slice INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id, title FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, shipping_fees_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_1C52F9587A23D5E1 FOREIGN KEY (shipping_fees_id) REFERENCES shipping_fees (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO brand (id, title) SELECT id, title FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C52F9587A23D5E1 ON brand (shipping_fees_id)');
        $this->addSql('DROP INDEX IDX_1F1B251E8D9F6D38');
        $this->addSql('DROP INDEX UNIQ_1F1B251E4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, order_id, product_id, quantity FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER NOT NULL, product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_1F1B251E4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1F1B251E8D9F6D38 FOREIGN KEY (order_id) REFERENCES \'order\' (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, order_id, product_id, quantity) SELECT id, order_id, product_id, quantity FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E8D9F6D38 ON item (order_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E4584665A ON item (product_id)');
        $this->addSql('DROP INDEX IDX_D34A04AD44F5D008');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, brand_id, title, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brand_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, brand_id, title, price) SELECT id, brand_id, title, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD44F5D008 ON product (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shipping_fees');
        $this->addSql('DROP INDEX UNIQ_1C52F9587A23D5E1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__brand AS SELECT id, title FROM brand');
        $this->addSql('DROP TABLE brand');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO brand (id, title) SELECT id, title FROM __temp__brand');
        $this->addSql('DROP TABLE __temp__brand');
        $this->addSql('DROP INDEX UNIQ_1F1B251E4584665A');
        $this->addSql('DROP INDEX IDX_1F1B251E8D9F6D38');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, product_id, order_id, quantity FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER NOT NULL, product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_1F1B251E8D9F6D38 FOREIGN KEY (order_id) REFERENCES \'order\' (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, product_id, order_id, quantity) SELECT id, product_id, order_id, quantity FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E4584665A ON item (product_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E8D9F6D38 ON item (order_id)');
        $this->addSql('DROP INDEX IDX_D34A04AD44F5D008');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, brand_id, title, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brand_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO product (id, brand_id, title, price) SELECT id, brand_id, title, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD44F5D008 ON product (brand_id)');
    }
}
