<?php
declare(strict_types=1);

namespace Falgun\Console\Tests;

use Falgun\Console\Application;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{

    public function testConsoleApp()
    {
        $application = new Application('falguncli', 'v0.0.1');
        $application->registerCommands([Commands\LsCommand::class]);

        $this->assertEquals($application->getCommands(), ['ls' => Commands\LsCommand::class]);

        $output = $application->execute(
            [
                'test.php', 'ls', 'name', 'Ataur', 'age', 10
            ]
        );

        $this->assertEquals(['name' => 'Ataur', 'age' => 10], $output);

        $output = $application->execute(
            [
                'test.php', 'ls', 'name', 'Ataur'
            ]
        );

        $this->assertEquals(['name' => 'Ataur', 'age' => 10], $output);

        try {

            $application->execute(['test.php', 'ls', 'age', 15]);
            $this->fail('required arg validation failed');
        } catch (\Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'name is required but not given.');
        }
    }
}
