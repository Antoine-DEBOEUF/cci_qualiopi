<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617100721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE infos_user ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE infos_user ADD CONSTRAINT FK_AA81A6EAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA81A6EAA76ED395 ON infos_user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE infos_user DROP FOREIGN KEY FK_AA81A6EAA76ED395');
        $this->addSql('DROP INDEX UNIQ_AA81A6EAA76ED395 ON infos_user');
        $this->addSql('ALTER TABLE infos_user DROP user_id');
    }
}
