<?php

namespace App\Tests\Command;

use App\Command\SearchTextCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SortProductsCommandTest
 * @package App\Tests\Command
 *
 * @author Pawel Kazmierczak <kazmij@gmail.com>
 */
class SortProductsCommandTest extends KernelTestCase
{

    public function testExecute(){

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new SearchTextCommand());

        $command = $application->find('products:sort');
        $commandTester = new CommandTester($command);
        $productsJson = '[{"title":"H&M T-Shirt White","price":10.99,"inventory":10},{"title":"Magento Enterprise License","price":1999.99,"inventory":9999},{"title":"iPad 4 Mini","price":500.01,"inventory":2},{"title":"iPad Pro","price":990.2,"inventory":2},{"title":"Garmin Fenix 5","price":789.67,"inventory":34},{"title":"Garmin Fenix 3 HR Sapphire Performer Bundle","price":789.67,"inventory":12}]';

        $commandTester->execute(array(
            'command' => $command->getName(),
            'products' => $productsJson
        ));

        $resultJson = '[{"title":"h&m t-shirt white","price":10.99,"inventory":10},{"title":"ipad 4 mini","price":500.01,"inventory":2},{"title":"garmin fenix 3 hr sapphire performer bundle","price":789.67,"inventory":12},{"title":"garmin fenix 5","price":789.67,"inventory":34},{"title":"ipad pro","price":990.2,"inventory":2},{"title":"magento enterprise license","price":1999.99,"inventory":9999}]';

        $output = $commandTester->getDisplay();
        $this->assertContains($resultJson, $output);
    }
}
