<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416133834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(100) NOT NULL, created DATETIME NOT NULL, edited DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, user_id INT DEFAULT NULL, main LONGTEXT NOT NULL, created DATETIME NOT NULL, edited DATETIME NOT NULL, INDEX IDX_3E7B0BFBE2904019 (thread_id), INDEX IDX_3E7B0BFBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_vote (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_F6B18FFEA76ED395 (user_id), INDEX IDX_F6B18FFEFBF32840 (response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status VARCHAR(6) NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(100) NOT NULL, main LONGTEXT NOT NULL, created DATETIME NOT NULL, edited DATETIME NOT NULL, INDEX IDX_31204C83A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_category (thread_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_9FD5A1DE2904019 (thread_id), INDEX IDX_9FD5A1D12469DE2 (category_id), PRIMARY KEY(thread_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_vote (id INT AUTO_INCREMENT NOT NULL, thread_id INT NOT NULL, user_id INT NOT NULL, vote TINYINT(1) NOT NULL, INDEX IDX_DEA199EAE2904019 (thread_id), INDEX IDX_DEA199EAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(20) NOT NULL, created DATETIME NOT NULL, edited DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response_vote ADD CONSTRAINT FK_F6B18FFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response_vote ADD CONSTRAINT FK_F6B18FFEFBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread_category ADD CONSTRAINT FK_9FD5A1DE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_category ADD CONSTRAINT FK_9FD5A1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_vote ADD CONSTRAINT FK_DEA199EAE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE thread_vote ADD CONSTRAINT FK_DEA199EAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBE2904019');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBA76ED395');
        $this->addSql('ALTER TABLE response_vote DROP FOREIGN KEY FK_F6B18FFEA76ED395');
        $this->addSql('ALTER TABLE response_vote DROP FOREIGN KEY FK_F6B18FFEFBF32840');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C83A76ED395');
        $this->addSql('ALTER TABLE thread_category DROP FOREIGN KEY FK_9FD5A1DE2904019');
        $this->addSql('ALTER TABLE thread_category DROP FOREIGN KEY FK_9FD5A1D12469DE2');
        $this->addSql('ALTER TABLE thread_vote DROP FOREIGN KEY FK_DEA199EAE2904019');
        $this->addSql('ALTER TABLE thread_vote DROP FOREIGN KEY FK_DEA199EAA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_vote');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP TABLE thread_category');
        $this->addSql('DROP TABLE thread_vote');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
