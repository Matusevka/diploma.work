<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628175222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_tracking ADD uid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD tickspot_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649507CB2A90 FOREIGN KEY (tickspot_id) REFERENCES tickspot (id)');
        //$this->addSql('CREATE INDEX IDX_8D93D649507CB2A90 ON user (tickspot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_tracking DROP uid');
        //$this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649507CB2A90');
        //$this->addSql('DROP INDEX IDX_8D93D649507CB2A90 ON user');
        $this->addSql('ALTER TABLE user DROP tickspot_id');
    }
}