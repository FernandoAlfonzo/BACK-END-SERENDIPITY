<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function dataTicket(Request $request) 
    {
        $data['image'] = $request->image->store('');
    }
}
