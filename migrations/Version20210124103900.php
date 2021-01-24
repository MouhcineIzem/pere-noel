<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124103900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau DROP FOREIGN KEY FK_3D213460F77D927C');
        $this->addSql('DROP INDEX IDX_3D213460F77D927C ON cadeau');
        $this->addSql('ALTER TABLE cadeau DROP panier_id');
        $this->addSql('ALTER TABLE panier ADD cadeau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2D9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2D9D5ED84 ON panier (cadeau_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau ADD panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cadeau ADD CONSTRAINT FK_3D213460F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('CREATE INDEX IDX_3D213460F77D927C ON cadeau (panier_id)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2D9D5ED84');
        $this->addSql('DROP INDEX IDX_24CC0DF2D9D5ED84 ON panier');
        $this->addSql('ALTER TABLE panier DROP cadeau_id');
    }
}
