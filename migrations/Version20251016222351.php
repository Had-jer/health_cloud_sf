<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251016222351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE health_record (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E0DE7714A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_event (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, medical_event_category_id INT NOT NULL, date DATE NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_E4851F7A76ED395 (user_id), INDEX IDX_E4851F78071B6A5 (medical_event_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_event_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_event_summary (id INT AUTO_INCREMENT NOT NULL, medical_event_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_96574E2ED6D05DC (medical_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_speciality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATE NOT NULL, phone_number INT NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_medical_speciality (user_id INT NOT NULL, medical_speciality_id INT NOT NULL, INDEX IDX_74D26FB9A76ED395 (user_id), INDEX IDX_74D26FB9E6728935 (medical_speciality_id), PRIMARY KEY(user_id, medical_speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE health_record ADD CONSTRAINT FK_E0DE7714A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F78071B6A5 FOREIGN KEY (medical_event_category_id) REFERENCES medical_event_category (id)');
        $this->addSql('ALTER TABLE medical_event_summary ADD CONSTRAINT FK_96574E2ED6D05DC FOREIGN KEY (medical_event_id) REFERENCES medical_event (id)');
        $this->addSql('ALTER TABLE user_medical_speciality ADD CONSTRAINT FK_74D26FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_medical_speciality ADD CONSTRAINT FK_74D26FB9E6728935 FOREIGN KEY (medical_speciality_id) REFERENCES medical_speciality (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_record DROP FOREIGN KEY FK_E0DE7714A76ED395');
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F7A76ED395');
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F78071B6A5');
        $this->addSql('ALTER TABLE medical_event_summary DROP FOREIGN KEY FK_96574E2ED6D05DC');
        $this->addSql('ALTER TABLE user_medical_speciality DROP FOREIGN KEY FK_74D26FB9A76ED395');
        $this->addSql('ALTER TABLE user_medical_speciality DROP FOREIGN KEY FK_74D26FB9E6728935');
        $this->addSql('DROP TABLE health_record');
        $this->addSql('DROP TABLE medical_event');
        $this->addSql('DROP TABLE medical_event_category');
        $this->addSql('DROP TABLE medical_event_summary');
        $this->addSql('DROP TABLE medical_speciality');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_medical_speciality');
    }
}
