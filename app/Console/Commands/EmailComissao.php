<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class EmailComissao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:comissao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia os e-mails com as comissões do dia';

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
     * @return mixed
     */
    public function handle()
    {
        $comissaoController = new ComissaoController();
        $comissaoController->sendEmail();
    }
}
