<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190728115203 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE artistic_work (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CE5AAFC74E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_472B783A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, registered_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_category (user_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E6C1FDC1A76ED395 (user_id), INDEX IDX_E6C1FDC112469DE2 (category_id), PRIMARY KEY(user_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artistic_work ADD CONSTRAINT FK_CE5AAFC74E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A12469DE2');
        $this->addSql('ALTER TABLE user_category DROP FOREIGN KEY FK_E6C1FDC112469DE2');
        $this->addSql('ALTER TABLE artistic_work DROP FOREIGN KEY FK_CE5AAFC74E7AF8F');
        $this->addSql('ALTER TABLE user_category DROP FOREIGN KEY FK_E6C1FDC1A76ED395');
        $this->addSql('DROP TABLE artistic_work');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_category');
    }
}
