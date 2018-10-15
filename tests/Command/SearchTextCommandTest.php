<?php

namespace App\Tests\Command;

use App\Command\SearchTextCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SearchTextCommandTest
 * @package App\Tests\Command
 *
 * @author Pawel Kazmierczak <kazmij@gmail.com>
 */
class SearchTextCommandTest extends KernelTestCase
{

    public function testExecute(){

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new SearchTextCommand());

        $command = $application->find('text:search-names');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'text' => 'John and Merry got married 5 years ago. John is very happy that Mary is his wife. Mary is a teacher and loves her job.',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('1', $output);

        $commandTester->execute(array(
            'command' => $command->getName(),
            'text' => 'John and Merry got married 5 years ago. John is very happy that Mary is his wife. Mary is a teacher and loves her job. Johnny is a mechanic and also loves his job.',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('0', $output);
    }
}
