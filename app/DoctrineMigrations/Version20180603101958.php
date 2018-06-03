<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180603101958 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_social_network (id INT AUTO_INCREMENT NOT NULL, setting_id INT NOT NULL, social_network_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_891012C2EE35BD72 (setting_id), INDEX IDX_891012C2FA413953 (social_network_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EFFF52212B36786B (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setting_social_network ADD CONSTRAINT FK_891012C2EE35BD72 FOREIGN KEY (setting_id) REFERENCES setting (id)');
        $this->addSql('ALTER TABLE setting_social_network ADD CONSTRAINT FK_891012C2FA413953 FOREIGN KEY (social_network_id) REFERENCES social_network (id)');

        $this->addSql('INSERT INTO social_network(id, label, icon) VALUES(1, "Facebook", "fa fa-facebook-f"), (2, "Google Plus", "fa fa-google-plus"), (3, "Instagram", "fa fa-instagram"), (4, "Linkedin", "fa fa-linkedin"), (5, "Pinterest", "fa fa-pinterest-p"), (6, "Twitter", "fa fa-twitter"), (7, "Vimeo", "fa fa-vimeo"), (8, "Youtube", "fa fa-youtube")');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE setting_social_network DROP FOREIGN KEY FK_891012C2EE35BD72');
        $this->addSql('ALTER TABLE setting_social_network DROP FOREIGN KEY FK_891012C2FA413953');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE setting_social_network');
        $this->addSql('DROP TABLE social_network');
    }
}
