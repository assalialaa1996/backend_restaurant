<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030183618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA food');
        $this->addSql('CREATE SEQUENCE food.restaurantservice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.line_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.commande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.restaurant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.menu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.livreur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.tabl_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.openinghours_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food.speciality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE food.restaurantservice (id INT NOT NULL, label VARCHAR(255) NOT NULL, key VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.reservation (id INT NOT NULL, client_id INT DEFAULT NULL, tabl_id INT DEFAULT NULL, date DATE NOT NULL, nb_personnes INT NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C91520019EB6921 ON food.reservation (client_id)');
        $this->addSql('CREATE INDEX IDX_5C9152004DE1870D ON food.reservation (tabl_id)');
        $this->addSql('CREATE TABLE food.media (id INT NOT NULL, restaurant_id INT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5B33BA82B1E7706E ON food.media (restaurant_id)');
        $this->addSql('CREATE TABLE food.line_item (id INT NOT NULL, product_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantity INT NOT NULL, total DOUBLE PRECISION DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_152755FA4584665A ON food.line_item (product_id)');
        $this->addSql('CREATE INDEX IDX_152755FA82EA2E54 ON food.line_item (commande_id)');
        $this->addSql('CREATE TABLE food.commande (id INT NOT NULL, client_id INT DEFAULT NULL, payment_info_id INT DEFAULT NULL, livreur_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, date DATE NOT NULL, adresse_livraison VARCHAR(255) DEFAULT NULL, date_prise_encharge DATE DEFAULT NULL, date_livraison DATE DEFAULT NULL, status VARCHAR(50) DEFAULT \'TODO\' NOT NULL, order_type VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A17F56A919EB6921 ON food.commande (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A17F56A944C2CF12 ON food.commande (payment_info_id)');
        $this->addSql('CREATE INDEX IDX_A17F56A9F8646701 ON food.commande (livreur_id)');
        $this->addSql('CREATE INDEX IDX_A17F56A9B1E7706E ON food.commande (restaurant_id)');
        $this->addSql('CREATE TABLE food.restaurantowner (id INT NOT NULL, restaurant_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D856E7CB1E7706E ON food.restaurantowner (restaurant_id)');
        $this->addSql('CREATE TABLE food.account (id INT NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, address VARCHAR(50) DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, update_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, kind VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.restaurant (id INT NOT NULL, speciality_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, min_price INT NOT NULL, duree_livraison VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, nbre_livreur INT NOT NULL, delivery VARCHAR(255) NOT NULL, prix_min_livraison DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, administrative_area_level1 VARCHAR(255) NOT NULL, street_number INT NOT NULL, country VARCHAR(255) NOT NULL, route VARCHAR(255) NOT NULL, locality VARCHAR(255) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B37C2FAD3B5A08D7 ON food.restaurant (speciality_id)');
        $this->addSql('CREATE INDEX IDX_B37C2FAD38248176 ON food.restaurant (currency_id)');
        $this->addSql('CREATE TABLE food.restaurant_service (restaurant_id INT NOT NULL, restaurant_service_id INT NOT NULL, PRIMARY KEY(restaurant_id, restaurant_service_id))');
        $this->addSql('CREATE INDEX IDX_B6EF7FF9B1E7706E ON food.restaurant_service (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_B6EF7FF9486689D7 ON food.restaurant_service (restaurant_service_id)');
        $this->addSql('CREATE TABLE food.menu (id INT NOT NULL, restaurant_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C905B3DB1E7706E ON food.menu (restaurant_id)');
        $this->addSql('CREATE TABLE food.payment (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.client (id INT NOT NULL, mobile VARCHAR(20) DEFAULT NULL, gender CHAR(1) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.admin (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.review (id INT NOT NULL, client_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_737230FA19EB6921 ON food.review (client_id)');
        $this->addSql('CREATE INDEX IDX_737230FAB1E7706E ON food.review (restaurant_id)');
        $this->addSql('CREATE TABLE food.livreur (id INT NOT NULL, restaurant_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C41F035BB1E7706E ON food.livreur (restaurant_id)');
        $this->addSql('CREATE TABLE food.tabl (id INT NOT NULL, restaurant_id INT DEFAULT NULL, chair_number INT NOT NULL, status VARCHAR(255) DEFAULT \'NOT_RESERVED\', deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EE560C38B1E7706E ON food.tabl (restaurant_id)');
        $this->addSql('CREATE TABLE food.openinghours (id INT NOT NULL, start_time DATE NOT NULL, end_time DATE NOT NULL, opening_days VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.product (id INT NOT NULL, menu_id INT DEFAULT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, stock INT DEFAULT NULL, seuil INT DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FC2F499BCCD7E912 ON food.product (menu_id)');
        $this->addSql('CREATE INDEX IDX_FC2F499B3DA5256D ON food.product (image_id)');
        $this->addSql('CREATE TABLE currency (id INT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, symbol VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE food.speciality (id INT NOT NULL, image_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, key VARCHAR(255) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB3E9D1C3DA5256D ON food.speciality (image_id)');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('ALTER TABLE food.reservation ADD CONSTRAINT FK_5C91520019EB6921 FOREIGN KEY (client_id) REFERENCES food.client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.reservation ADD CONSTRAINT FK_5C9152004DE1870D FOREIGN KEY (tabl_id) REFERENCES food.tabl (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.media ADD CONSTRAINT FK_5B33BA82B1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.line_item ADD CONSTRAINT FK_152755FA4584665A FOREIGN KEY (product_id) REFERENCES food.product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.line_item ADD CONSTRAINT FK_152755FA82EA2E54 FOREIGN KEY (commande_id) REFERENCES food.commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.commande ADD CONSTRAINT FK_A17F56A919EB6921 FOREIGN KEY (client_id) REFERENCES food.client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.commande ADD CONSTRAINT FK_A17F56A944C2CF12 FOREIGN KEY (payment_info_id) REFERENCES food.payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.commande ADD CONSTRAINT FK_A17F56A9F8646701 FOREIGN KEY (livreur_id) REFERENCES food.livreur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.commande ADD CONSTRAINT FK_A17F56A9B1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurantowner ADD CONSTRAINT FK_2D856E7CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurantowner ADD CONSTRAINT FK_2D856E7CBF396750 FOREIGN KEY (id) REFERENCES food.account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurant ADD CONSTRAINT FK_B37C2FAD3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES food.speciality (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurant ADD CONSTRAINT FK_B37C2FAD38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurant_service ADD CONSTRAINT FK_B6EF7FF9B1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.restaurant_service ADD CONSTRAINT FK_B6EF7FF9486689D7 FOREIGN KEY (restaurant_service_id) REFERENCES food.restaurantservice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.menu ADD CONSTRAINT FK_C905B3DB1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.client ADD CONSTRAINT FK_CD75B569BF396750 FOREIGN KEY (id) REFERENCES food.account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.admin ADD CONSTRAINT FK_B91116F8BF396750 FOREIGN KEY (id) REFERENCES food.account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.review ADD CONSTRAINT FK_737230FA19EB6921 FOREIGN KEY (client_id) REFERENCES food.client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.review ADD CONSTRAINT FK_737230FAB1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.livreur ADD CONSTRAINT FK_C41F035BB1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.tabl ADD CONSTRAINT FK_EE560C38B1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.product ADD CONSTRAINT FK_FC2F499BCCD7E912 FOREIGN KEY (menu_id) REFERENCES food.menu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.product ADD CONSTRAINT FK_FC2F499B3DA5256D FOREIGN KEY (image_id) REFERENCES food.media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE food.speciality ADD CONSTRAINT FK_AB3E9D1C3DA5256D FOREIGN KEY (image_id) REFERENCES food.media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE food.restaurant_service DROP CONSTRAINT FK_B6EF7FF9486689D7');
        $this->addSql('ALTER TABLE food.product DROP CONSTRAINT FK_FC2F499B3DA5256D');
        $this->addSql('ALTER TABLE food.speciality DROP CONSTRAINT FK_AB3E9D1C3DA5256D');
        $this->addSql('ALTER TABLE food.line_item DROP CONSTRAINT FK_152755FA82EA2E54');
        $this->addSql('ALTER TABLE food.restaurantowner DROP CONSTRAINT FK_2D856E7CBF396750');
        $this->addSql('ALTER TABLE food.client DROP CONSTRAINT FK_CD75B569BF396750');
        $this->addSql('ALTER TABLE food.admin DROP CONSTRAINT FK_B91116F8BF396750');
        $this->addSql('ALTER TABLE food.media DROP CONSTRAINT FK_5B33BA82B1E7706E');
        $this->addSql('ALTER TABLE food.commande DROP CONSTRAINT FK_A17F56A9B1E7706E');
        $this->addSql('ALTER TABLE food.restaurantowner DROP CONSTRAINT FK_2D856E7CB1E7706E');
        $this->addSql('ALTER TABLE food.restaurant_service DROP CONSTRAINT FK_B6EF7FF9B1E7706E');
        $this->addSql('ALTER TABLE food.menu DROP CONSTRAINT FK_C905B3DB1E7706E');
        $this->addSql('ALTER TABLE food.review DROP CONSTRAINT FK_737230FAB1E7706E');
        $this->addSql('ALTER TABLE food.livreur DROP CONSTRAINT FK_C41F035BB1E7706E');
        $this->addSql('ALTER TABLE food.tabl DROP CONSTRAINT FK_EE560C38B1E7706E');
        $this->addSql('ALTER TABLE food.product DROP CONSTRAINT FK_FC2F499BCCD7E912');
        $this->addSql('ALTER TABLE food.commande DROP CONSTRAINT FK_A17F56A944C2CF12');
        $this->addSql('ALTER TABLE food.reservation DROP CONSTRAINT FK_5C91520019EB6921');
        $this->addSql('ALTER TABLE food.commande DROP CONSTRAINT FK_A17F56A919EB6921');
        $this->addSql('ALTER TABLE food.review DROP CONSTRAINT FK_737230FA19EB6921');
        $this->addSql('ALTER TABLE food.commande DROP CONSTRAINT FK_A17F56A9F8646701');
        $this->addSql('ALTER TABLE food.reservation DROP CONSTRAINT FK_5C9152004DE1870D');
        $this->addSql('ALTER TABLE food.line_item DROP CONSTRAINT FK_152755FA4584665A');
        $this->addSql('ALTER TABLE food.restaurant DROP CONSTRAINT FK_B37C2FAD38248176');
        $this->addSql('ALTER TABLE food.restaurant DROP CONSTRAINT FK_B37C2FAD3B5A08D7');
        $this->addSql('DROP SEQUENCE food.restaurantservice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.line_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.commande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.restaurant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.menu_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.livreur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.tabl_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.openinghours_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food.speciality_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP TABLE food.restaurantservice');
        $this->addSql('DROP TABLE food.reservation');
        $this->addSql('DROP TABLE food.media');
        $this->addSql('DROP TABLE food.line_item');
        $this->addSql('DROP TABLE food.commande');
        $this->addSql('DROP TABLE food.restaurantowner');
        $this->addSql('DROP TABLE food.account');
        $this->addSql('DROP TABLE food.restaurant');
        $this->addSql('DROP TABLE food.restaurant_service');
        $this->addSql('DROP TABLE food.menu');
        $this->addSql('DROP TABLE food.payment');
        $this->addSql('DROP TABLE food.client');
        $this->addSql('DROP TABLE food.admin');
        $this->addSql('DROP TABLE food.review');
        $this->addSql('DROP TABLE food.livreur');
        $this->addSql('DROP TABLE food.tabl');
        $this->addSql('DROP TABLE food.openinghours');
        $this->addSql('DROP TABLE food.product');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE food.speciality');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
