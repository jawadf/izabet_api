<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031075337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, create_date DATETIME DEFAULT NULL, vehicle_id INT NOT NULL, vehicle_code VARCHAR(5) NOT NULL, vehicle_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, create_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL, ticket_date VARCHAR(255) NOT NULL, notification INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_android (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, create_date DATETIME DEFAULT NULL, vehicle INT DEFAULT NULL, token INT DEFAULT NULL, device_id VARCHAR(255) NOT NULL, device_name VARCHAR(255) DEFAULT NULL, update_date DATETIME DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, salt INT DEFAULT NULL, active INT DEFAULT NULL, notification INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE users_android');
    }
}
