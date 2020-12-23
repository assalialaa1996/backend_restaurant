<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103185351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE food.reservation ADD cancel_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE food.reservation ALTER date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE food.reservation ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE food.reservation ALTER date DROP NOT NULL');
        $this->addSql('ALTER TABLE food.commande ALTER date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE food.commande ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE food.commande ALTER date_prise_encharge TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE food.commande ALTER date_prise_encharge DROP DEFAULT');
        $this->addSql('ALTER TABLE food.commande ALTER date_livraison TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE food.commande ALTER date_livraison DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE food.reservation DROP cancel_date');
        $this->addSql('ALTER TABLE food.reservation ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE food.reservation ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE food.reservation ALTER date SET NOT NULL');
        $this->addSql('ALTER TABLE food.commande ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE food.commande ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE food.commande ALTER date_prise_encharge TYPE DATE');
        $this->addSql('ALTER TABLE food.commande ALTER date_prise_encharge DROP DEFAULT');
        $this->addSql('ALTER TABLE food.commande ALTER date_livraison TYPE DATE');
        $this->addSql('ALTER TABLE food.commande ALTER date_livraison DROP DEFAULT');
    }
}
