<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\App;

class loginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /*dd($event);
        if (!$event->user->isAdmin()){
            Auth::setProvider(new EloquentUserProvider(App::make('hash'), 'App\Models\PublicUser'));
        }else {
            Auth::setProvider(new EloquentUserProvider(App::make('hash'), 'App\Models\Admin'));
        }*/

    }
}
