<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512000421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, id_status_id INT DEFAULT NULL, nivel_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) NOT NULL, INDEX IDX_3BEE5771EBC2BC9A (id_status_id), INDEX IDX_3BEE5771DA3426AE (nivel_id), INDEX IDX_3BEE57719FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ciudad (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, estado_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) NOT NULL, INDEX IDX_8E86059E6BF700BD (status_id), INDEX IDX_8E86059E9F5A440B (estado_id), INDEX IDX_8E86059E9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coordinacion (id INT AUTO_INCREMENT NOT NULL, id_status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME NOT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_E355AA12EBC2BC9A (id_status_id), INDEX IDX_E355AA129FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correo_subject (id INT AUTO_INCREMENT NOT NULL, nombre_subject VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta_email (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tipo_cuenta_id INT NOT NULL, status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_D1B0FA54A76ED395 (user_id), INDEX IDX_D1B0FA5478814E56 (tipo_cuenta_id), INDEX IDX_D1B0FA546BF700BD (status_id), INDEX IDX_D1B0FA549FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dependencia (id INT AUTO_INCREMENT NOT NULL, id_status_id INT NOT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(200) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(50) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, INDEX IDX_D23000C8EBC2BC9A (id_status_id), INDEX IDX_D23000C89FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, url_logo VARCHAR(1000) NOT NULL, INDEX IDX_B8D75A506BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, pais_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_265DE1E36BF700BD (status_id), INDEX IDX_265DE1E3C604D5C6 (pais_id), INDEX IDX_265DE1E39FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frecuencia (id INT AUTO_INCREMENT NOT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(100) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) NOT NULL, INDEX IDX_D6AC1F939FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gerencia (id INT AUTO_INCREMENT NOT NULL, id_status_id INT NOT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_6E583517EBC2BC9A (id_status_id), INDEX IDX_6E5835179FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impacto (id INT AUTO_INCREMENT NOT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(100) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) NOT NULL, INDEX IDX_91AF0F279FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, padre_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, icono VARCHAR(255) DEFAULT NULL, create_at DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, orden SMALLINT DEFAULT NULL, tipo_componente VARCHAR(255) DEFAULT NULL, INDEX IDX_ECF1CF366BF700BD (status_id), INDEX IDX_ECF1CF36613CEC58 (padre_id), INDEX IDX_ECF1CF369FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo_rol (id INT AUTO_INCREMENT NOT NULL, rol_id INT DEFAULT NULL, modulo_id INT DEFAULT NULL, status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, autorizacion VARCHAR(2000) NOT NULL, INDEX IDX_A8962E624BAB96C (rol_id), INDEX IDX_A8962E62C07F55F5 (modulo_id), INDEX IDX_A8962E626BF700BD (status_id), INDEX IDX_A8962E629FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nivel (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_AAFC20CB6BF700BD (status_id), INDEX IDX_AAFC20CB9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_7E5D2EFF6BF700BD (status_id), INDEX IDX_7E5D2EFF9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametros (id INT AUTO_INCREMENT NOT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(100) NOT NULL, value VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_E09691179FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redes (id INT AUTO_INCREMENT NOT NULL, tiporedes_id_id INT NOT NULL, id_user_id_id INT NOT NULL, idempresa_id INT DEFAULT NULL, red VARCHAR(150) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, INDEX IDX_D7909F1B8700013 (tiporedes_id_id), INDEX IDX_D7909F1B380CE5D8 (id_user_id_id), INDEX IDX_D7909F1B9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rol (id INT AUTO_INCREMENT NOT NULL, id_status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_E553F37EBC2BC9A (id_status_id), INDEX IDX_E553F379FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, idempresa_id INT DEFAULT NULL, descripcion VARCHAR(50) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(50) DEFAULT NULL, update_at DATETIME NOT NULL, update_by VARCHAR(50) DEFAULT NULL, INDEX IDX_7B00651C9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telefono (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, numero VARCHAR(50) NOT NULL, creat_at DATETIME NOT NULL, create_by VARCHAR(50) NOT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, INDEX IDX_C1E70A7F79F37AE5 (id_user_id), INDEX IDX_C1E70A7FEBC2BC9A (id_status_id), INDEX IDX_C1E70A7F9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_cuenta_email (id INT AUTO_INCREMENT NOT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, smtp VARCHAR(255) DEFAULT NULL, imap VARCHAR(255) DEFAULT NULL, pop3 VARCHAR(255) DEFAULT NULL, INDEX IDX_62E3A4549FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tiporedes (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT NULL, create_by VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, update_by VARCHAR(255) DEFAULT NULL, icono VARCHAR(255) DEFAULT NULL, INDEX IDX_809A38456BF700BD (status_id), INDEX IDX_809A38459FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, codigo VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, swusado INT NOT NULL, INDEX IDX_5F37A13B79F37AE5 (id_user_id), INDEX IDX_5F37A13B9FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_status_id INT DEFAULT NULL, id_dependencia_id INT DEFAULT NULL, id_cargo_id INT DEFAULT NULL, pais_id INT DEFAULT NULL, estado_id INT DEFAULT NULL, ciudad_id INT DEFAULT NULL, id_gerencia_id INT DEFAULT NULL, id_coordinacion_id INT DEFAULT NULL, idempresa_id INT DEFAULT NULL, username VARCHAR(80) NOT NULL, password VARCHAR(200) NOT NULL, tipo_documento_identidad VARCHAR(1) NOT NULL, primer_nombre VARCHAR(50) NOT NULL, segundo_nombre VARCHAR(50) DEFAULT NULL, primer_apellido VARCHAR(50) NOT NULL, segundo_apellido VARCHAR(50) DEFAULT NULL, fecha_nacimiento DATETIME DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT NULL, update_by VARCHAR(50) DEFAULT NULL, update_at DATETIME DEFAULT NULL, create_by VARCHAR(50) DEFAULT NULL, roles VARCHAR(2000) NOT NULL, foto VARCHAR(255) DEFAULT NULL, numero_documento VARCHAR(255) DEFAULT NULL, sexo VARCHAR(20) DEFAULT NULL, direccion VARCHAR(2000) DEFAULT NULL, INDEX IDX_8D93D649EBC2BC9A (id_status_id), INDEX IDX_8D93D649E2428FB0 (id_dependencia_id), INDEX IDX_8D93D649D1E12F15 (id_cargo_id), INDEX IDX_8D93D649C604D5C6 (pais_id), INDEX IDX_8D93D6499F5A440B (estado_id), INDEX IDX_8D93D649E8608214 (ciudad_id), INDEX IDX_8D93D649A0BBA62C (id_gerencia_id), INDEX IDX_8D93D649DF54805D (id_coordinacion_id), INDEX IDX_8D93D6499FB704AB (idempresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771DA3426AE FOREIGN KEY (nivel_id) REFERENCES nivel (id)');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE57719FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE ciudad ADD CONSTRAINT FK_8E86059E6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ciudad ADD CONSTRAINT FK_8E86059E9F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE ciudad ADD CONSTRAINT FK_8E86059E9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE coordinacion ADD CONSTRAINT FK_E355AA12EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE coordinacion ADD CONSTRAINT FK_E355AA129FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE cuenta_email ADD CONSTRAINT FK_D1B0FA54A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cuenta_email ADD CONSTRAINT FK_D1B0FA5478814E56 FOREIGN KEY (tipo_cuenta_id) REFERENCES tipo_cuenta_email (id)');
        $this->addSql('ALTER TABLE cuenta_email ADD CONSTRAINT FK_D1B0FA546BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE cuenta_email ADD CONSTRAINT FK_D1B0FA549FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE dependencia ADD CONSTRAINT FK_D23000C8EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE dependencia ADD CONSTRAINT FK_D23000C89FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A506BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE estado ADD CONSTRAINT FK_265DE1E36BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE estado ADD CONSTRAINT FK_265DE1E3C604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE estado ADD CONSTRAINT FK_265DE1E39FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE frecuencia ADD CONSTRAINT FK_D6AC1F939FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE gerencia ADD CONSTRAINT FK_6E583517EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE gerencia ADD CONSTRAINT FK_6E5835179FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE impacto ADD CONSTRAINT FK_91AF0F279FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE modulo ADD CONSTRAINT FK_ECF1CF366BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE modulo ADD CONSTRAINT FK_ECF1CF36613CEC58 FOREIGN KEY (padre_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE modulo ADD CONSTRAINT FK_ECF1CF369FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE modulo_rol ADD CONSTRAINT FK_A8962E624BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)');
        $this->addSql('ALTER TABLE modulo_rol ADD CONSTRAINT FK_A8962E62C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE modulo_rol ADD CONSTRAINT FK_A8962E626BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE modulo_rol ADD CONSTRAINT FK_A8962E629FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE nivel ADD CONSTRAINT FK_AAFC20CB6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE nivel ADD CONSTRAINT FK_AAFC20CB9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE pais ADD CONSTRAINT FK_7E5D2EFF6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE pais ADD CONSTRAINT FK_7E5D2EFF9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE parametros ADD CONSTRAINT FK_E09691179FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE redes ADD CONSTRAINT FK_D7909F1B8700013 FOREIGN KEY (tiporedes_id_id) REFERENCES tiporedes (id)');
        $this->addSql('ALTER TABLE redes ADD CONSTRAINT FK_D7909F1B380CE5D8 FOREIGN KEY (id_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE redes ADD CONSTRAINT FK_D7909F1B9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE rol ADD CONSTRAINT FK_E553F37EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE rol ADD CONSTRAINT FK_E553F379FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7FEBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE tipo_cuenta_email ADD CONSTRAINT FK_62E3A4549FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE tiporedes ADD CONSTRAINT FK_809A38456BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE tiporedes ADD CONSTRAINT FK_809A38459FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B9FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E2428FB0 FOREIGN KEY (id_dependencia_id) REFERENCES dependencia (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E8608214 FOREIGN KEY (ciudad_id) REFERENCES ciudad (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A0BBA62C FOREIGN KEY (id_gerencia_id) REFERENCES gerencia (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DF54805D FOREIGN KEY (id_coordinacion_id) REFERENCES coordinacion (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499FB704AB FOREIGN KEY (idempresa_id) REFERENCES empresa (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D1E12F15');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E8608214');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DF54805D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E2428FB0');
        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE57719FB704AB');
        $this->addSql('ALTER TABLE ciudad DROP FOREIGN KEY FK_8E86059E9FB704AB');
        $this->addSql('ALTER TABLE coordinacion DROP FOREIGN KEY FK_E355AA129FB704AB');
        $this->addSql('ALTER TABLE cuenta_email DROP FOREIGN KEY FK_D1B0FA549FB704AB');
        $this->addSql('ALTER TABLE dependencia DROP FOREIGN KEY FK_D23000C89FB704AB');
        $this->addSql('ALTER TABLE estado DROP FOREIGN KEY FK_265DE1E39FB704AB');
        $this->addSql('ALTER TABLE frecuencia DROP FOREIGN KEY FK_D6AC1F939FB704AB');
        $this->addSql('ALTER TABLE gerencia DROP FOREIGN KEY FK_6E5835179FB704AB');
        $this->addSql('ALTER TABLE impacto DROP FOREIGN KEY FK_91AF0F279FB704AB');
        $this->addSql('ALTER TABLE modulo DROP FOREIGN KEY FK_ECF1CF369FB704AB');
        $this->addSql('ALTER TABLE modulo_rol DROP FOREIGN KEY FK_A8962E629FB704AB');
        $this->addSql('ALTER TABLE nivel DROP FOREIGN KEY FK_AAFC20CB9FB704AB');
        $this->addSql('ALTER TABLE pais DROP FOREIGN KEY FK_7E5D2EFF9FB704AB');
        $this->addSql('ALTER TABLE parametros DROP FOREIGN KEY FK_E09691179FB704AB');
        $this->addSql('ALTER TABLE redes DROP FOREIGN KEY FK_D7909F1B9FB704AB');
        $this->addSql('ALTER TABLE rol DROP FOREIGN KEY FK_E553F379FB704AB');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C9FB704AB');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F9FB704AB');
        $this->addSql('ALTER TABLE tipo_cuenta_email DROP FOREIGN KEY FK_62E3A4549FB704AB');
        $this->addSql('ALTER TABLE tiporedes DROP FOREIGN KEY FK_809A38459FB704AB');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B9FB704AB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499FB704AB');
        $this->addSql('ALTER TABLE ciudad DROP FOREIGN KEY FK_8E86059E9F5A440B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499F5A440B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A0BBA62C');
        $this->addSql('ALTER TABLE modulo DROP FOREIGN KEY FK_ECF1CF36613CEC58');
        $this->addSql('ALTER TABLE modulo_rol DROP FOREIGN KEY FK_A8962E62C07F55F5');
        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE5771DA3426AE');
        $this->addSql('ALTER TABLE estado DROP FOREIGN KEY FK_265DE1E3C604D5C6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C604D5C6');
        $this->addSql('ALTER TABLE modulo_rol DROP FOREIGN KEY FK_A8962E624BAB96C');
        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE5771EBC2BC9A');
        $this->addSql('ALTER TABLE ciudad DROP FOREIGN KEY FK_8E86059E6BF700BD');
        $this->addSql('ALTER TABLE coordinacion DROP FOREIGN KEY FK_E355AA12EBC2BC9A');
        $this->addSql('ALTER TABLE cuenta_email DROP FOREIGN KEY FK_D1B0FA546BF700BD');
        $this->addSql('ALTER TABLE dependencia DROP FOREIGN KEY FK_D23000C8EBC2BC9A');
        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY FK_B8D75A506BF700BD');
        $this->addSql('ALTER TABLE estado DROP FOREIGN KEY FK_265DE1E36BF700BD');
        $this->addSql('ALTER TABLE gerencia DROP FOREIGN KEY FK_6E583517EBC2BC9A');
        $this->addSql('ALTER TABLE modulo DROP FOREIGN KEY FK_ECF1CF366BF700BD');
        $this->addSql('ALTER TABLE modulo_rol DROP FOREIGN KEY FK_A8962E626BF700BD');
        $this->addSql('ALTER TABLE nivel DROP FOREIGN KEY FK_AAFC20CB6BF700BD');
        $this->addSql('ALTER TABLE pais DROP FOREIGN KEY FK_7E5D2EFF6BF700BD');
        $this->addSql('ALTER TABLE rol DROP FOREIGN KEY FK_E553F37EBC2BC9A');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7FEBC2BC9A');
        $this->addSql('ALTER TABLE tiporedes DROP FOREIGN KEY FK_809A38456BF700BD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EBC2BC9A');
        $this->addSql('ALTER TABLE cuenta_email DROP FOREIGN KEY FK_D1B0FA5478814E56');
        $this->addSql('ALTER TABLE redes DROP FOREIGN KEY FK_D7909F1B8700013');
        $this->addSql('ALTER TABLE cuenta_email DROP FOREIGN KEY FK_D1B0FA54A76ED395');
        $this->addSql('ALTER TABLE redes DROP FOREIGN KEY FK_D7909F1B380CE5D8');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F79F37AE5');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B79F37AE5');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE ciudad');
        $this->addSql('DROP TABLE coordinacion');
        $this->addSql('DROP TABLE correo_subject');
        $this->addSql('DROP TABLE cuenta_email');
        $this->addSql('DROP TABLE dependencia');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE estado');
        $this->addSql('DROP TABLE frecuencia');
        $this->addSql('DROP TABLE gerencia');
        $this->addSql('DROP TABLE impacto');
        $this->addSql('DROP TABLE modulo');
        $this->addSql('DROP TABLE modulo_rol');
        $this->addSql('DROP TABLE nivel');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE parametros');
        $this->addSql('DROP TABLE redes');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE telefono');
        $this->addSql('DROP TABLE tipo_cuenta_email');
        $this->addSql('DROP TABLE tiporedes');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
    }
}
