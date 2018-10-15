<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Class SearchTextCommand
 * @package App\Command
 *
 * @author Pawel Kazmierczak <kazmij@gmail.com>
 */
class SearchTextCommand extends Command
{
    /**
     * The array of names to check if they are contained in the input text
     */
    const NAMES = [
        "Mary",
        "John"
    ];

    /**
     * Configure command settings
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('text:search-names')
            // configure an argument
            ->addArgument('text', InputArgument::REQUIRED, 'The text to search case insensitive "John" and "Mary" names')
            // the short description shown while running "php bin/console list"
            ->setDescription('Search for case insensitive "John" and "Mary" names in string parameter text. The command is looking only for whole words.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you search case insensitive names "John" and "Mary" in the entered text');
    }

    /**
     * Execute search names command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Set styles for command outputs
        $outputStyle = new OutputFormatterStyle('green', null, array('bold', 'blink'));
        $output->getFormatter()->setStyle('success', $outputStyle);
        //get input string and
        $text = $input->getArgument('text');
        //transform it to lower and trim spaces
        $text = strtolower(trim($text));
        //remove not needed chars from array
        $texts = array_map(function ($entry) {
            return preg_replace('/[\s\v\h\.,]/im', '', $entry);
        }, explode(' ', $text));
        //array to store number of names occurrences
        $occurrencesCount = [];
        //default result is 1
        $result = 1;

        foreach (self::NAMES as $key => $name) {
            //count number of occurrences $name in array
            $occurrencesCount[$key] = count(array_filter($texts, function($entry) use ($name){
                return $entry === strtolower($name);
            }));
            //Break if the occurrences count is different than previous. It does not sense to count it further.
            if ($key > 0 && $occurrencesCount[$key - 1] !== $occurrencesCount[$key]) {
                $result = 0;
                break;
            }
        }

        $output->writeln('<success>' . $result . '</success>');

        return 0;
    }
}