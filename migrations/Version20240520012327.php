<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520012327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_lesson_section (user_id INT NOT NULL, lesson_section_id INT NOT NULL, INDEX IDX_B38AF711A76ED395 (user_id), INDEX IDX_B38AF711D52AAAAB (lesson_section_id), PRIMARY KEY(user_id, lesson_section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_lesson_section ADD CONSTRAINT FK_B38AF711A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lesson_section ADD CONSTRAINT FK_B38AF711D52AAAAB FOREIGN KEY (lesson_section_id) REFERENCES lesson_section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_lesson_section DROP FOREIGN KEY FK_B38AF711A76ED395');
        $this->addSql('ALTER TABLE user_lesson_section DROP FOREIGN KEY FK_B38AF711D52AAAAB');
        $this->addSql('DROP TABLE user_lesson_section');
    }
}
