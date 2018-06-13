<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180613012211 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE price_image (id INT AUTO_INCREMENT NOT NULL, price_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_EEF40C3FD614C7E7 (price_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_image ADD CONSTRAINT FK_EEF40C3FD614C7E7 FOREIGN KEY (price_id) REFERENCES price (id)');
        $this->addSql('ALTER TABLE page_static CHANGE title_seo title_seo VARCHAR(255) DEFAULT NULL, CHANGE description_seo description_seo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE price ADD content LONGTEXT NOT NULL, DROP offer, CHANGE label label VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE price_image');
        $this->addSql('ALTER TABLE page_static CHANGE title_seo title_seo VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE description_seo description_seo VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE price ADD offer TINYINT(1) NOT NULL, DROP content, CHANGE label label VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE description description LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
