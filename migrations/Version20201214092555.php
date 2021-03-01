<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214092555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD quantite INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP quantite');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE password password INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande DROP quantite');
        $this->addSql('ALTER TABLE produit ADD quantite INT DEFAULT NULL');
    }
}
