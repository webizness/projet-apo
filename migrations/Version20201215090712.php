<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215090712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barman CHANGE image_name image_name VARCHAR(255) NOT NULL, CHANGE image_size image_size INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barman CHANGE image_name image_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_size image_size INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit DROP image_name, DROP image_size, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
