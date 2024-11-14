<?php
namespace App\Listeners;

use App\Events\MovieDataReceived;
use App\Models\User; // User model
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SyncUserData implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(MovieDataReceived $event): void
    {
        // Extract user data from the event
        $data = json_decode($event->data);

        // Update or create the user record based on the user_id
        User::updateOrCreate(['user_id' => $data->user_id], [
            'user_id' => $data->user_id,
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password), // Make sure to hash the password before saving it
            'phone' => $data->phone,
            // Add any other user data fields you need to sync
        ]);

        Log::info('User data synchronized: ' . $data->user_id);
    }
}
