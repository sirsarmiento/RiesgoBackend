<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526022838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proceso_user (proceso_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_166EC69C640D1D53 (proceso_id), INDEX IDX_166EC69CA76ED395 (user_id), PRIMARY KEY(proceso_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proceso_user ADD CONSTRAINT FK_166EC69C640D1D53 FOREIGN KEY (proceso_id) REFERENCES proceso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proceso_user ADD CONSTRAINT FK_166EC69CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE proceso_user');
    }
}
