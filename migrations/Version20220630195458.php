<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630195458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE folder ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('DROP INDEX IDX_CFBDFA14162CB942');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, folder_id, title, content, created_at, color FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, folder_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, color CLOB NOT NULL, CONSTRAINT FK_CFBDFA14162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO note (id, folder_id, title, content, created_at, color) SELECT id, folder_id, title, content, created_at, color FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA14162CB942 ON note (folder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__folder AS SELECT id, name FROM folder');
        $this->addSql('DROP TABLE folder');
        $this->addSql('CREATE TABLE folder (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO folder (id, name) SELECT id, name FROM __temp__folder');
        $this->addSql('DROP TABLE __temp__folder');
        $this->addSql('DROP INDEX IDX_CFBDFA14162CB942');
        $this->addSql('CREATE TEMPORARY TABLE __temp__note AS SELECT id, folder_id, title, content, created_at, color FROM note');
        $this->addSql('DROP TABLE note');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, folder_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, color CLOB NOT NULL)');
        $this->addSql('INSERT INTO note (id, folder_id, title, content, created_at, color) SELECT id, folder_id, title, content, created_at, color FROM __temp__note');
        $this->addSql('DROP TABLE __temp__note');
        $this->addSql('CREATE INDEX IDX_CFBDFA14162CB942 ON note (folder_id)');
    }
}
