<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114192426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau DROP FOREIGN KEY FK_3D213460A76ED395');
        $this->addSql('DROP INDEX IDX_3D213460A76ED395 ON cadeau');
        $this->addSql('ALTER TABLE cadeau DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cadeau ADD CONSTRAINT FK_3D213460A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3D213460A76ED395 ON cadeau (user_id)');
    }
}
