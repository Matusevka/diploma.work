<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620214840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vacations (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_start DATE DEFAULT NULL, day_count INT DEFAULT NULL, INDEX IDX_3B8290676BF700BD (status_id), INDEX IDX_3B829067A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vacations ADD CONSTRAINT FK_3B8290676BF700BD FOREIGN KEY (status_id) REFERENCES vacation_status (id)');
        $this->addSql('ALTER TABLE vacations ADD CONSTRAINT FK_3B829067A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vacations');
    }
}
