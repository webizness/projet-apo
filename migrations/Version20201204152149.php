<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204152149 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bar CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE barman CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD code_postal INT NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD telephone INT NOT NULL, ADD date_de_naissance INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bar CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE barman CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP adresse, DROP code_postal, DROP ville, DROP telephone, DROP date_de_naissance');
    }
}
