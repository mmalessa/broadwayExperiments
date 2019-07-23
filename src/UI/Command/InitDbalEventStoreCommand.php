<?php

namespace App\UI\Command;

use App\Infrastructure\DBALSnapshotStore;
use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitDbalEventStoreCommand extends Command
{
    protected static $defaultName = 'app:eventstore:schemainit';
    private $connection;
    private $eventStore;
    private $snapshotStore;

    public function __construct(
        Connection $connection,
        DBALEventStore $eventStore,
        DBALSnapshotStore $snapshotStore
    ) {
        $this->connection = $connection;
        $this->eventStore = $eventStore;
        $this->snapshotStore = $snapshotStore;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Init DBAL event store');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->connection) {
            $output->writeln('<error>Could not create Broadway event-store schema</error>');
            $output->writeln(sprintf('<error>%s</error>', $this->exception->getMessage()));
            return 1;
        }

        $error = false;

        try {
            $schemaManager = $this->connection->getSchemaManager();
            $schema = $schemaManager->createSchema();
            $eventStore = $this->eventStore;
            $snapshotStore = $this->snapshotStore;

            $tableEvents = $eventStore->configureSchema($schema);
            $tableSnapshots = $snapshotStore->configureSchema($schema);


            if (null !== $tableEvents && null !== $tableSnapshots) {
                $schemaManager->createTable($tableEvents);
                $schemaManager->createTable($tableSnapshots);
                $output->writeln('<info>Created Broadway event-store schema</info>');
            } else {
                $output->writeln('<info>Broadway event-store schema already exists</info>');
            }
        } catch (Exception $e) {
            $output->writeln('<error>Could not create Broadway event-store schema</error>');
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $error = true;
        }

        return $error ? 1 : 0;
    }
}


