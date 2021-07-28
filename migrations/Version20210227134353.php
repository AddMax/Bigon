<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227134353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE educational_subjects_plan (id INT AUTO_INCREMENT NOT NULL, educational_plan_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lecture INT DEFAULT NULL, distribution LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_FC026B4477BC7E0 (educational_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE educational_subjects_plan ADD CONSTRAINT FK_FC026B4477BC7E0 FOREIGN KEY (educational_plan_id) REFERENCES educational_plans (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE educational_subjects_plan');
    }
}
