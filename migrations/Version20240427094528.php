<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427094528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F17511CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_C3F17511CDF80196 ON word (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F17511CDF80196');
        $this->addSql('DROP INDEX IDX_C3F17511CDF80196 ON word');
        $this->addSql('ALTER TABLE word DROP lesson_id');
    }
}
