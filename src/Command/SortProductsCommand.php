<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Class SortProductsCommand
 * @package App\Command
 *
 * @author Pawel Kazmierczak <kazmij@gmail.com>
 */
class SortProductsCommand extends Command
{

    /**
     * Configure products sorter command
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('products:sort')
            // configure an argument
            ->addArgument('products', InputArgument::REQUIRED, 'The products JSON string')
            // the short description shown while running "php bin/console list"
            ->setDescription('Sort products by a specific field with a specific order. In the default by price and ascending.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to sort products by a specific field with a specific order. In the default by price and ascending.');
    }

    /**
     * Execute products sorter command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Set commands output styles
        $outputErrorStyle = new OutputFormatterStyle('red', null, array('bold', 'blink'));
        $outputSuccessStyle = new OutputFormatterStyle('green', null, array('bold', 'blink'));
        $output->getFormatter()->setStyle('success', $outputSuccessStyle);
        $output->getFormatter()->setStyle('error', $outputErrorStyle);

        //get and parse products json to array
        $productsJson = strtolower($input->getArgument('products'));
        $productsArray = json_decode($productsJson, true);

        //if it is not valid JSON string then show error message
        if (json_last_error()) {
            $output->writeln("<error>It is not valid JSON string: " . json_last_error_msg() . "</error>");
        } else {
            //get prices from multi-array - will be needed to sort by them
            $prices = array_map(function ($entry) {
                if (isset($entry['price'])) {
                    //make sure if it is numeric value
                    return (float)$entry['price'];
                } else { //set to 0 if price does not exist or is null
                    return 0;
                }
            }, $productsArray);

            //get titles from multi-array - will be needed to sort by them
            $titles = array_map(function ($entry) {
                //if exists and is not empty return this title
                if (isset($entry['title'])) {
                    return $entry['title'];
                } else { //otherwise return empty string
                    return '';
                }
            }, $productsArray);

            //Sort products by prices (as numbers and ascending) and then by titles (as strings and in the same ascending sequence)
            array_multisort($prices, SORT_NUMERIC, SORT_ASC, $titles, SORT_STRING, SORT_ASC, $productsArray);

            //Show result array (JSON string)
            $output->writeln("<success>Result JSON string:</success>");
            $output->writeln(json_encode($productsArray));
        }

        return 0;
    }
}