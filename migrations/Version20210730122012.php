<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730122012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C4FFF555');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57975B7E7');
        $this->addSql('DROP INDEX IDX_F65593E5C4FFF555 ON annonce');
        $this->addSql('ALTER TABLE annonce CHANGE garage_id make_id INT NOT NULL, CHANGE make garage VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5CFBF73EB FOREIGN KEY (make_id) REFERENCES make (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5CFBF73EB ON annonce (make_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5CFBF73EB');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57975B7E7');
        $this->addSql('DROP INDEX IDX_F65593E5CFBF73EB ON annonce');
        $this->addSql('ALTER TABLE annonce CHANGE make_id garage_id INT NOT NULL, CHANGE garage make VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57975B7E7 FOREIGN KEY (model_id) REFERENCES make (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5C4FFF555 ON annonce (garage_id)');
    }
}
