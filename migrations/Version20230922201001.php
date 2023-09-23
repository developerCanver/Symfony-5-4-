<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922201001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE colegio.notas (id INT NOT NULL, materia_id INT NOT NULL, estudiante_id INT NOT NULL, nota DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F205382B54DBBCB ON colegio.notas (materia_id)');
        $this->addSql('CREATE INDEX IDX_9F20538259590C39 ON colegio.notas (estudiante_id)');
        $this->addSql('ALTER TABLE colegio.notas ADD CONSTRAINT FK_9F205382B54DBBCB FOREIGN KEY (materia_id) REFERENCES colegio.materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE colegio.notas ADD CONSTRAINT FK_9F20538259590C39 FOREIGN KEY (estudiante_id) REFERENCES colegio.estudiantes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F205382B54DBBCB');
        $this->addSql('ALTER TABLE colegio.notas DROP CONSTRAINT FK_9F20538259590C39');
        $this->addSql('DROP TABLE colegio.notas');
    }
}
