<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828201623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Llenar tabla de tipo de identificacion';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO colegio.tipo_id(id, tipo_id) VALUES (nextval('colegio.tipo_id_id_seq'), 'Cedula');");
        $this->addSql("INSERT INTO colegio.tipo_id(id, tipo_id) VALUES (nextval('colegio.tipo_id_id_seq'), 'Tarjeta de identidad');");
        $this->addSql("INSERT INTO colegio.tipo_id(id, tipo_id) VALUES (nextval('colegio.tipo_id_id_seq'), 'Tarjeta de extranjeria');");
        $this->addSql("INSERT INTO colegio.tipo_id(id, tipo_id) VALUES (nextval('colegio.tipo_id_id_seq'), 'Pasaporte');");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
