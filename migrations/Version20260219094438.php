<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219094438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin_patient (medecin_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_64F312D64F31A84 (medecin_id), INDEX IDX_64F312D66B899279 (patient_id), PRIMARY KEY (medecin_id, patient_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE medecin_patient ADD CONSTRAINT FK_64F312D64F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medecin_patient ADD CONSTRAINT FK_64F312D66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin_patient DROP FOREIGN KEY FK_64F312D64F31A84');
        $this->addSql('ALTER TABLE medecin_patient DROP FOREIGN KEY FK_64F312D66B899279');
        $this->addSql('DROP TABLE medecin_patient');
    }
}
