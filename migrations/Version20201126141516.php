<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126141516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_bar (produit_id INT NOT NULL, bar_id INT NOT NULL, INDEX IDX_374BFBD3F347EFB (produit_id), INDEX IDX_374BFBD389A253A (bar_id), PRIMARY KEY(produit_id, bar_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_bar ADD CONSTRAINT FK_374BFBD3F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_bar ADD CONSTRAINT FK_374BFBD389A253A FOREIGN KEY (bar_id) REFERENCES bar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE barman ADD bar_id INT NOT NULL');
        $this->addSql('ALTER TABLE barman ADD CONSTRAINT FK_77977D289A253A FOREIGN KEY (bar_id) REFERENCES bar (id)');
        $this->addSql('CREATE INDEX IDX_77977D289A253A ON barman (bar_id)');
        $this->addSql('ALTER TABLE commande ADD client_id INT DEFAULT NULL, ADD statuts_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE0EA5904 FOREIGN KEY (statuts_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DE0EA5904 ON commande (statuts_id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD commandes_id INT NOT NULL, ADD commentaire VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE68BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE68BF5C2E6 ON ligne_de_commande (commandes_id)');
        $this->addSql('ALTER TABLE produit ADD ligne_de_commande_id INT NOT NULL, ADD categories_id INT NOT NULL, ADD quantite INT NOT NULL, DROP commentaire');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27CA2A78B2 FOREIGN KEY (ligne_de_commande_id) REFERENCES ligne_de_commande (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27CA2A78B2 ON produit (ligne_de_commande_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A21214B7 ON produit (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit_bar');
        $this->addSql('ALTER TABLE barman DROP FOREIGN KEY FK_77977D289A253A');
        $this->addSql('DROP INDEX IDX_77977D289A253A ON barman');
        $this->addSql('ALTER TABLE barman DROP bar_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE0EA5904');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DE0EA5904 ON commande');
        $this->addSql('ALTER TABLE commande DROP client_id, DROP statuts_id');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE68BF5C2E6');
        $this->addSql('DROP INDEX IDX_7982ACE68BF5C2E6 ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP commandes_id, DROP commentaire');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27CA2A78B2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A21214B7');
        $this->addSql('DROP INDEX IDX_29A5EC27CA2A78B2 ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27A21214B7 ON produit');
        $this->addSql('ALTER TABLE produit ADD commentaire VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP ligne_de_commande_id, DROP categories_id, DROP quantite');
    }
}
