<?php

namespace Deployer;

require 'recipe/common.php';
require 'recipe/laravel.php';
require 'contrib/crontab.php';

// Config

set('git_tty', true);
set('git_ssh_command', 'ssh'); // Fix unsupported option "accept-new" (OpenSSH version older than v7.6)
set('repository', 'git@github.com:mgkprod/magenta-database');
add('crontab:jobs', ['* * * * * cd {{current_path}} && {{bin/php}} artisan schedule:run >> /dev/null 2>&1']);

// Hosts

host('o2switch/magenta-database')
    ->set('remote_user', 'mgkprod')
    ->set('deploy_path', '~/magenta-database.mgk.dev')
    ->set('http_user', 'mgkprod')
    ->set('writable_mode', 'chown')
    ->set('crontab:identifier', 'magenta-database')
    ->setLabels(['env' => 'production']);

host('o2switch/distractions-database')
    ->set('remote_user', 'mgkprod')
    ->set('deploy_path', '~/distractions-database.mgk.dev')
    ->set('http_user', 'mgkprod')
    ->set('writable_mode', 'chown')
    ->set('crontab:identifier', 'distractions-database')
    ->setLabels(['env' => 'production']);

// Hooks

task('npm:ci', function () {
    cd('{{release_path}}');
    run('npm ci');
});

task('npm:build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:vendors', 'npm:ci');
after('npm:ci', 'npm:build');
after('deploy:failed', 'deploy:unlock');
after('deploy:success', 'crontab:sync');
