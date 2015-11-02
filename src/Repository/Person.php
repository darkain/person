<?php

namespace Del\Repository;

use Del\Entity\Person as PersonEntity;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;

class Person extends RepositoryAbstract
{
    /** @var \Doctrine\DBAL\Connection */
    protected $connection;

    /** @var string $table */
    protected $table;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->table = 'person';
        parent::__construct($connection);
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDBALConnection()
    {
        return $this->connection;
    }

    /**
     * @param $id
     * @return PersonEntity
     * @throws Exception
     */
    public function findById($id)
    {
        $row = parent::findById($id);

        if ($row === false) {
            throw new Exception('Could not find person');
        }

        $entity = new PersonEntity($row);

        return $entity;
    }

    public function delete($id)
    {
        $this->connection->delete($this->table, ['id' => $id]);
    }

    /**
     * @param QueryBuilder $query
     * @param $limit
     * @param $offset
     * @return QueryBuilder
     */
    protected function setLimitAndOffset(QueryBuilder &$query, $limit, $offset = 0)
    {
        if ($offset > -1) {
            $query->setFirstResult($offset);
        }
        if ($limit) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

}
