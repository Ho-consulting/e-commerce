<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430121109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivry (id INT AUTO_INCREMENT NOT NULL, price_delivry DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD delivry_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2765461A12 FOREIGN KEY (delivry_id) REFERENCES delivry (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2765461A12 ON produit (delivry_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2765461A12');
        $this->addSql('DROP TABLE delivry');
        $this->addSql('DROP INDEX IDX_29A5EC2765461A12 ON produit');
        $this->addSql('ALTER TABLE produit DROP delivry_id');
    }
}
