<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427084242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD lesson_section_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3D52AAAAB FOREIGN KEY (lesson_section_id) REFERENCES lesson_section (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3D52AAAAB ON lesson (lesson_section_id)');
        $this->addSql('ALTER TABLE lesson_section ADD description LONGTEXT NOT NULL, ADD img VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3D52AAAAB');
        $this->addSql('DROP INDEX IDX_F87474F3D52AAAAB ON lesson');
        $this->addSql('ALTER TABLE lesson DROP lesson_section_id');
        $this->addSql('ALTER TABLE lesson_section DROP description, DROP img');
    }
}
