<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820192601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livrable_partiel_dun_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_partiel_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, delai VARCHAR(255) NOT NULL, date_rendu DATE NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_63C57DC1C5697D6D (apprenant_id), INDEX IDX_63C57DC1519178C4 (livrable_partiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant ADD CONSTRAINT FK_63C57DC1C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant ADD CONSTRAINT FK_63C57DC1519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE livrable_partiel_dun_apprenant');
    }
}
