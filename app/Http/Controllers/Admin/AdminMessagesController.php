<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminMessagesController extends Controller
{
    /*
    status codes:
        1 -> active
        2 -> removed
    */
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $messages = DB::table('messages')
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $messages = $messages->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search = $request->input('search');
            $messages = $messages->whereRaw("messages.title LIKE '%$search%'");
        }
        $messages = $messages->get();
        $messagesCount = DB::table('messages')->count();

        $pageCount = ceil($messagesCount / $size);

        return view('admin.messages.list', [
            'messages'      => $messages,
            'page'          => $page,
            'pageSize'      => $size,
            'pageCount'     => ceil($messagesCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function view(Request $request, $id){
        $message = DB::table('messages')
            ->where('id', '=', $id)
            ->first();

        return view('admin.messages.view', [
            'message'        => $message,
        ]);
    }

    public function remove(Request $request, $id){
        DB::table('messages')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }
    public function recylce(Request $request, $id){
        DB::table('messages')->where('id', '=', $id)->update(['status' => 1]);
        return back();
    }

    public function newGet(Request $request, $recieverId=0){
        if($recieverId != 0){
            $reciever = DB::table('users')->where('id', $recieverId)->first();
            $reciever_name = $reciever->first_name . ' ' . $reciever->last_name;
            return view('admin.messages.new',[
                'reciever_name' => $reciever_name,
            ]);
        }else{
            return view('admin.messages.new',[
            ]);
        }
    }

    public function newPost(Request $request){
        $validator = $this->myNewMessageValidate($request);
        $oldInputs = $request->all();
        $oldInputs['recievers'] = json_decode($oldInputs['recievers']);

        if($validator->fails()){
            return view('admin.messages.new', [
                'oldInputs'                 => $oldInputs,
                'error_type'                => 'fail',
                ])->withErrors($validator);

        }else{
            foreach($oldInputs['recievers'] as $reciever){
                DB::table('messages')->insert([
                    'title'         => $request->input('title'),
                    'body'          => $request->input('body'),
                    'sender'        => Auth::user()->id,
                    'sender_name'   => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'reciever'      => $reciever->id,
                    'reciever_name' => $request->title,
                    'status'        => 1

                ]);
            }
            return redirect()->intended('admin/messages');
        }
    }
    public function myNewMessageValidate($request){
        $messages = [
            'title.*'                     => 'لطفا برای پیام خود یک عنوان انتخاب کنید',
            'body.*'                      => 'پیام باید متنی داشته باشد',
            'recievers.*'                 => 'پیام حداقل باید به یک نفر فرستاده شود',
        ];
        $rules = [
            'title'                       => 'required',
            'body'                        => 'required',
            'recievers'                   => 'required|not_in:[]',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

}