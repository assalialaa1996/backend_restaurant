<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201101191458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE food.reservation ADD restaurant_id INT NOT NULL');
        $this->addSql('ALTER TABLE food.reservation ADD CONSTRAINT FK_5C915200B1E7706E FOREIGN KEY (restaurant_id) REFERENCES food.restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5C915200B1E7706E ON food.reservation (restaurant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE food.reservation DROP CONSTRAINT FK_5C915200B1E7706E');
        $this->addSql('DROP INDEX IDX_5C915200B1E7706E');
        $this->addSql('ALTER TABLE food.reservation DROP restaurant_id');
    }
}
