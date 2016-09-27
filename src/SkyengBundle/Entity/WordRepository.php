<?php

namespace SkyengBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * WordRepository
 *
 */
class WordRepository extends EntityRepository
{
    /**
     * @param int $count
     * @return array
     */
    public function getRandomIds($count = 10)
    {
        $conn = $this->getEntityManager()->getConnection();
        $table = $this->getClassMetadata()->getTableName();

        $rowCount = (int)$conn->fetchColumn(sprintf("SELECT COUNT(*) cnt FROM %s", $table));
        if ($rowCount < $count) {
            $rowCount = $count;
        }

        $query = $ids = [];
        do {
            $rand = rand(0, $rowCount - 1);
            $query[$rand] = sprintf("(SELECT id FROM %s LIMIT %s, 1)", $table, $rand);

        } while (count($query) < $count);

        $query = implode(' UNION ', $query);

        foreach($conn->fetchAll($query) as $row) {
            $ids[] = $row['id'];
        }

        return $ids;
    }

    /**
     * @param $excludeId
     * @param $lang
     *
     * @return array
     */
    public function getRandomTranslateOptions($excludeId, $lang)
    {
        $answers = $this->createQueryBuilder('w')
            ->where('w.id != :excludeId')
            ->setParameter('excludeId', $excludeId)
            ->getQuery()
            ->getResult()
        ;

        shuffle($answers);

        $randomWords = array_slice($answers, 0, 3, true);

        $randomOptions = array_map(function ($element) use ($lang) {
            $getter = 'get' . ucfirst($lang);
            return $element->$getter();
        }, $randomWords);

        return $randomOptions;
    }
}
