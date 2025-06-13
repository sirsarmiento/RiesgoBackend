<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611203105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE riesgo ADD impact_id INT NOT NULL, ADD frequency_id INT NOT NULL, DROP impacto, DROP frecuencia');
        $this->addSql('ALTER TABLE riesgo ADD CONSTRAINT FK_CEF448C4D128BC9B FOREIGN KEY (impact_id) REFERENCES impacto (id)');
        $this->addSql('ALTER TABLE riesgo ADD CONSTRAINT FK_CEF448C494879022 FOREIGN KEY (frequency_id) REFERENCES frecuencia (id)');
        $this->addSql('CREATE INDEX IDX_CEF448C4D128BC9B ON riesgo (impact_id)');
        $this->addSql('CREATE INDEX IDX_CEF448C494879022 ON riesgo (frequency_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE riesgo DROP FOREIGN KEY FK_CEF448C4D128BC9B');
        $this->addSql('ALTER TABLE riesgo DROP FOREIGN KEY FK_CEF448C494879022');
        $this->addSql('DROP INDEX IDX_CEF448C4D128BC9B ON riesgo');
        $this->addSql('DROP INDEX IDX_CEF448C494879022 ON riesgo');
        $this->addSql('ALTER TABLE riesgo ADD impacto INT NOT NULL, ADD frecuencia INT NOT NULL, DROP impact_id, DROP frequency_id');
    }
}
