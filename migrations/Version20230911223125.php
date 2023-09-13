<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911223125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colegio.estudiantes ADD fecha_crea TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE colegio.estudiantes ADD fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE colegio.estudiantes ADD preferencias VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE colegio.estudiantes RENAME COLUMN apellido TO apellidos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE colegio.estudiantes DROP fecha_crea');
        $this->addSql('ALTER TABLE colegio.estudiantes DROP fecha_mod');
        $this->addSql('ALTER TABLE colegio.estudiantes DROP preferencias');
        $this->addSql('ALTER TABLE colegio.estudiantes RENAME COLUMN apellidos TO apellido');
    }
}
