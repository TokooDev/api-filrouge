<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822173849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief DROP FOREIGN KEY FK_1FBB1007165AD846');
        $this->addSql('DROP INDEX IDX_1FBB1007165AD846 ON brief');
        $this->addSql('ALTER TABLE brief DROP brief_dune_promo_id');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C5165AD846');
        $this->addSql('DROP INDEX IDX_37F072C5165AD846 ON livrable_partiel');
        $this->addSql('ALTER TABLE livrable_partiel DROP brief_dune_promo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief ADD brief_dune_promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007165AD846 FOREIGN KEY (brief_dune_promo_id) REFERENCES brief_dune_promo (id)');
        $this->addSql('CREATE INDEX IDX_1FBB1007165AD846 ON brief (brief_dune_promo_id)');
        $this->addSql('ALTER TABLE livrable_partiel ADD brief_dune_promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C5165AD846 FOREIGN KEY (brief_dune_promo_id) REFERENCES brief_dune_promo (id)');
        $this->addSql('CREATE INDEX IDX_37F072C5165AD846 ON livrable_partiel (brief_dune_promo_id)');
    }
}
