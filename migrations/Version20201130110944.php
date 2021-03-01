<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130110944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE0EA5904');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP INDEX IDX_6EEAA67DE0EA5904 ON commande');
        $this->addSql('ALTER TABLE commande ADD statut TINYINT(1) NOT NULL, DROP statuts_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande ADD statuts_id INT NOT NULL, DROP statut');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE0EA5904 FOREIGN KEY (statuts_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DE0EA5904 ON commande (statuts_id)');
    }
}
