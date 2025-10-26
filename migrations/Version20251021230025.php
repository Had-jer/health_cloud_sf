<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021230025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F78071B6A5');
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F7A76ED395');
        $this->addSql('DROP INDEX IDX_E4851F7A76ED395 ON medical_event');
        $this->addSql('DROP INDEX IDX_E4851F78071B6A5 ON medical_event');
        $this->addSql('ALTER TABLE medical_event ADD patient_id INT NOT NULL, ADD doctor_id INT NOT NULL, ADD label VARCHAR(255) NOT NULL, DROP user_id, DROP medical_event_category_id');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F76B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F787F4FB17 FOREIGN KEY (doctor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E4851F76B899279 ON medical_event (patient_id)');
        $this->addSql('CREATE INDEX IDX_E4851F787F4FB17 ON medical_event (doctor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F76B899279');
        $this->addSql('ALTER TABLE medical_event DROP FOREIGN KEY FK_E4851F787F4FB17');
        $this->addSql('DROP INDEX IDX_E4851F76B899279 ON medical_event');
        $this->addSql('DROP INDEX IDX_E4851F787F4FB17 ON medical_event');
        $this->addSql('ALTER TABLE medical_event ADD user_id INT NOT NULL, ADD medical_event_category_id INT NOT NULL, DROP patient_id, DROP doctor_id, DROP label');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F78071B6A5 FOREIGN KEY (medical_event_category_id) REFERENCES medical_event_category (id)');
        $this->addSql('ALTER TABLE medical_event ADD CONSTRAINT FK_E4851F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E4851F7A76ED395 ON medical_event (user_id)');
        $this->addSql('CREATE INDEX IDX_E4851F78071B6A5 ON medical_event (medical_event_category_id)');
    }
}
