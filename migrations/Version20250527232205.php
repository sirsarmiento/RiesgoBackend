<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527232205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE causa_consecuencia (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, type VARCHAR(20) NOT NULL, category VARCHAR(50) NOT NULL, description VARCHAR(1000) DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_BE49EBA7521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE riesgo_causa_consecuencia (riesgo_id INT NOT NULL, causa_consecuencia_id INT NOT NULL, INDEX IDX_7213846E7297086A (riesgo_id), INDEX IDX_7213846E8FC5D78 (causa_consecuencia_id), PRIMARY KEY(riesgo_id, causa_consecuencia_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE causa_consecuencia ADD CONSTRAINT FK_BE49EBA7521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE riesgo_causa_consecuencia ADD CONSTRAINT FK_7213846E7297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE riesgo_causa_consecuencia ADD CONSTRAINT FK_7213846E8FC5D78 FOREIGN KEY (causa_consecuencia_id) REFERENCES causa_consecuencia (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE riesgo_causa_consecuencia DROP FOREIGN KEY FK_7213846E8FC5D78');
        $this->addSql('DROP TABLE causa_consecuencia');
        $this->addSql('DROP TABLE riesgo_causa_consecuencia');
    }
}
