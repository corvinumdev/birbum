<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use \App\Models\Event;
use App\Policies\EventPolicy;
use App\Models\User;
use \App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    // Las asignaciones de políticas para la aplicación.
    protected $policies = [
        Thread::class => ThreadPolicy::class,
        Event::class => EventPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    // Registra cualquier servicio de autenticación/autorización.
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
