<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class GetContactController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'phone' => optional(Contact::where('type', 'phone')->first())->value,
            'email' => optional(Contact::where('type', 'email')->first())->value,
            'address' => optional(Contact::where('type', 'address')->first())->value,
            'work_hours' => optional(Contact::where('type', 'time')->first())->value,
        ]);
    }
}
