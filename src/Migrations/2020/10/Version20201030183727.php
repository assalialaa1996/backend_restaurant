<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030183727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE food.restaurant DROP CONSTRAINT fk_b37c2fad38248176');
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE food.currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE food.currency (id INT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, symbol VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE currency');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE food.restaurant DROP CONSTRAINT FK_B37C2FAD38248176');
        $this->addSql('DROP SEQUENCE food.currency_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE currency (id INT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, symbol VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE food.currency');
    }
}
