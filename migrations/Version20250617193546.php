<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617193546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE impacto_frecuencia (id INT AUTO_INCREMENT NOT NULL, impacto_id INT NOT NULL, frecuencia_id INT NOT NULL, color VARCHAR(100) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_337CD7609AB23772 (impacto_id), INDEX IDX_337CD7608B2E2212 (frecuencia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impacto_frecuencia ADD CONSTRAINT FK_337CD7609AB23772 FOREIGN KEY (impacto_id) REFERENCES impacto (id)');
        $this->addSql('ALTER TABLE impacto_frecuencia ADD CONSTRAINT FK_337CD7608B2E2212 FOREIGN KEY (frecuencia_id) REFERENCES frecuencia (id)');
        $this->addSql('ALTER TABLE riesgo ADD CONSTRAINT FK_CEF448C4D128BC9B FOREIGN KEY (impact_id) REFERENCES impacto (id)');
        $this->addSql('ALTER TABLE riesgo ADD CONSTRAINT FK_CEF448C494879022 FOREIGN KEY (frequency_id) REFERENCES frecuencia (id)');
        $this->addSql('CREATE INDEX IDX_CEF448C4D128BC9B ON riesgo (impact_id)');
        $this->addSql('CREATE INDEX IDX_CEF448C494879022 ON riesgo (frequency_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE impacto_frecuencia');
        $this->addSql('ALTER TABLE riesgo DROP FOREIGN KEY FK_CEF448C4D128BC9B');
        $this->addSql('ALTER TABLE riesgo DROP FOREIGN KEY FK_CEF448C494879022');
        $this->addSql('DROP INDEX IDX_CEF448C4D128BC9B ON riesgo');
        $this->addSql('DROP INDEX IDX_CEF448C494879022 ON riesgo');
    }
}
