<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191031091929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4869D86650F');
        $this->addSql('DROP INDEX IDX_1B80E4869D86650F ON vehicle');
        $this->addSql('ALTER TABLE vehicle CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486A76ED395 FOREIGN KEY (user_id) REFERENCES users_android (id)');
        $this->addSql('CREATE INDEX IDX_1B80E486A76ED395 ON vehicle (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486A76ED395');
        $this->addSql('DROP INDEX IDX_1B80E486A76ED395 ON vehicle');
        $this->addSql('ALTER TABLE vehicle CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4869D86650F FOREIGN KEY (user_id_id) REFERENCES users_android (id)');
        $this->addSql('CREATE INDEX IDX_1B80E4869D86650F ON vehicle (user_id_id)');
    }
}
