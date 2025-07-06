<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250705161738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, empresa_id INT DEFAULT NULL, name VARCHAR(1000) NOT NULL, where_ocurred VARCHAR(255) NOT NULL, description VARCHAR(2000) NOT NULL, start_date DATE NOT NULL, start_time VARCHAR(10) NOT NULL, discovery_date DATE NOT NULL, discovery_time VARCHAR(10) DEFAULT NULL, state VARCHAR(50) NOT NULL, criticalily VARCHAR(20) NOT NULL, generate_loss VARCHAR(10) NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, create_by VARCHAR(255) NOT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_47860B05521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_user (evento_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_95D710D387A5F842 (evento_id), INDEX IDX_95D710D3A76ED395 (user_id), PRIMARY KEY(evento_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_proceso (evento_id INT NOT NULL, proceso_id INT NOT NULL, INDEX IDX_8E898CA687A5F842 (evento_id), INDEX IDX_8E898CA6640D1D53 (proceso_id), PRIMARY KEY(evento_id, proceso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_control (evento_id INT NOT NULL, control_id INT NOT NULL, INDEX IDX_F14EE43487A5F842 (evento_id), INDEX IDX_F14EE43432BEC70E (control_id), PRIMARY KEY(evento_id, control_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_riesgo (evento_id INT NOT NULL, riesgo_id INT NOT NULL, INDEX IDX_375D559587A5F842 (evento_id), INDEX IDX_375D55957297086A (riesgo_id), PRIMARY KEY(evento_id, riesgo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento_causa_consecuencia (evento_id INT NOT NULL, causa_consecuencia_id INT NOT NULL, INDEX IDX_13ED20D287A5F842 (evento_id), INDEX IDX_13ED20D28FC5D78 (causa_consecuencia_id), PRIMARY KEY(evento_id, causa_consecuencia_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE evento_user ADD CONSTRAINT FK_95D710D387A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_user ADD CONSTRAINT FK_95D710D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_proceso ADD CONSTRAINT FK_8E898CA687A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_proceso ADD CONSTRAINT FK_8E898CA6640D1D53 FOREIGN KEY (proceso_id) REFERENCES proceso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_control ADD CONSTRAINT FK_F14EE43487A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_control ADD CONSTRAINT FK_F14EE43432BEC70E FOREIGN KEY (control_id) REFERENCES control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_riesgo ADD CONSTRAINT FK_375D559587A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_riesgo ADD CONSTRAINT FK_375D55957297086A FOREIGN KEY (riesgo_id) REFERENCES riesgo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_causa_consecuencia ADD CONSTRAINT FK_13ED20D287A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evento_causa_consecuencia ADD CONSTRAINT FK_13ED20D28FC5D78 FOREIGN KEY (causa_consecuencia_id) REFERENCES causa_consecuencia (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento_user DROP FOREIGN KEY FK_95D710D387A5F842');
        $this->addSql('ALTER TABLE evento_proceso DROP FOREIGN KEY FK_8E898CA687A5F842');
        $this->addSql('ALTER TABLE evento_control DROP FOREIGN KEY FK_F14EE43487A5F842');
        $this->addSql('ALTER TABLE evento_riesgo DROP FOREIGN KEY FK_375D559587A5F842');
        $this->addSql('ALTER TABLE evento_causa_consecuencia DROP FOREIGN KEY FK_13ED20D287A5F842');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE evento_user');
        $this->addSql('DROP TABLE evento_proceso');
        $this->addSql('DROP TABLE evento_control');
        $this->addSql('DROP TABLE evento_riesgo');
        $this->addSql('DROP TABLE evento_causa_consecuencia');
    }
}
