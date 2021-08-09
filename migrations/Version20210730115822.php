<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730115822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD model_id INT NOT NULL, ADD fuel_type_id INT NOT NULL, DROP model, DROP fuel_type');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57975B7E7 FOREIGN KEY (model_id) REFERENCES make (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56A70FE35 FOREIGN KEY (fuel_type_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_F65593E57975B7E7 ON annonce (model_id)');
        $this->addSql('CREATE INDEX IDX_F65593E56A70FE35 ON annonce (fuel_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57975B7E7');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56A70FE35');
        $this->addSql('DROP INDEX IDX_F65593E57975B7E7 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E56A70FE35 ON annonce');
        $this->addSql('ALTER TABLE annonce ADD model VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD fuel_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP model_id, DROP fuel_type_id');
    }
}
