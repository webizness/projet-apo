<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208095856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit_bar');
        $this->addSql('ALTER TABLE produit ADD bar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2789A253A FOREIGN KEY (bar_id) REFERENCES bar (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2789A253A ON produit (bar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_bar (produit_id INT NOT NULL, bar_id INT NOT NULL, INDEX IDX_374BFBD389A253A (bar_id), INDEX IDX_374BFBD3F347EFB (produit_id), PRIMARY KEY(produit_id, bar_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_bar ADD CONSTRAINT FK_374BFBD389A253A FOREIGN KEY (bar_id) REFERENCES bar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_bar ADD CONSTRAINT FK_374BFBD3F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2789A253A');
        $this->addSql('DROP INDEX IDX_29A5EC2789A253A ON produit');
        $this->addSql('ALTER TABLE produit DROP bar_id');
    }
}
