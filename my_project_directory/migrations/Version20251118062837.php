<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118062837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer RENAME INDEX email TO UNIQ_81398E09E7927C74');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY order_ibfk_1');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME NOT NULL, CHANGE total total NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` RENAME INDEX customer_id TO IDX_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_book DROP quantity');
        $this->addSql('ALTER TABLE order_book RENAME INDEX book_id TO IDX_8614992616A2B381');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE customer RENAME INDEX uniq_81398e09e7927c74 TO email');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE total total NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT order_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f52993989395c3f3 TO customer_id');
        $this->addSql('ALTER TABLE order_book ADD quantity INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE order_book RENAME INDEX idx_8614992616a2b381 TO book_id');
    }
}
