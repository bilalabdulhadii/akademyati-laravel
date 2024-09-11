<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\CourseVersion;
use App\Models\ReviewVersion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.components.header', function ($view) {
            $pendingReviews = ReviewVersion::where('status', 'pending')
                ->orderBy('updated_at', 'desc')
                ->get();
            $contactNewMessages = Contact::where('has_message', true)
                ->where('user_id', Auth::id())
                ->orderBy('updated_at', 'desc')
                ->get();
            foreach ($contactNewMessages as $contactNewMessage) {
                $contactNewMessage->formated_time = $this->formatMessageDate($contactNewMessage->updated_at);
            }
            $view->with([
                'pendingReviews' => $pendingReviews,
                'contactNewMessages' => $contactNewMessages,
            ]);
        });

        View::composer('instructor.components.header', function ($view) {
            $acceptedVersions = ReviewVersion::where('status', 'accepted')
                ->orderBy('updated_at', 'desc')
                ->get();

            $contactNewMessages = Contact::where('has_message', true)
                ->where('user_id', Auth::id())
                ->orderBy('updated_at', 'desc')
                ->get();
            foreach ($contactNewMessages as $contactNewMessage) {
                $contactNewMessage->formated_time = $this->formatMessageDate($contactNewMessage->updated_at);
            }
            $view->with([
                'contactNewMessages'=> $contactNewMessages,
                'acceptedVersions' => $acceptedVersions
            ]);
        });

        View::composer('home.components.header', function ($view) {
            $categoriesList = Category::where('level', 1)
                ->with('children')
                ->limit(6)
                ->get();
            $view->with('categoriesList', $categoriesList);
        });
    }

    public function formatMessageDate($date)
    {
        $now = Carbon::now();
        $createdAt = Carbon::parse($date);

        if ($createdAt->isToday()) {
            return $createdAt->format('H:i');
        } elseif ($createdAt->isYesterday()) {
            return 'Yesterday';
        } elseif ($createdAt->year == $now->year) {
            return $createdAt->format('d M'); // Example: 18 May
        } else {
            return $createdAt->format('d.m.Y'); // Example: 18.05.2024
        }
    }
}
