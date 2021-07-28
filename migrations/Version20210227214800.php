<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227214800 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educational_subjects_plan DROP FOREIGN KEY FK_FC026B4477BC7E0');
        $this->addSql('ALTER TABLE educational_subjects_plan CHANGE educational_plan_id educational_plan_id INT NOT NULL');
        $this->addSql('ALTER TABLE educational_subjects_plan ADD CONSTRAINT FK_FC026B4477BC7E0 FOREIGN KEY (educational_plan_id) REFERENCES educational_plans (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educational_subjects_plan DROP FOREIGN KEY FK_FC026B4477BC7E0');
        $this->addSql('ALTER TABLE educational_subjects_plan CHANGE educational_plan_id educational_plan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE educational_subjects_plan ADD CONSTRAINT FK_FC026B4477BC7E0 FOREIGN KEY (educational_plan_id) REFERENCES educational_plans (id)');
    }
}
