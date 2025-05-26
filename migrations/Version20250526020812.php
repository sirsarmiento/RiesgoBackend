<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526020812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proceso (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, category INT NOT NULL, type INT NOT NULL, code VARCHAR(50) DEFAULT NULL, process INT DEFAULT NULL, unit INT DEFAULT NULL, description VARCHAR(1000) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_921C44D9166D1F9C (project_id), INDEX IDX_921C44D9521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proceso ADD CONSTRAINT FK_921C44D9166D1F9C FOREIGN KEY (project_id) REFERENCES proyecto (id)');
        $this->addSql('ALTER TABLE proceso ADD CONSTRAINT FK_921C44D9521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE proceso');
    }
}
