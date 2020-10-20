<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200929153532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament_entry2 ADD COLUMN round INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tournament_entry2 AS SELECT id, traveldistance, model, flight_duration, participant_name, date FROM tournament_entry2');
        $this->addSql('DROP TABLE tournament_entry2');
        $this->addSql('CREATE TABLE tournament_entry2 (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, traveldistance DOUBLE PRECISION NOT NULL, model CLOB NOT NULL, flight_duration DOUBLE PRECISION NOT NULL, participant_name CLOB NOT NULL, date DATE NOT NULL)');
        $this->addSql('INSERT INTO tournament_entry2 (id, traveldistance, model, flight_duration, participant_name, date) SELECT id, traveldistance, model, flight_duration, participant_name, date FROM __temp__tournament_entry2');
        $this->addSql('DROP TABLE __temp__tournament_entry2');
    }
}
