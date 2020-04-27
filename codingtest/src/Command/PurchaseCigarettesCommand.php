<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount = (float)\str_replace(',', '.', $input->getArgument('amount'));

        $coins = array(500, 200, 100, 50, 20, 10, 5, 2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01);

        $change = $amount - $itemCount * CigaretteMachine::ITEM_PRICE;
        if ($change < 0) {
            $output->writeln('There is less money given than total cost of amount');
            return;
        }

        $output->writeln('You bought <info>'. $itemCount .'</info> packs of cigarettes for <info>'. $amount .'</info>, each for <info>'.CigaretteMachine::ITEM_PRICE.'</info>. ');
        $output->writeln('Your change is: '.$change);

        $table_array = [];

        foreach($coins as $i => $item) {
            $count_value = bcdiv($change, $coins[$i],2);

            if ($count_value >= 1) {
                array_push($table_array, array((int)$count_value, $coins[$i]));
                $change -= $coins[$i];
            }
        }

        $table = new Table($output);
        $table
            ->setHeaders(array('Count', 'Coins'))
            ->setRows($table_array)
        ;
        $table->render();

    }
}