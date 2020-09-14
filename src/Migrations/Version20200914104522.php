<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914104522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_3AF346685E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_messages (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, message VARCHAR(255) NOT NULL, date DATE NOT NULL, time TIME NOT NULL, INDEX IDX_3B4CA1869AC0396 (conversation_id), INDEX IDX_3B4CA186A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE free_items (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, time TIME NOT NULL, state VARCHAR(10) NOT NULL, INDEX IDX_7A479EFD12469DE2 (category_id), INDEX IDX_7A479EFDA76ED395 (user_id), INDEX title_idx (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE free_item_conversations (id INT AUTO_INCREMENT NOT NULL, free_item_id INT NOT NULL, INDEX IDX_E38783D638CB8320 (free_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE free_item_pictures (id INT AUTO_INCREMENT NOT NULL, free_item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_911F903738CB8320 (free_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) DEFAULT NULL, total_ads INT DEFAULT NULL, live_ads INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, number VARCHAR(11) DEFAULT NULL, address_line_1 VARCHAR(255) DEFAULT NULL, address_line_2 VARCHAR(255) DEFAULT NULL, address_line_3 VARCHAR(255) DEFAULT NULL, address_town VARCHAR(255) DEFAULT NULL, address_county VARCHAR(255) DEFAULT NULL, address_post_code VARCHAR(255) DEFAULT NULL, total_free_ads INT NOT NULL, start_date DATE NOT NULL, start_time TIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation_messages ADD CONSTRAINT FK_3B4CA1869AC0396 FOREIGN KEY (conversation_id) REFERENCES free_item_conversations (id)');
        $this->addSql('ALTER TABLE conversation_messages ADD CONSTRAINT FK_3B4CA186A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE free_items ADD CONSTRAINT FK_7A479EFD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE free_items ADD CONSTRAINT FK_7A479EFDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE free_item_conversations ADD CONSTRAINT FK_E38783D638CB8320 FOREIGN KEY (free_item_id) REFERENCES free_items (id)');
        $this->addSql('ALTER TABLE free_item_pictures ADD CONSTRAINT FK_911F903738CB8320 FOREIGN KEY (free_item_id) REFERENCES free_items (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE free_items DROP FOREIGN KEY FK_7A479EFD12469DE2');
        $this->addSql('ALTER TABLE free_item_conversations DROP FOREIGN KEY FK_E38783D638CB8320');
        $this->addSql('ALTER TABLE free_item_pictures DROP FOREIGN KEY FK_911F903738CB8320');
        $this->addSql('ALTER TABLE conversation_messages DROP FOREIGN KEY FK_3B4CA1869AC0396');
        $this->addSql('ALTER TABLE conversation_messages DROP FOREIGN KEY FK_3B4CA186A76ED395');
        $this->addSql('ALTER TABLE free_items DROP FOREIGN KEY FK_7A479EFDA76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE conversation_messages');
        $this->addSql('DROP TABLE free_items');
        $this->addSql('DROP TABLE free_item_conversations');
        $this->addSql('DROP TABLE free_item_pictures');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE users');
    }
}
