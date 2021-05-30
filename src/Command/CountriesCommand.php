<?php

namespace App\Command;

use App\Message\CountryAddMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class CountriesCommand extends Command
{
    protected static $defaultName = 'app:countries';
    protected static $defaultDescription = 'Command to add countries';

    private MessageBusInterface $messageBus;

    public function __construct(string $name = null, MessageBusInterface $messageBus)
    {
        parent::__construct($name);
        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::REQUIRED, 'Country name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed a country: %s', $arg1));
        }

        $this->messageBus->dispatch(new CountryAddMessage($arg1));

        $io->success('Country added');

        return Command::SUCCESS;
    }
}
