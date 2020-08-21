<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820193509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, discussion_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_67F068BC1ADED311 (discussion_id), INDEX IDX_67F068BC155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_dun_apprenant_discussion (livrable_partiel_dun_apprenant_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_6C5615B087B308A0 (livrable_partiel_dun_apprenant_id), INDEX IDX_6C5615B01ADED311 (discussion_id), PRIMARY KEY(livrable_partiel_dun_apprenant_id, discussion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant_discussion ADD CONSTRAINT FK_6C5615B087B308A0 FOREIGN KEY (livrable_partiel_dun_apprenant_id) REFERENCES livrable_partiel_dun_apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant_discussion ADD CONSTRAINT FK_6C5615B01ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC1ADED311');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant_discussion DROP FOREIGN KEY FK_6C5615B01ADED311');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE livrable_partiel_dun_apprenant_discussion');
    }
}
