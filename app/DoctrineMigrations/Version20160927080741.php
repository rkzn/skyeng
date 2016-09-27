<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160927080741 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE test_errors (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, answer VARCHAR(255) NOT NULL, quantity INT NOT NULL, INDEX IDX_AB885433E357438D (word_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_result (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, points INT NOT NULL, errors INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_errors ADD CONSTRAINT FK_AB885433E357438D FOREIGN KEY (word_id) REFERENCES test_words (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test_errors DROP FOREIGN KEY FK_AB885433E357438D');
        $this->addSql('DROP TABLE test_errors');
        $this->addSql('DROP TABLE test_result');
    }
}
