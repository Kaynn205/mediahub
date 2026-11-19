<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnvoyerEmailBienvenue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function handle(): void
    {
        Mail::raw(
            " Bienvenue sur MediaHub , { $this -> user -> name } !",
            function ($message) {
                $message->to($this->user->email)
                    ->subject('Bienvenue sur MediaHub');
            }
        );
    }
}