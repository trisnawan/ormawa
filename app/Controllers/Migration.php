<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\MigrationRunner;
use Config\Migrations;

class Migration extends BaseController
{
    public function index()
    {
        $config = new Migrations();
        $migration = new MigrationRunner($config);
        $migration->latest();

        $seeder = \Config\Database::seeder();
        $seeder->call('UsersSeeder');
        return 'Migration & Seeder successfully!';
    }
}
