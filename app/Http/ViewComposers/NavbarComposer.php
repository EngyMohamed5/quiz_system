<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Topic;
use Illuminate\Support\Facades\Cache;

class NavbarComposer
{
    // Bind data to the view.


    public function compose(View $view)
    {
        
        // $topics = Cache::remember('topics', 30 , function () {
        //     return Topic::all();
        // });
        $topics = Topic::all();
        $view->with('topics', $topics);
    }
}


?>