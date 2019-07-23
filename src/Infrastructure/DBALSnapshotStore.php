<?php

namespace App\Infrastructure;

use Assert\Assertion;
use Broadway\Snapshotting\Snapshot\Snapshot;
use Broadway\Snapshotting\Snapshot\SnapshotRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

class DBALSnapshotStore implements SnapshotRepository
{
    private $connection;
    private $tableName;
    private $useBinary;

    public function __construct(
        Connection $connection,
        string $tableName,
        bool $useBinary
    )
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->useBinary = $useBinary; // FIXME - to implement
    }

    public function load($id)
    {
        $result = $this->connection
            ->fetchAssoc("SELECT `id`, `aggregate`, `playhead`, `type` FROM {$this->tableName} WHERE id = ?", [$id]);

        if (false !== $result) {
            // TODO
//            $data = igbinary_unserialize($result['aggregate']); // IGBINARY?
//            $playhead = $result['playhead'];
//            $className = $result['type'];
//            Assertion::implementsInterface(
//                $className,
//                SerializableAggregateInterface::class,
//                'The aggregate must implement "SerializableAggregateInterface" interface.'
//            );
//            $aggregateRoot = $className::createFromSnapshot($data, $playhead);
//            return new Snapshot($aggregateRoot);
        }
        return null;
    }

    public function save(Snapshot $snapshot)
    {
        $aggregateRoot = $snapshot->getAggregateRoot();
        $id = $aggregateRoot->getAggregateRootId();
        $playhead = $aggregateRoot->getPlayhead();
        $className = get_class($aggregateRoot);
//        Assertion::implementsInterface(
//            $className,
//            SerializableAggregateInterface::class,
//            'The aggregate must implement "SerializableAggregateInterface" interface.'
//        );
//        $serializedAggregate = igbinary_serialize($aggregateRoot);
//        $existingSnapshot = $this->connection
//            ->fetchAssoc("SELECT `id` FROM {$this->tableName} WHERE id = ?", [$id]);
//        if ($existingSnapshot) {
//            $this->connection
//                ->update(
//                    $this->tableName,
//                    [
//                        'aggregate' => $serializedAggregate,
//                        'playhead' => $playhead,
//                    ],
//                    [
//                        'id' => $id,
//                    ]
//                );
//        } else {
//            $this->connection
//                ->insert(
//                    $this->tableName,
//                    [
//                        'id' => $id,
//                        'aggregate' => $serializedAggregate,
//                        'playhead' => $playhead,
//                        'type' => $className,
//                    ]
//                );
//        }
    }


    /**
     * @return \Doctrine\DBAL\Schema\Table|null
     */
    public function configureSchema(Schema $schema)
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    public function configureTable(Schema $schema = null)
    {
        $schema = $schema ?: new Schema();

        $uuidColumnDefinition = [
            'type'   => 'guid',
            'params' => [
                'length' => 36,
            ],
        ];

//        if ($this->useBinary) {
//            $uuidColumnDefinition['type']   = 'binary';
//            $uuidColumnDefinition['params'] = [
//                'length' => 16,
//                'fixed'  => true,
//            ];
//        }

        $table = $schema->createTable($this->tableName);

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('uuid', $uuidColumnDefinition['type'], $uuidColumnDefinition['params']);
        $table->addColumn('playhead', 'integer', ['unsigned' => true]);
        $table->addColumn('aggregate', 'text');
        $table->addColumn('type', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid']);

        return $table;
    }
}
