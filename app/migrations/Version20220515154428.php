<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515154428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, smartphone INT DEFAULT NULL, acc INT DEFAULT NULL, INDEX IDX_6B81704412469DE2 (category_id), INDEX IDX_6B817044F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_add (sales_id INT NOT NULL, add_id INT NOT NULL, INDEX IDX_80EDCFDA4522A07 (sales_id), INDEX IDX_80EDCFD339CD0A7 (add_id), PRIMARY KEY(sales_id, add_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(128) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B81704412469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE sales_add ADD CONSTRAINT FK_80EDCFDA4522A07 FOREIGN KEY (sales_id) REFERENCES sales (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sales_add ADD CONSTRAINT FK_80EDCFD339CD0A7 FOREIGN KEY (add_id) REFERENCES adds (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sales_add DROP FOREIGN KEY FK_80EDCFD339CD0A7');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B81704412469DE2');
        $this->addSql('ALTER TABLE sales_add DROP FOREIGN KEY FK_80EDCFDA4522A07');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044F675F31B');
        $this->addSql('DROP TABLE adds');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE sales_add');
        $this->addSql('DROP TABLE users');
    }
}
