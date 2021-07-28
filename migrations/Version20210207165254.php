<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210207165254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE educational_plans (id INT AUTO_INCREMENT NOT NULL, specialty VARCHAR(255) NOT NULL, direction VARCHAR(255) NOT NULL, specialization VARCHAR(255) NOT NULL, qualification VARCHAR(255) NOT NULL, form_education VARCHAR(255) NOT NULL COMMENT \'(DC2Type:educational_process_plan_forma)\', status VARCHAR(255) NOT NULL COMMENT \'(DC2Type:educational_process_plan_status)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educational_schedules (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE educational_plans');
        $this->addSql('DROP TABLE educational_schedules');
    }
}
