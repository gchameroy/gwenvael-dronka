<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180607220242 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE social_network RENAME INDEX uniq_efff52212b36786b TO UNIQ_EFFF5221EA750E8');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE page DROP image');
        $this->addSql('ALTER TABLE social_network RENAME INDEX uniq_efff5221ea750e8 TO UNIQ_EFFF52212B36786B');
    }
}
