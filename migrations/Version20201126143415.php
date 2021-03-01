<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126143415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande ADD produits_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE6CD11A2CF ON ligne_de_commande (produits_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27CA2A78B2');
        $this->addSql('DROP INDEX IDX_29A5EC27CA2A78B2 ON produit');
        $this->addSql('ALTER TABLE produit DROP ligne_de_commande_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6CD11A2CF');
        $this->addSql('DROP INDEX IDX_7982ACE6CD11A2CF ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP produits_id');
        $this->addSql('ALTER TABLE produit ADD ligne_de_commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27CA2A78B2 FOREIGN KEY (ligne_de_commande_id) REFERENCES ligne_de_commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27CA2A78B2 ON produit (ligne_de_commande_id)');
    }
}
