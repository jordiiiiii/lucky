<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226212549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE premi ADD organisme_id INT NOT NULL');
        $this->addSql('ALTER TABLE premi ADD CONSTRAINT FK_54E7BA185DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('CREATE INDEX IDX_54E7BA185DDD38F5 ON premi (organisme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE premi DROP FOREIGN KEY FK_54E7BA185DDD38F5');
        $this->addSql('DROP INDEX IDX_54E7BA185DDD38F5 ON premi');
        $this->addSql('ALTER TABLE premi DROP organisme_id');
    }
}
