<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Str;

class EmprestimoExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->jobId = Str::uuid();

        Log::info("Job created");
    }

    /**
     * 
     *
     * @return void
     */
    public function handle()
    {

        if ($this->shouldCancel()) {
            return;
        }
        Log::info("Job executed");

        //envia um email para o usuario informando que o emprestimo expirou 

        //seta o emprestimo como expirado e da a punição 
    }

    private function shouldCancel()
    {
        //adicionar uma logica para verificar se o job deveria ser cancelado, 
        //pois não é possivel cancelar um job, pois não tem como acessar o job pelo id

        //adicionar uma informação que leve ao emprestimo, para verificar se o emprestimo foi concluido e não deve enviar o job
        return false;
    }
}
