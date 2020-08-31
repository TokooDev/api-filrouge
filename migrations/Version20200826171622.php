<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826171622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion ADD livrable_partiel_dun_apprenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F87B308A0 FOREIGN KEY (livrable_partiel_dun_apprenant_id) REFERENCES livrable_partiel_dun_apprenant (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F87B308A0 ON discussion (livrable_partiel_dun_apprenant_id)');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant DROP commentaire');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F87B308A0');
        $this->addSql('DROP INDEX IDX_C0B9F90F87B308A0 ON discussion');
        $this->addSql('ALTER TABLE discussion DROP livrable_partiel_dun_apprenant_id');
        $this->addSql('ALTER TABLE livrable_partiel_dun_apprenant ADD commentaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
