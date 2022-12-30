<?php

use Cron\Cron;
use Cron\Executor\Executor;
use Cron\Job\ShellJob;
use Cron\Resolver\ArrayResolver;
use Cron\Schedule\CrontabSchedule;

require_once __DIR__ . '/../../vendor/autoload.php';

$job1 = new ShellJob();
$job1->setCommand('php app/src/Console/refresh.php');
$job1->setSchedule(new CrontabSchedule('31 11 * * *'));

$resolver = new ArrayResolver();
$resolver->addJob($job1);

$cron = new Cron();
$cron->setExecutor(new Executor());
$cron->setResolver($resolver);

echo "cron start";
$cron->run();