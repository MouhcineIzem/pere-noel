<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131132717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_cadeau (panier_id INT NOT NULL, cadeau_id INT NOT NULL, INDEX IDX_88D8D67EF77D927C (panier_id), INDEX IDX_88D8D67ED9D5ED84 (cadeau_id), PRIMARY KEY(panier_id, cadeau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_cadeau ADD CONSTRAINT FK_88D8D67EF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_cadeau ADD CONSTRAINT FK_88D8D67ED9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2D9D5ED84');
        $this->addSql('DROP INDEX IDX_24CC0DF2D9D5ED84 ON panier');
        $this->addSql('ALTER TABLE panier DROP cadeau_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier_cadeau');
        $this->addSql('ALTER TABLE panier ADD cadeau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2D9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2D9D5ED84 ON panier (cadeau_id)');
    }
}
