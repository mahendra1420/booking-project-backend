<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'target' => 'required|string|in:all,customers,businesses,specific',
            'title'  => 'required|string|max:255',
            'body'   => 'required|string',
        ]);

        $target = $request->input('target');
        $title  = $request->input('title');
        $body   = $request->input('body');

        // TODO: dispatch notification job based on $target
        // e.g. NotifyAllUsersJob::dispatch($title, $body);

        return redirect()->back()->with('success', "Notification sent to [{$target}] successfully.");
    }
}
