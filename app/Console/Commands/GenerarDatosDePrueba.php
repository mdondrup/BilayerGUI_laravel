<?php

namespace App\Console\Commands;

use App\Ion;
use App\Lipido;
use App\Peptido;
use App\Trayectoria;
use App\TrayectoriasIones;
use App\TrayectoriasLipidos;
use App\TrayectoriasPeptidos;
use App\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class GenerarDatosDePrueba extends Command
{
    const INICIO_ID = 1;
    const FIN_ID = 50;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sample-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sample data for testing purposes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        factory(Lipido::class, 50)->create();
        factory(Ion::class, 50)->create();
        factory(Trayectoria::class, 50)->create();
        factory(TrayectoriasLipidos::class, 50)->create();
        factory(TrayectoriasIones::class, 50)->create();
    }
}