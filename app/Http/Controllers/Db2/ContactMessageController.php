<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\ContactMessages;

class ContactMessageController extends Controller
{
    // users messages
    public function getContactMessages()
    {
        return $this->fetchAll(ContactMessages::class, 'Contact messages fetched successfully');
    }
}
