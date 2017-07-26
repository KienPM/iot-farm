<?php
use Rocketeer\Facades\Rocketeer;

Rocketeer::addTaskListeners('deploy', 'before-symlink', function ($task) {
    $task->runForCurrentRelease('npm install');
    $task->runForCurrentRelease('npm run dev');
    $task->runForCurrentRelease('php artisan migrate --seed --force');
    $task->runForCurrentRelease('php artisan storage:link');
    $task->runForCurrentRelease('forever stopall');
    $task->runForCurrentRelease('forever start server.js');
});
