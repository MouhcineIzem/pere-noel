<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128132657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_list (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B02EDD61217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_list_cadeau (panier_list_id INT NOT NULL, cadeau_id INT NOT NULL, INDEX IDX_24F044BCC714D20A (panier_list_id), INDEX IDX_24F044BCD9D5ED84 (cadeau_id), PRIMARY KEY(panier_list_id, cadeau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_list ADD CONSTRAINT FK_B02EDD61217BBB47 FOREIGN KEY (person_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier_list_cadeau ADD CONSTRAINT FK_24F044BCC714D20A FOREIGN KEY (panier_list_id) REFERENCES panier_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_list_cadeau ADD CONSTRAINT FK_24F044BCD9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_list_cadeau DROP FOREIGN KEY FK_24F044BCC714D20A');
        $this->addSql('DROP TABLE panier_list');
        $this->addSql('DROP TABLE panier_list_cadeau');
    }
}
