<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180607233635 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE price CHANGE title title VARCHAR(50) NOT NULL, CHANGE label label VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE price CHANGE title title VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, CHANGE label label VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci');
    }
}
