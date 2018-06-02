<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180602124056 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_block (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, position INT DEFAULT NULL, INDEX IDX_E59A68F4C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_block_image (id INT AUTO_INCREMENT NOT NULL, block_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_15909CCBE9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_block ADD CONSTRAINT FK_E59A68F4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_block_image ADD CONSTRAINT FK_15909CCBE9ED820C FOREIGN KEY (block_id) REFERENCES page_block (id)');
        $this->addSql('ALTER TABLE page CHANGE description description LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_block_image DROP FOREIGN KEY FK_15909CCBE9ED820C');
        $this->addSql('DROP TABLE page_block');
        $this->addSql('DROP TABLE page_block_image');
        $this->addSql('ALTER TABLE page CHANGE description description VARCHAR(1000) NOT NULL COLLATE utf8_unicode_ci');
    }
}
