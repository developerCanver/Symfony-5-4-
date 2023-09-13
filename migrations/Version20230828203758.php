<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828203758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajuste de tipo de identificacion cedula ciudadania';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE colegio.tipo_id set tipo_id='Cedula de ciudadania' where tipo_id='Cedula';");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
