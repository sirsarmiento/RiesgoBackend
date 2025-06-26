<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626023530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE control ADD solidity_design VARCHAR(20) DEFAULT NULL, ADD percentage_design VARCHAR(10) DEFAULT NULL, ADD solidity_execution VARCHAR(20) DEFAULT NULL, ADD percentage_execution VARCHAR(10) DEFAULT NULL, ADD solidity_result VARCHAR(20) DEFAULT NULL, ADD percentage_result VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE control DROP solidity_design, DROP percentage_design, DROP solidity_execution, DROP percentage_execution, DROP solidity_result, DROP percentage_result');
    }
}
