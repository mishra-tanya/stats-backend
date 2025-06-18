<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function getContactMessages()
    {
        $connections = ['mysql_site1', 'mysql_site2', 'mysql_site3'];
        $allMessages = [];

        foreach ($connections as $conn) {
            $msgs = DB::connection($conn)->table('contact_messages')
                ->select('id','name', 'email', 'subject', 'message', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(fn($m) => [
                    'id'        => "contact_{$conn}_{$m->id}",
                    'title'     => "New message from {$m->email}",
                    'message'   => $m->message,
                    'timestamp' => \Carbon\Carbon::parse($m->created_at)->diffForHumans(),
                    'type'      => 'info',
                    'read'      => false,
                ])->toArray();

            $allMessages = array_merge($allMessages, $msgs);
        }
        return $this->handleSuccess($data, 'Fetched contact messages');
    }

    public function getMilestoneNotifications()
    {
        $connections = ['mysql_site1', 'mysql_site2', 'mysql_site3', 'mysql_site4'];
        $milestones = [10, 50, 100, 500, 1000, 5000];
        $notifications = [];

        foreach ($connections as $conn) {
            $users = DB::connection($conn)->table('users')
                ->where('payment_status', 1) 
                ->orderBy('created_at', 'asc')
                ->get();

            $count = $users->count();

            foreach ($milestones as $milestone) {
                if ($count >= $milestone) {
                    $notificationExists = DB::table('payment_notifications')
                        ->where('milestone', $milestone)
                        ->where('email', $users[$milestone - 1]->email)
                        ->exists();

                    if (!$notificationExists) {
                        $user = $users[$milestone - 1];
                        $notifiedAt = Carbon::parse($user->created_at);

                        DB::table('payment_notifications')->insert([
                            'milestone' => $milestone,
                            'email' => $user->email,
                            'notified_at' => $notifiedAt,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                        $notifications[] = [
                            'title' => "🎉 $milestone users milestone reached!",
                            'description' => "We’ve reached $milestone successful payments on {$conn}!",
                            'email' => $user->email,
                            'time_ago' => $notifiedAt->diffForHumans()
                        ];
                    }
                }
            }
        }
        return $this->handleSuccess($data, 'Milestone notifications fetched');
    }
}
