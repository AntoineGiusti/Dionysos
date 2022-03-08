<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308104522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_participant (activity_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_D911011D81C06096 (activity_id), INDEX IDX_D911011D9D1C3019 (participant_id), PRIMARY KEY(activity_id, participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_participant ADD CONSTRAINT FK_D911011D81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_participant ADD CONSTRAINT FK_D911011D9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity ADD status_id INT NOT NULL, ADD campus_id INT NOT NULL, ADD organizer_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A876C4DDA FOREIGN KEY (organizer_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A6BF700BD ON activity (status_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AAF5D55E1 ON activity (campus_id)');
        $this->addSql('CREATE INDEX IDX_AC74095A876C4DDA ON activity (organizer_id)');
        $this->addSql('ALTER TABLE participant ADD campus_id INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B11AF5D55E1 ON participant (campus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity_participant');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A6BF700BD');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AAF5D55E1');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A876C4DDA');
        $this->addSql('DROP INDEX IDX_AC74095A6BF700BD ON activity');
        $this->addSql('DROP INDEX IDX_AC74095AAF5D55E1 ON activity');
        $this->addSql('DROP INDEX IDX_AC74095A876C4DDA ON activity');
        $this->addSql('ALTER TABLE activity DROP status_id, DROP campus_id, DROP organizer_id');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11AF5D55E1');
        $this->addSql('DROP INDEX IDX_D79F6B11AF5D55E1 ON participant');
        $this->addSql('ALTER TABLE participant DROP campus_id');
    }
}
