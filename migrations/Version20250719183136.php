<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250719183136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluacion (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, type VARCHAR(50) NOT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, INDEX IDX_DEEDCA53521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluacion_user (evaluacion_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_874B649E715F406 (evaluacion_id), INDEX IDX_874B649A76ED395 (user_id), PRIMARY KEY(evaluacion_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluacion_control (evaluacion_id INT NOT NULL, control_id INT NOT NULL, INDEX IDX_B64830B2E715F406 (evaluacion_id), INDEX IDX_B64830B232BEC70E (control_id), PRIMARY KEY(evaluacion_id, control_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluacion_riesgo (evaluacion_id INT NOT NULL, riesgo_id INT NOT NULL, INDEX IDX_8346AC7BE715F406 (evaluacion_id), INDEX IDX_8346AC7B7297086A (riesgo_id), PRIMARY KEY(evaluacion_id, riesgo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluacion ADD CONSTRAINT FK_DEEDCA53521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE evaluacion_user ADD CONSTRAINT FK_874B649E715F406 FOREIGN KEY (evaluacion_id) REFERENCES evaluacion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluacion_user ADD CONSTRAINT FK_874B649A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluacion_control ADD CONSTRAINT FK_B64830B2E715F406 FOREIGN KEY (evaluacion_id) REFERENCES evaluacion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluacion_control ADD CONSTRAINT FK_B64830B232BEC70E FOREIGN KEY (control_id) REFERENCES control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluacion_riesgo ADD CONSTRAINT FK_8346AC7BE715F406 FOREIGN KEY (evaluacion_id) REFERENCES evaluacion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluacion_riesgo ADD CONSTRAINT FK_8346AC7B7297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE estructura_organizativa');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluacion_user DROP FOREIGN KEY FK_874B649E715F406');
        $this->addSql('ALTER TABLE evaluacion_control DROP FOREIGN KEY FK_B64830B2E715F406');
        $this->addSql('ALTER TABLE evaluacion_riesgo DROP FOREIGN KEY FK_8346AC7BE715F406');
        $this->addSql('CREATE TABLE estructura_organizativa (id INT AUTO_INCREMENT NOT NULL, padre_id INT DEFAULT NULL, estructura_organizativa VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, jerarquia VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cod VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE evaluacion');
        $this->addSql('DROP TABLE evaluacion_user');
        $this->addSql('DROP TABLE evaluacion_control');
        $this->addSql('DROP TABLE evaluacion_riesgo');
    }
}
