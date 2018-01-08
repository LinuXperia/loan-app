<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'customer.partial._loan_details', 'App\Http\ViewComposers\LoanDetailsComposer'
        );

        View::composer(
            'admin.layouts.partials._loanStatistics', 'App\Http\ViewComposers\LoanStatisticsComposer'
        );

        //admin sidebar view composer
        View::composer(
            'admin.layouts.partials.sidebar', 'App\Http\ViewComposers\SideBarComposer'
        );

        //agent sidebar view composer
        View::composer(
            'agent.layout.partials._statistics', 'App\Http\ViewComposers\AgentStatisticsComposer'
        );

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}