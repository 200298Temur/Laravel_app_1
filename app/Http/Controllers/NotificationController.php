<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }
    public function index()
    {
        return view("notifications.index")->with([
            'notifications'=> auth()->user()->notifications()->paginate(10),
        ]);
    }

    public function read(DatabaseNotification $notification){
         $notification->markAsRead();
         return redirect()->back();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
