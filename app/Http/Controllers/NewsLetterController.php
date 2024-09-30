<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsLetter\NewsLetterCreateRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsLetterController extends Controller
{
    public function store(NewsLetterCreateRequest $request)
    {
        try {
            $email = $request->email;
            $existingNewsLetter = Newsletter::where('email', $email)->first();
            if ($existingNewsLetter) {
                return back()->with('error', 'This Email has already been Added!');
            }

            $newsletter = DB::transaction(function() use($email) {
                $newsletter = Newsletter::create([
                    'email' => $email,
                ]);
                return $newsletter;
            });
            if ($newsletter) {
                return back()->with('success', 'You have been added to NewsLetter!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
