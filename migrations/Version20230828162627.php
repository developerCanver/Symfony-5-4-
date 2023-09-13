<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828162627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colegio.estudiantes ADD tipoid_id INT NOT NULL');
        $this->addSql('ALTER TABLE colegio.estudiantes ADD CONSTRAINT FK_5D61759C284E3909 FOREIGN KEY (tipoid_id) REFERENCES colegio.tipo_id (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5D61759C284E3909 ON colegio.estudiantes (tipoid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE colegio.estudiantes DROP CONSTRAINT FK_5D61759C284E3909');
        $this->addSql('DROP INDEX IDX_5D61759C284E3909');
        $this->addSql('ALTER TABLE colegio.estudiantes DROP tipoid_id');
    }
}
