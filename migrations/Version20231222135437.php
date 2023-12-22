<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231222135437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitation DROP code_postal, DROP ville, DROP pays, DROP complement');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitation ADD code_postal VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD complement VARCHAR(255) DEFAULT NULL');
    }
}
