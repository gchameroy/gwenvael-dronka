<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180603212620 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE page_block_action (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, route VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_block ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_block ADD CONSTRAINT FK_E59A68F49D32F035 FOREIGN KEY (action_id) REFERENCES page_block_action (id)');
        $this->addSql('CREATE INDEX IDX_E59A68F49D32F035 ON page_block (action_id)');

        $this->addSql('INSERT INTO page_block_action (id, label, route) VALUES (1, "Aucune action", NULL), (2, "Voir nos tarifs", "website_prices"), (3, "Prendre contact", "website_contact")');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page_block DROP FOREIGN KEY FK_E59A68F49D32F035');
        $this->addSql('DROP TABLE page_block_action');
        $this->addSql('DROP INDEX IDX_E59A68F49D32F035 ON page_block');
        $this->addSql('ALTER TABLE page_block DROP action_id');
    }
}
