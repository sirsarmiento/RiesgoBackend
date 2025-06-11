<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611023927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frecuencia CHANGE porcentaje porcentaje INT NOT NULL');
        $this->addSql('ALTER TABLE impacto CHANGE porcentaje porcentaje INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frecuencia CHANGE porcentaje porcentaje DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE impacto CHANGE porcentaje porcentaje DOUBLE PRECISION NOT NULL');
    }
}
