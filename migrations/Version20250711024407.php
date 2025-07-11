<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250711024407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, create_at DATETIME NOT NULL, create_by VARCHAR(255) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_DD5A5B7D521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_user (plan_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_98451ABBE899029B (plan_id), INDEX IDX_98451ABBA76ED395 (user_id), PRIMARY KEY(plan_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_proceso (plan_id INT NOT NULL, proceso_id INT NOT NULL, INDEX IDX_2CA30CD1E899029B (plan_id), INDEX IDX_2CA30CD1640D1D53 (proceso_id), PRIMARY KEY(plan_id, proceso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_control (plan_id INT NOT NULL, control_id INT NOT NULL, INDEX IDX_53646443E899029B (plan_id), INDEX IDX_5364644332BEC70E (control_id), PRIMARY KEY(plan_id, control_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_riesgo (plan_id INT NOT NULL, riesgo_id INT NOT NULL, INDEX IDX_7AAC50B6E899029B (plan_id), INDEX IDX_7AAC50B67297086A (riesgo_id), PRIMARY KEY(plan_id, riesgo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_evento (plan_id INT NOT NULL, evento_id INT NOT NULL, INDEX IDX_F3DE1377E899029B (plan_id), INDEX IDX_F3DE137787A5F842 (evento_id), PRIMARY KEY(plan_id, evento_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE plan_user ADD CONSTRAINT FK_98451ABBE899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_user ADD CONSTRAINT FK_98451ABBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_proceso ADD CONSTRAINT FK_2CA30CD1E899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_proceso ADD CONSTRAINT FK_2CA30CD1640D1D53 FOREIGN KEY (proceso_id) REFERENCES proceso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_control ADD CONSTRAINT FK_53646443E899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_control ADD CONSTRAINT FK_5364644332BEC70E FOREIGN KEY (control_id) REFERENCES control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_riesgo ADD CONSTRAINT FK_7AAC50B6E899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_riesgo ADD CONSTRAINT FK_7AAC50B67297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_evento ADD CONSTRAINT FK_F3DE1377E899029B FOREIGN KEY (plan_id) REFERENCES plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_evento ADD CONSTRAINT FK_F3DE137787A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_user DROP FOREIGN KEY FK_98451ABBE899029B');
        $this->addSql('ALTER TABLE plan_proceso DROP FOREIGN KEY FK_2CA30CD1E899029B');
        $this->addSql('ALTER TABLE plan_control DROP FOREIGN KEY FK_53646443E899029B');
        $this->addSql('ALTER TABLE plan_riesgo DROP FOREIGN KEY FK_7AAC50B6E899029B');
        $this->addSql('ALTER TABLE plan_evento DROP FOREIGN KEY FK_F3DE1377E899029B');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE plan_user');
        $this->addSql('DROP TABLE plan_proceso');
        $this->addSql('DROP TABLE plan_control');
        $this->addSql('DROP TABLE plan_riesgo');
        $this->addSql('DROP TABLE plan_evento');
    }
}
