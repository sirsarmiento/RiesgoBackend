<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250624125428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parametros_control (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, parama VARCHAR(10) NOT NULL, paramb VARCHAR(10) NOT NULL, paramc VARCHAR(100) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_45B9BA0D521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametros_control ADD CONSTRAINT FK_45B9BA0D521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parametros_control');
    }
}
