in `artisan` file

```php
$output = new Symfony\Component\Console\Output\ConsoleOutput;
$output->setVerbosity(100);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    $output
);

```
