<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820190310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cm (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur_groupe (formateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_2C668E09155D8F51 (formateur_id), INDEX IDX_2C668E097A45358C (groupe_id), PRIMARY KEY(formateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_de_creation VARCHAR(255) NOT NULL, date_de_livraison VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_dun_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_id INT DEFAULT NULL, github VARCHAR(255) NOT NULL, trello VARCHAR(255) NOT NULL, figma VARCHAR(255) NOT NULL, deploiement VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, INDEX IDX_BA79216CC5697D6D (apprenant_id), INDEX IDX_BA79216CD0B0DE44 (livrable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, github VARCHAR(255) NOT NULL, trello VARCHAR(255) NOT NULL, figma VARCHAR(255) NOT NULL, deploiement VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, date_de_creation DATE NOT NULL, date_de_livraison DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_apprenant (livrable_partiel_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_5B1B4613519178C4 (livrable_partiel_id), INDEX IDX_5B1B4613C5697D6D (apprenant_id), PRIMARY KEY(livrable_partiel_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_formateur (livrable_partiel_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_72867E72519178C4 (livrable_partiel_id), INDEX IDX_72867E72155D8F51 (formateur_id), PRIMARY KEY(livrable_partiel_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_groupe (livrable_partiel_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_8DE701519178C4 (livrable_partiel_id), INDEX IDX_8DE7017A45358C (groupe_id), PRIMARY KEY(livrable_partiel_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_livrable (livrable_partiel_id INT NOT NULL, livrable_id INT NOT NULL, INDEX IDX_D19C98CA519178C4 (livrable_partiel_id), INDEX IDX_D19C98CAD0B0DE44 (livrable_id), PRIMARY KEY(livrable_partiel_id, livrable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formateur_groupe ADD CONSTRAINT FK_2C668E09155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur_groupe ADD CONSTRAINT FK_2C668E097A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_dun_apprenant ADD CONSTRAINT FK_BA79216CC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrable_dun_apprenant ADD CONSTRAINT FK_BA79216CD0B0DE44 FOREIGN KEY (livrable_id) REFERENCES livrable (id)');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant ADD CONSTRAINT FK_5B1B4613519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant ADD CONSTRAINT FK_5B1B4613C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_formateur ADD CONSTRAINT FK_72867E72519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_formateur ADD CONSTRAINT FK_72867E72155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_groupe ADD CONSTRAINT FK_8DE701519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_groupe ADD CONSTRAINT FK_8DE7017A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_livrable ADD CONSTRAINT FK_D19C98CA519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_livrable ADD CONSTRAINT FK_D19C98CAD0B0DE44 FOREIGN KEY (livrable_id) REFERENCES livrable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462ED0C07AFF');
        $this->addSql('DROP INDEX IDX_C4EB462ED0C07AFF ON apprenant');
        $this->addSql('ALTER TABLE apprenant DROP promo_id');
        $this->addSql('ALTER TABLE groupe ADD archived TINYINT(1) NOT NULL, ADD date_creation DATE DEFAULT NULL, DROP projet, CHANGE libelle libelle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD archived TINYINT(1) NOT NULL, DROP reference_agate, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE date_debut date_debut DATE DEFAULT NULL, CHANGE date_fin date_fin DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE archived archived TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formateur_groupe DROP FOREIGN KEY FK_2C668E09155D8F51');
        $this->addSql('ALTER TABLE livrable_partiel_formateur DROP FOREIGN KEY FK_72867E72155D8F51');
        $this->addSql('ALTER TABLE livrable_dun_apprenant DROP FOREIGN KEY FK_BA79216CD0B0DE44');
        $this->addSql('ALTER TABLE livrable_partiel_livrable DROP FOREIGN KEY FK_D19C98CAD0B0DE44');
        $this->addSql('ALTER TABLE livrable_partiel_apprenant DROP FOREIGN KEY FK_5B1B4613519178C4');
        $this->addSql('ALTER TABLE livrable_partiel_formateur DROP FOREIGN KEY FK_72867E72519178C4');
        $this->addSql('ALTER TABLE livrable_partiel_groupe DROP FOREIGN KEY FK_8DE701519178C4');
        $this->addSql('ALTER TABLE livrable_partiel_livrable DROP FOREIGN KEY FK_D19C98CA519178C4');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formateur_groupe');
        $this->addSql('DROP TABLE livrable');
        $this->addSql('DROP TABLE livrable_dun_apprenant');
        $this->addSql('DROP TABLE livrable_partiel');
        $this->addSql('DROP TABLE livrable_partiel_apprenant');
        $this->addSql('DROP TABLE livrable_partiel_formateur');
        $this->addSql('DROP TABLE livrable_partiel_groupe');
        $this->addSql('DROP TABLE livrable_partiel_livrable');
        $this->addSql('ALTER TABLE apprenant ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_C4EB462ED0C07AFF ON apprenant (promo_id)');
        $this->addSql('ALTER TABLE groupe ADD projet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP archived, DROP date_creation, CHANGE libelle libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE promo ADD reference_agate VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP archived, CHANGE lieu lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_debut date_debut DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE archived archived TINYINT(1) DEFAULT NULL');
    }
}
