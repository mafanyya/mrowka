<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520033025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achievement ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_96737FF1CDF80196 ON achievement (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achievement DROP FOREIGN KEY FK_96737FF1CDF80196');
        $this->addSql('DROP INDEX IDX_96737FF1CDF80196 ON achievement');
        $this->addSql('ALTER TABLE achievement DROP lesson_id');
    }
}
