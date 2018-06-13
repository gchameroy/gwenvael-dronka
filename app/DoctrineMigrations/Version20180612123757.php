<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180612123757 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE page_static (id INT AUTO_INCREMENT NOT NULL, title_seo VARCHAR(255) NOT NULL, description_seo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');

        $this->addSql('INSERT INTO page_static (id, title_seo, description_seo) VALUES (1, "Accueil", ""), (2, "Tarifs", ""), (3, "Contact", "")');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE page_static');
    }
}
