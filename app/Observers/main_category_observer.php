<?php

namespace App\Observers;

use App\Models\main_categories;

class main_category_observer
{
    /**
     * Handle the main_categories "created" event.
     *
     * @param  \App\Models\main_categories  $main_categories
     * @return void
     */
    public function created(main_categories $main_categories)
    {
        //
    }

    /**
     * Handle the main_categories "updated" event.
     *
     * @param  \App\Models\main_categories  $main_categories
     * @return void
     */
    public function updated(main_categories $main_categories)
    {
        $main_categories ->vendor()->update(['active' => $main_categories->active]);
    }

    /**
     * Handle the main_categories "deleted" event.
     *
     * @param  \App\Models\main_categories  $main_categories
     * @return void
     */
    public function deleted(main_categories $main_categories)
    {
        //
    }

    /**
     * Handle the main_categories "restored" event.
     *
     * @param  \App\Models\main_categories  $main_categories
     * @return void
     */
    public function restored(main_categories $main_categories)
    {
        //
    }

    /**
     * Handle the main_categories "force deleted" event.
     *
     * @param  \App\Models\main_categories  $main_categories
     * @return void
     */
    public function forceDeleted(main_categories $main_categories)
    {
        //
    }
}
