<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730122137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56A70FE35');
        $this->addSql('DROP INDEX IDX_F65593E56A70FE35 ON annonce');
        $this->addSql('ALTER TABLE annonce CHANGE fuel_type_id garage_id INT NOT NULL, CHANGE garage fuel_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5C4FFF555 ON annonce (garage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C4FFF555');
        $this->addSql('DROP INDEX IDX_F65593E5C4FFF555 ON annonce');
        $this->addSql('ALTER TABLE annonce CHANGE garage_id fuel_type_id INT NOT NULL, CHANGE fuel_type garage VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56A70FE35 FOREIGN KEY (fuel_type_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_F65593E56A70FE35 ON annonce (fuel_type_id)');
    }
}
