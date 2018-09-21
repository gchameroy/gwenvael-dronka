<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180921093729 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE page_disposition (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page ADD disposition_id INT DEFAULT NULL');

        $this->addSQL('INSERT INTO page_disposition (id, label, icon) VALUES(1, "Texte + image", "fa-home"),(2, "3 colonnes de texte", "fa-home") ');
        $this->addSQL('UPDATE page SET disposition_id = 1');

        $this->addSql('ALTER TABLE page CHANGE disposition_id disposition_id INT NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620287B65ED FOREIGN KEY (disposition_id) REFERENCES page_disposition (id)');
        $this->addSql('CREATE INDEX IDX_140AB620287B65ED ON page (disposition_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620287B65ED');
        $this->addSql('DROP TABLE page_disposition');
        $this->addSql('DROP INDEX IDX_140AB620287B65ED ON page');
        $this->addSql('ALTER TABLE page DROP disposition_id');
    }
}
