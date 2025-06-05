<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605022319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE control (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, qualify VARCHAR(255) NOT NULL, execution_type VARCHAR(255) NOT NULL, is_frequent INT NOT NULL, is_document VARCHAR(255) NOT NULL, has_evidence INT NOT NULL, responsible_assigned INT NOT NULL, events_associated INT NOT NULL, is_effective INT NOT NULL, correct_time INT NOT NULL, created_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_EDDB2C4B521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE control_user (control_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7F7D88FC32BEC70E (control_id), INDEX IDX_7F7D88FCA76ED395 (user_id), PRIMARY KEY(control_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE riesgo_control (riesgo_id INT NOT NULL, control_id INT NOT NULL, INDEX IDX_C8BDB2507297086A (riesgo_id), INDEX IDX_C8BDB25032BEC70E (control_id), PRIMARY KEY(riesgo_id, control_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE control ADD CONSTRAINT FK_EDDB2C4B521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE control_user ADD CONSTRAINT FK_7F7D88FC32BEC70E FOREIGN KEY (control_id) REFERENCES control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE control_user ADD CONSTRAINT FK_7F7D88FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE riesgo_control ADD CONSTRAINT FK_C8BDB2507297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE riesgo_control ADD CONSTRAINT FK_C8BDB25032BEC70E FOREIGN KEY (control_id) REFERENCES control (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE control_user DROP FOREIGN KEY FK_7F7D88FC32BEC70E');
        $this->addSql('ALTER TABLE riesgo_control DROP FOREIGN KEY FK_C8BDB25032BEC70E');
        $this->addSql('DROP TABLE control');
        $this->addSql('DROP TABLE control_user');
        $this->addSql('DROP TABLE riesgo_control');
    }
}
