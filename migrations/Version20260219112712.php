<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219112712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1BDA53C6A76ED395 ON medecin (user_id)');
        $this->addSql('ALTER TABLE patient ADD user_id INT NOT NULL, DROP email, DROP password');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA76ED395 ON patient (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY `FK_8D93D6494F31A84`');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY `FK_8D93D6496B899279`');
        $this->addSql('DROP INDEX UNIQ_8D93D6494F31A84 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B899279 ON user');
        $this->addSql('ALTER TABLE user DROP medecin_id, DROP patient_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6A76ED395');
        $this->addSql('DROP INDEX UNIQ_1BDA53C6A76ED395 ON medecin');
        $this->addSql('ALTER TABLE medecin DROP user_id');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA76ED395');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBA76ED395 ON patient');
        $this->addSql('ALTER TABLE patient ADD email VARCHAR(255) NOT NULL, ADD password VARCHAR(10) NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE user ADD medecin_id INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT `FK_8D93D6494F31A84` FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT `FK_8D93D6496B899279` FOREIGN KEY (patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494F31A84 ON user (medecin_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B899279 ON user (patient_id)');
    }
}
