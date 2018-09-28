<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180921130530 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL('INSERT INTO page_disposition (id, label, icon) VALUES(3, "Texte uniquement", "fa-home")');
    }

    public function down(Schema $schema) : void
    {
        $this->addSQL('DELETE FROM page_disposition WHERE id = 3');
    }
}
