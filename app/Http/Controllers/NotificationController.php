<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    private $connectionLabels = [
    'mysql'  => 'indiaesg',
    'mysql2' => 'scr',
    'mysql3' => 'olympiad',
    ];

    public function getContactMessages()
    {
        $connections = ['mysql2', 'mysql3'];
        $allMessages = [];

        foreach ($connections as $conn) {
            try {
                $tableName = null;
                if (Schema::connection($conn)->hasTable('contact_messages')) {
                    $tableName = 'contact_messages';
                } elseif (Schema::connection($conn)->hasTable('contacts')) {
                    $tableName = 'contacts';
                } else {
                    continue; 
                }

                $msgs = DB::connection($conn)->table($tableName)
                    ->select('id','name', 'email', 'subject', 'message', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(fn($m) => [
                        'id'        => "contact_{$conn}_{$m->id}",
                        'title'     => "New message from {$m->email}  ({$this->connectionLabels[$conn]})",
                        'message'   => $m->message,
                        'timestamp' => Carbon::parse($m->created_at)->diffForHumans(),
                        'type'      => 'info',
                        'read'      => false,
                    ])->toArray();

                $allMessages = array_merge($allMessages, $msgs);
            } catch (\Exception $e) {
                \Log::error("Error fetching messages from {$conn}: " . $e->getMessage());
                continue;
            }
        }

        return $this->handleSuccess($allMessages, 'Fetched contact messages');
    }

    public function getMilestoneNotifications()
    {
        $connections = ['mysql2', 'mysql3'];
        $milestones = [10, 50, 100, 500, 1000, 5000];
        $notifications = [];

        foreach ($connections as $conn) {
            try {
                $tableName = null;
                if (Schema::connection($conn)->hasTable('reg_users')) {
                    $tableName = 'reg_users';
                } elseif (Schema::connection($conn)->hasTable('users')) {
                    $tableName = 'users';
                } else {
                    continue;
                }

                $count = DB::connection($conn)->table($tableName)->count();

                $maxMilestone = null;
                foreach ($milestones as $milestone) {
                    if ($count >= $milestone) {
                        $maxMilestone = $milestone;
                    }
                }

                if ($maxMilestone !== null) {
                    $notifications[] = [
                        'milestone'   => $maxMilestone,
                        'connection'  => $this->connectionLabels[$conn],
                        'description' => "Reached $maxMilestone successful users on {$this->connectionLabels[$conn]}!",
                    ];
                }

            } catch (\Exception $e) {
                \Log::error("Milestone check failed for connection {$conn}: " . $e->getMessage());
                continue;
            }
        }

        return $this->handleSuccess($notifications, 'Milestones reached');
    }

}
