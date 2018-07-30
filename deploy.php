<?php
namespace Deployer;

require 'recipe/yii2-app-advanced.php';

// Project name
set('application', 'tt-dev');

// Project repository
set('repository', 'https://bitbucket.org/4938x8_tes-team/tt_backend.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys
add('shared_files', [
    'api/config/main-local.php',
    'api/config/params-local.php',
]);
add('shared_dirs', [
    'api/runtime',
]);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('tt-dev.local.net')
//    ->user('koputo')
//    ->set('deploy_path', '~/{{application}}');
    ->set('deploy_path', '/media/www/tt-dev.local.net');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

task('changeright', function() {
    run('cd {{deploy_path}} && chown -R -h -L www-data\: html && chmod -R g+w html');
});

after('success', 'changeright');
