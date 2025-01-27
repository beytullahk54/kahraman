<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{

    public function __construct()
    {
        // Tüm işlemler için oturum kontrolü (giriş yapmış olma) zorunlu kılınır.
        $this->middleware('auth');
    }
    
    public function index($id)
    {
        return Message::where("room_id","=",$id)->with("user")->get();
    }
    public function sendMessage(Request $request,$id)
    {
        $message = Message::create([
            'body' => $request->body,
            'room_id' => $id,
            'user_name' => Auth::User()->first_name,
            'user_id' => Auth::id(), // Oturum açmış kullanıcının ID'sini ekler
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }
    
    public function room($id)
    {
        $user = Auth::user();
    
        // Odayı bul
        $room = Room::find($id);
        //return $user->id;
        //return $room;
        if (!$user->is_admin && (!$room || ($user->id !== $room->user_id && !$room->users()->where('user_id', $user->id)->exists()))) {
            // Yetkisiz erişim, 403 Forbidden hata sayfası göster
            abort(403, 'Bu odaya erişim yetkiniz yok.');
        }
    
        return Inertia::render('Dashboard/Room',["id"=>$id]);
    }

    public function getRooms()
    {

        $user = Auth::User();
        if($user->is_admin)
        {
            $rooms = Room::get();
        }else{
            $rooms = Room::where('user_id', $user->id)
            ->orWhereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        }
      
        return response()->json($rooms);
    }

    public function getRoomsUsers($room)
    {
        $allUsers = User::all();
        $roomUsers = User::whereHas('rooms', function($query) use ($room) {
            $query->where('room_id', $room);
        })->get();
    
        return response()->json([
            'allUsers' => $allUsers,
            'roomUsers' => $roomUsers
        ]);
    }
    
    public function getRoomAddUser(Request $request,$room)
    {
        $user = User::findOrFail($request->user_id);
        $user->rooms()->attach($room); // Kullanıcıyı odaya ekle
    
        return response()->json(['message' => 'User added to room']);
    }
    
    public function getRoomRemoveUser(Request $request,$room)
    {
        $user = User::findOrFail($request->user_id);
        $user->rooms()->detach($room); // Kullanıcıyı odadan çıkar
    
        return response()->json(['message' => 'User removed from room']);
    }

    public function addRoom()
    {
        try{

            $room = new Room();
            $room->user_id = Auth::user()->id;
            $room->save();
    
            return response()->json($room);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
