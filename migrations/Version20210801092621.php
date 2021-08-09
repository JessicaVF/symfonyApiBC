<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801092621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F26610BF5B7AF75 ON garage (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage DROP FOREIGN KEY FK_9F26610BF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_9F26610BF5B7AF75 ON garage');
        $this->addSql('ALTER TABLE garage DROP address_id');
    }
}
