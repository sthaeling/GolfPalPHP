<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030094346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE golf_club (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE golf_course (id INT AUTO_INCREMENT NOT NULL, golf_club_id INT NOT NULL, name VARCHAR(255) NOT NULL, holes_amount INT NOT NULL, INDEX IDX_EC96E16270E209E0 (golf_club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hole (id INT AUTO_INCREMENT NOT NULL, golf_course_id INT NOT NULL, hole_number INT NOT NULL, par INT NOT NULL, distance INT NOT NULL, hcp INT NOT NULL, INDEX IDX_68CD3D91731B2E4E (golf_course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, handicap VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_hole_score (id INT AUTO_INCREMENT NOT NULL, hole_id INT NOT NULL, user_id INT NOT NULL, score INT NOT NULL, INDEX IDX_52AE08B315ADE12C (hole_id), INDEX IDX_52AE08B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE golf_course ADD CONSTRAINT FK_EC96E16270E209E0 FOREIGN KEY (golf_club_id) REFERENCES golf_club (id)');
        $this->addSql('ALTER TABLE hole ADD CONSTRAINT FK_68CD3D91731B2E4E FOREIGN KEY (golf_course_id) REFERENCES golf_course (id)');
        $this->addSql('ALTER TABLE user_hole_score ADD CONSTRAINT FK_52AE08B315ADE12C FOREIGN KEY (hole_id) REFERENCES hole (id)');
        $this->addSql('ALTER TABLE user_hole_score ADD CONSTRAINT FK_52AE08B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE golf_course DROP FOREIGN KEY FK_EC96E16270E209E0');
        $this->addSql('ALTER TABLE hole DROP FOREIGN KEY FK_68CD3D91731B2E4E');
        $this->addSql('ALTER TABLE user_hole_score DROP FOREIGN KEY FK_52AE08B315ADE12C');
        $this->addSql('ALTER TABLE user_hole_score DROP FOREIGN KEY FK_52AE08B3A76ED395');
        $this->addSql('DROP TABLE golf_club');
        $this->addSql('DROP TABLE golf_course');
        $this->addSql('DROP TABLE hole');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_hole_score');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
