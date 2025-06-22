<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db3\ContactMessages;

class ContactController extends Controller
{
    public function getContactMessages()
    {
        return $this->fetchAll(ContactMessages::class, 'Contact Message fetched successfully');
    }
}
