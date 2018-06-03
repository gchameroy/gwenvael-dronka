<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180603164551 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page ADD deletable TINYINT(1) NOT NULL, DROP description');
        $this->addSql('ALTER TABLE page_block ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E59A68F4989D9B62 ON page_block (slug)');

        $this->addSql('INSERT INTO page(title, slug, deletable) VALUES ("Nos cours", "nos-cours", false)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page ADD description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, DROP deletable');
        $this->addSql('DROP INDEX UNIQ_E59A68F4989D9B62 ON page_block');
        $this->addSql('ALTER TABLE page_block DROP slug');
    }
}
