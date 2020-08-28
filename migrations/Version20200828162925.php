<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828162925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_brief DROP FOREIGN KEY FK_E84ECD91C5697D6D');
        $this->addSql('ALTER TABLE livrable_apprenant DROP FOREIGN KEY FK_B50C89F8C5697D6D');
        $this->addSql('ALTER TABLE brief_formateur DROP FOREIGN KEY FK_F4FCA08C155D8F51');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE livrable_apprenant');
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE brief ADD archived TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE brief_formateur DROP FOREIGN KEY FK_F4FCA08C155D8F51');
        $this->addSql('ALTER TABLE brief_formateur ADD CONSTRAINT FK_F4FCA08C155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable ADD description VARCHAR(255) DEFAULT NULL, DROP datecreation, DROP datelivraison');
        $this->addSql('ALTER TABLE apprenant_groupe ADD CONSTRAINT FK_1D224F8DC5697D6D FOREIGN KEY (apprenant_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_brief DROP FOREIGN KEY FK_E84ECD91C5697D6D');
        $this->addSql('ALTER TABLE apprenant_brief ADD CONSTRAINT FK_E84ECD91C5697D6D FOREIGN KEY (apprenant_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, profildesortie_id INT DEFAULT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, niveau VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_C4EB462EA76ED395 (user_id), INDEX IDX_C4EB462ECEB2FD19 (profildesortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cm (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_ED767E4FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livrable_apprenant (livrable_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_B50C89F8C5697D6D (apprenant_id), INDEX IDX_B50C89F8D0B0DE44 (livrable_id), PRIMARY KEY(livrable_id, apprenant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462ECEB2FD19 FOREIGN KEY (profildesortie_id) REFERENCES profil_de_sortie (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livrable_apprenant ADD CONSTRAINT FK_B50C89F8C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_apprenant ADD CONSTRAINT FK_B50C89F8D0B0DE44 FOREIGN KEY (livrable_id) REFERENCES livrable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_brief DROP FOREIGN KEY FK_E84ECD91C5697D6D');
        $this->addSql('ALTER TABLE apprenant_brief ADD CONSTRAINT FK_E84ECD91C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_groupe DROP FOREIGN KEY FK_1D224F8DC5697D6D');
        $this->addSql('ALTER TABLE brief DROP archived');
        $this->addSql('ALTER TABLE brief_formateur DROP FOREIGN KEY FK_F4FCA08C155D8F51');
        $this->addSql('ALTER TABLE brief_formateur ADD CONSTRAINT FK_F4FCA08C155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable ADD datecreation DATE DEFAULT NULL, ADD datelivraison DATE DEFAULT NULL, DROP description');
    }
}
