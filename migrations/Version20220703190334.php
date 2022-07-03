<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220703190334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE worklogs (id INT AUTO_INCREMENT NOT NULL, github_login VARCHAR(150) DEFAULT NULL, repositorie_name VARCHAR(255) DEFAULT NULL, sha VARCHAR(255) DEFAULT NULL, committer_name VARCHAR(255) DEFAULT NULL, committer_email VARCHAR(100) DEFAULT NULL, message LONGTEXT DEFAULT NULL, url LONGTEXT DEFAULT NULL, html_url LONGTEXT DEFAULT NULL, comments_url LONGTEXT DEFAULT NULL, date_сcommit DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE worklogs');
    }
}
