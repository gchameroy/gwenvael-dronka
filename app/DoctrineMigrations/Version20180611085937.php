<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180611085937 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE counter (id INT AUTO_INCREMENT NOT NULL, label TINYTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_counter (id INT AUTO_INCREMENT NOT NULL, setting_id INT NOT NULL, counter_id INT NOT NULL, value INT NOT NULL, INDEX IDX_99702490EE35BD72 (setting_id), INDEX IDX_99702490FCEEF2E3 (counter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setting_counter ADD CONSTRAINT FK_99702490EE35BD72 FOREIGN KEY (setting_id) REFERENCES setting (id)');
        $this->addSql('ALTER TABLE setting_counter ADD CONSTRAINT FK_99702490FCEEF2E3 FOREIGN KEY (counter_id) REFERENCES counter (id)');

        $this->addSql('INSERT INTO setting (id) VALUES (1)');
        $this->addSql('INSERT INTO counter (id, label) VALUES (1, "Maîtres"), (2, "Chiens"), (3, "Cours"), (4, "Friandises")');
        $this->addSql('INSERT INTO setting_counter (id, setting_id, counter_id, value) VALUES (1, 1, 1, 250), (2, 1, 2, 370), (3, 1, 3, 1200), (4, 1, 4, 35000)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE setting_counter DROP FOREIGN KEY FK_99702490FCEEF2E3');
        $this->addSql('DROP TABLE counter');
        $this->addSql('DROP TABLE setting_counter');
    }
}
