<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103130511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE food.restaurant ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE food.restaurant DROP logo');
        $this->addSql('ALTER TABLE food.restaurant ADD CONSTRAINT FK_B37C2FADF98F144A FOREIGN KEY (logo_id) REFERENCES food.media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B37C2FADF98F144A ON food.restaurant (logo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE food.restaurant DROP CONSTRAINT FK_B37C2FADF98F144A');
        $this->addSql('DROP INDEX UNIQ_B37C2FADF98F144A');
        $this->addSql('ALTER TABLE food.restaurant ADD logo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE food.restaurant DROP logo_id');
    }
}
