<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527215031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE riesgo (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, impacto INT NOT NULL, frecuencia INT NOT NULL, description VARCHAR(1000) DEFAULT NULL, affect TINYINT(1) NOT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_CEF448C4521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE riesgo_proceso (riesgo_id INT NOT NULL, proceso_id INT NOT NULL, INDEX IDX_B77ADAC27297086A (riesgo_id), INDEX IDX_B77ADAC2640D1D53 (proceso_id), PRIMARY KEY(riesgo_id, proceso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE riesgo ADD CONSTRAINT FK_CEF448C4521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE riesgo_proceso ADD CONSTRAINT FK_B77ADAC27297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE riesgo_proceso ADD CONSTRAINT FK_B77ADAC2640D1D53 FOREIGN KEY (proceso_id) REFERENCES proceso (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE riesgo_proceso DROP FOREIGN KEY FK_B77ADAC27297086A');
        $this->addSql('DROP TABLE riesgo');
        $this->addSql('DROP TABLE riesgo_proceso');
    }
}
