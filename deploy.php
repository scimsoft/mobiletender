<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'PlayaAltaPos');

// Project repository
set('repository', 'https://github.com/scimsoft/mobiletender.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['nodeprinterbridge.js']);
add('shared_dirs', []);

// Writable dirs by Web server 
add('writable_dirs', []);


// Hosts

host(demo)
    ->hostname('demo.playaalta.com')
    ->set('deploy_path', '/var/www/mobiletender');

host(bar)
    ->hostname('bar.playaalta.com')
    ->set('deploy_path', '/var/www/bar');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

