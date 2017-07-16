<?php

namespace Mpwar\DataProcessor\Infrastructure\Ui\Console\Command;

use Mpwar\DataProcessor\Application\Service\DataProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessQueue extends Command
{
    private $dataProcessor;

    public function __construct(DataProcessor $dataProcessor)
    {
        parent::__construct();
        $this->dataProcessor = $dataProcessor;
    }

    protected function configure()
    {
        $this
            ->setName('queue:process')
            ->setDescription('Consume messages from bus and process raw documents');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start message consumer task');

        $this->dataProcessor->execute();
    }
}
