<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031200803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_hole_score ADD game_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_hole_score ADD CONSTRAINT FK_52AE08B3E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_52AE08B3E48FD905 ON user_hole_score (game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_hole_score DROP FOREIGN KEY FK_52AE08B3E48FD905');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP INDEX IDX_52AE08B3E48FD905 ON user_hole_score');
        $this->addSql('ALTER TABLE user_hole_score DROP game_id');
    }
}
