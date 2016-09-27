<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use SkyengBundle\Entity\Word;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160927063643 extends AbstractMigration  implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE test_words (id INT AUTO_INCREMENT NOT NULL, eng VARCHAR(255) NOT NULL, rus VARCHAR(255) NOT NULL, INDEX idx_eng (eng), INDEX idx_rus (rus), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE test_words');
    }

    public function postUp(Schema $schema)
    {
        $rootPath = $this->container->get('kernel')->getRootDir();
        $filePath =  $rootPath . '/../src/SkyengBundle/Resources/data/words.json';
        $data = json_decode(file_get_contents($filePath), true);
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        foreach ($data as $eng => $rus) {
            $word = new Word();
            $word->setEng($eng);
            $word->setRus($rus);
            $em->persist($word);
        }
        $em->flush();
    }
}
