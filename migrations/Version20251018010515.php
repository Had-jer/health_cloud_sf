<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251018010515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_medical_speciality DROP FOREIGN KEY FK_74D26FB9A76ED395');
        $this->addSql('ALTER TABLE user_medical_speciality DROP FOREIGN KEY FK_74D26FB9E6728935');
        $this->addSql('DROP TABLE medical_speciality');
        $this->addSql('DROP TABLE user_medical_speciality');
        $this->addSql('ALTER TABLE user ADD medical_speciality VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical_speciality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_medical_speciality (user_id INT NOT NULL, medical_speciality_id INT NOT NULL, INDEX IDX_74D26FB9A76ED395 (user_id), INDEX IDX_74D26FB9E6728935 (medical_speciality_id), PRIMARY KEY(user_id, medical_speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_medical_speciality ADD CONSTRAINT FK_74D26FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_medical_speciality ADD CONSTRAINT FK_74D26FB9E6728935 FOREIGN KEY (medical_speciality_id) REFERENCES medical_speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP medical_speciality');
    }
}
