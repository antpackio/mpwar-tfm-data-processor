<?php

namespace Mpwar\DataProcessor\Infrastructure\Ui\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessQueue extends Command
{
    private $applicationService;

    public function __construct(\Mpwar\DataProcessor\Application\Service\ProcessQueue $applicationService)
    {
        parent::__construct();
        $this->applicationService = $applicationService;
    }

    protected function configure()
    {
        $this
            ->setName('queue:process')
            ->setDescription(
                'Consume messages from bus and process raw documents'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->applicationService->execute();
    }
}
