<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814231724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_niveau_devaluation (competence_id INT NOT NULL, niveau_devaluation_id INT NOT NULL, INDEX IDX_18D732F715761DAB (competence_id), INDEX IDX_18D732F7947D7A72 (niveau_devaluation_id), PRIMARY KEY(competence_id, niveau_devaluation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_groupe_de_competence (competence_id INT NOT NULL, groupe_de_competence_id INT NOT NULL, INDEX IDX_BC37A35C15761DAB (competence_id), INDEX IDX_BC37A35CD0A2E50 (groupe_de_competence_id), PRIMARY KEY(competence_id, groupe_de_competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_de_competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_devaluation (id INT AUTO_INCREMENT NOT NULL, actions VARCHAR(255) NOT NULL, criteres VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence_niveau_devaluation ADD CONSTRAINT FK_18D732F715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_niveau_devaluation ADD CONSTRAINT FK_18D732F7947D7A72 FOREIGN KEY (niveau_devaluation_id) REFERENCES niveau_devaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_groupe_de_competence ADD CONSTRAINT FK_BC37A35C15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_groupe_de_competence ADD CONSTRAINT FK_BC37A35CD0A2E50 FOREIGN KEY (groupe_de_competence_id) REFERENCES groupe_de_competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence_niveau_devaluation DROP FOREIGN KEY FK_18D732F715761DAB');
        $this->addSql('ALTER TABLE competence_groupe_de_competence DROP FOREIGN KEY FK_BC37A35C15761DAB');
        $this->addSql('ALTER TABLE competence_groupe_de_competence DROP FOREIGN KEY FK_BC37A35CD0A2E50');
        $this->addSql('ALTER TABLE competence_niveau_devaluation DROP FOREIGN KEY FK_18D732F7947D7A72');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_niveau_devaluation');
        $this->addSql('DROP TABLE competence_groupe_de_competence');
        $this->addSql('DROP TABLE groupe_de_competence');
        $this->addSql('DROP TABLE niveau_devaluation');
    }
}
