<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118134020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE climber (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, points INT NOT NULL, UNIQUE INDEX UNIQ_E8B8EC79E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE climber_meeting (id INT AUTO_INCREMENT NOT NULL, climber_id INT NOT NULL, meeting_id INT NOT NULL, has_participated TINYINT(1) NOT NULL, INDEX IDX_187F5B9AA101159 (climber_id), INDEX IDX_187F5B9A67433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, meeting_id INT NOT NULL, climber_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526C67433D9C (meeting_id), INDEX IDX_9474526CA101159 (climber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, points_needed INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, level_id INT NOT NULL, climber_id INT NOT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, limit_climber INT NOT NULL, picture VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_F515E1395FB14BA7 (level_id), INDEX IDX_F515E139A101159 (climber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting_picture (id INT AUTO_INCREMENT NOT NULL, meeting_id INT NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_8E09070467433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE climber_meeting ADD CONSTRAINT FK_187F5B9AA101159 FOREIGN KEY (climber_id) REFERENCES climber (id)');
        $this->addSql('ALTER TABLE climber_meeting ADD CONSTRAINT FK_187F5B9A67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA101159 FOREIGN KEY (climber_id) REFERENCES climber (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E1395FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139A101159 FOREIGN KEY (climber_id) REFERENCES climber (id)');
        $this->addSql('ALTER TABLE meeting_picture ADD CONSTRAINT FK_8E09070467433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE climber_meeting DROP FOREIGN KEY FK_187F5B9AA101159');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA101159');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139A101159');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E1395FB14BA7');
        $this->addSql('ALTER TABLE climber_meeting DROP FOREIGN KEY FK_187F5B9A67433D9C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C67433D9C');
        $this->addSql('ALTER TABLE meeting_picture DROP FOREIGN KEY FK_8E09070467433D9C');
        $this->addSql('DROP TABLE climber');
        $this->addSql('DROP TABLE climber_meeting');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE meeting_picture');
    }
}
