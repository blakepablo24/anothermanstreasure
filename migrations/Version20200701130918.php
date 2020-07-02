<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701130918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_3AF346685E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE free_item_pictures (id INT AUTO_INCREMENT NOT NULL, free_item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_911F903738CB8320 (free_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freeitems (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, time TIME NOT NULL, INDEX IDX_818E999612469DE2 (category_id), INDEX IDX_818E9996A76ED395 (user_id), INDEX title_idx (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE free_item_pictures ADD CONSTRAINT FK_911F903738CB8320 FOREIGN KEY (free_item_id) REFERENCES freeitems (id)');
        $this->addSql('ALTER TABLE freeitems ADD CONSTRAINT FK_818E999612469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE freeitems ADD CONSTRAINT FK_818E9996A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freeitems DROP FOREIGN KEY FK_818E999612469DE2');
        $this->addSql('ALTER TABLE free_item_pictures DROP FOREIGN KEY FK_911F903738CB8320');
        $this->addSql('ALTER TABLE freeitems DROP FOREIGN KEY FK_818E9996A76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE free_item_pictures');
        $this->addSql('DROP TABLE freeitems');
        $this->addSql('DROP TABLE users');
    }
}
