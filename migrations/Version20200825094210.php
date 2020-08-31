<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825094210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discussion_livrable_partiel_dun_apprenant (id INT AUTO_INCREMENT NOT NULL, livrablepartieldunapprenant_id INT DEFAULT NULL, discussion_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_90DEC06424A909CF (livrablepartieldunapprenant_id), INDEX IDX_90DEC0641ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion_livrable_partiel_dun_apprenant ADD CONSTRAINT FK_90DEC06424A909CF FOREIGN KEY (livrablepartieldunapprenant_id) REFERENCES livrable_partiel_dun_apprenant (id)');
        $this->addSql('ALTER TABLE discussion_livrable_partiel_dun_apprenant ADD CONSTRAINT FK_90DEC0641ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('DROP TABLE livrable_partiel_dun_apprenant_discussion');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livrable_partiel_dun_apprenant_discussion (livrable_partiel_dun_apprenant_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_6C5615B01ADED311 (discussion_id), INDEX IDX_6C5615B087B308A0 (livrable_partiel_dun_apprenant_id), PRIMARY KEY(livrable_partiel_dun_apprenant_id, discussion_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant_discussion ADD CONSTRAINT FK_6C5615B01ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant_discussion ADD CONSTRAINT FK_6C5615B087B308A0 FOREIGN KEY (livrable_partiel_dun_apprenant_id) REFERENCES livrable_partiel_dun_apprenant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE discussion_livrable_partiel_dun_apprenant');
    }
}
