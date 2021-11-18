<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118135425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE climber ADD roles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE climber ADD CONSTRAINT FK_E8B8EC7938C751C4 FOREIGN KEY (roles_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX IDX_E8B8EC7938C751C4 ON climber (roles_id)');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC13F5CC4464');
        $this->addSql('DROP INDEX IDX_9AEACC13F5CC4464 ON level');
        $this->addSql('ALTER TABLE level DROP climbers_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE climber DROP FOREIGN KEY FK_E8B8EC7938C751C4');
        $this->addSql('DROP INDEX IDX_E8B8EC7938C751C4 ON climber');
        $this->addSql('ALTER TABLE climber DROP roles_id');
        $this->addSql('ALTER TABLE level ADD climbers_id INT NOT NULL');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13F5CC4464 FOREIGN KEY (climbers_id) REFERENCES climber (id)');
        $this->addSql('CREATE INDEX IDX_9AEACC13F5CC4464 ON level (climbers_id)');
    }
}
