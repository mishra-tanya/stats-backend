<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\Notes;

class NotesController extends Controller
{
     // notes
    public function getNotes()
    {
        return $this->fetchAll(Notes::class, 'Notes fetched successfully');
    }
}
