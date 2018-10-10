<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;
use Hashids\Hashids;
use Log;

class EmailController extends Controller
{


    protected $savedHashids=array();
    protected $unsavedHashids=array();

    /*get me all mails where receiver is auth user,
    where draft is false,
    where trashed by auth user is false
    where permanently deleted by auth user is false
    */
    public function inbox()
    {
        return view('admin/mail/index')
            ->with('emails', Email::where('receiver', Auth::id())
                ->where('is_draft', 0)
                ->where('trash_receiver', 0)
                ->where('killed_receiver',0)
                ->orderBy('updated_at', 'desc')
                ->paginate(10))
            ->with('page_name', 'Inbox');
    }

    /*get me all mails where sender is auth user,
    where draft is false,
    where trashed by auth user is false
    where permanently deleted by auth user is false
    */
    public function sent()
    {
        return view('admin/mail/index')
            ->with('emails', Email::where('sender', Auth::id())
                ->where('is_draft', 0)
                ->where('trash_sender', 0)
                ->where('killed_sender',0)
                ->orderBy('updated_at', 'desc')
                ->paginate(10))
            ->with('page_name', 'Sent');
    }

    /*get me all mails where sender is auth user,
    where draft is true,
    where trashed by auth user is false
    where permanently deleted by auth user is false
    */
    public function drafts()
    {
        return view('admin/mail/index')
            ->with('emails', Email::where('sender', Auth::id())
                ->where('is_draft', 1)
                ->where('trash_sender', 0)
                ->where('killed_sender',0)
                ->orderBy('updated_at', 'desc')
                ->paginate(10))

            ->with('page_name', 'Drafts');
    }

    /*get me all mails which where trash_receiver by auth user and trash_sender by auth user, but not permanently deleted
    by auth user
    When trashed by receiver or sender, Auth::id() needs to be inserted in the table cell
    */
    public function trash()
    {
       $emails=Email::where([
            ['trash_sender', Auth::id()],
            ['killed_sender', 0]
            ])
           ->orWhere([
               ['trash_receiver', Auth::id()],
               ['killed_receiver', 0],
           ])->paginate(10);
        //dd($emails);

        return view('admin/mail/index')
            ->with('emails', $emails)
            ->with('page_name', 'Trash');
    }

    //search by email title, by page (inbox, sent, drafts, trash)
    public function search(Request $request){
        //dd($request->all());
        $this->validate($request, [
            'search'=>'required|string',
            'page_name'=>'required|string'
        ]);

        switch ($request->page_name) {
            case "Inbox":
                $emails=Email::where([
                    ['receiver', Auth::id()],
                    ['killed_receiver', 0],
                    ['trash_receiver', 0],
                    ['title', 'like', '%'.$request->search.'%']
                ])
                    ->orderBy('updated_at', 'desc')
                    ->paginate(10);
                break;
            break;

            case "Sent":
                $emails=Email::where([
                    ['sender', Auth::id()],
                    ['killed_sender', 0],
                    ['trash_sender', 0],
                    ['is_draft', 0],
                    ['title', 'like', '%'.$request->search.'%']
                ])
                    ->orderBy('updated_at', 'desc')
                    ->paginate(10);
                break;

            case "Drafts":
                $emails=Email::where([
                    ['sender', Auth::id()],
                    ['killed_sender', 0],
                    ['trash_sender', 0],
                    ['is_draft', 1],
                    ['title', 'like', '%'.$request->search.'%']
                ])
                    ->orderBy('updated_at', 'desc')
                    ->paginate(10);
            break;

            case "Trash":
                $emails=Email::where([
                    ['trash_sender', Auth::id()],
                    ['killed_sender', 0],
                    ['title', 'like', '%'.$request->search.'%']
                ])
                    ->orWhere([
                        ['trash_receiver', Auth::id()],
                        ['killed_receiver', 0],
                        ['title', 'like', '%'.$request->search.'%']
                    ])->paginate(10);
        }

//return emails according to query, content put in search field, page_show=page from where request was sent (inbox, sent...)
//and name of the page
        return view('admin/mail/index')
            ->with('emails', $emails)
            ->with('query', $request->search)
            ->with('page_from', $request->page_name)
            ->with('page_name', 'Search results');
    }

    public function compose()
    {
        return view('admin/mail/compose')->with('users', User::whereIn('role_id', [2, 3, 4])->get());
    }

/* receives request from compose new mail, edit draft mail, reply, forward. it saves email to drafts(is_draft=true)
    or sends email (is_draft=false)
*/
    public function store(Request $request)
    {

        //dd($request);
        //check if request has send email or save to drafts
        $receiver="";
        if($request->has('send') || $request->has('save')){

            //check if user exists(only for send) and if it is valid
            if($request->receiver !==null){
                $receiver = User::where('hashid', $request->receiver)->first()->id;
                if(!$receiver) {
                    //something was touched in html for user's hashid
                    return redirect()->back();
                }
            }

            //check if email came from edited email or is it new email
            if(request()->has('hashid')){
                $email=Email::where('hashid', request()->hashid)->first();
                if($email->sender !== Auth::id() || $email->is_draft==false){
                    //input hidden was changed. user can edit only his emails and emails that are drafts
                    return redirect()->back();
                }
                if(!$email) {
                    //something was changed in html for email's hashid
                    return redirect()->back();
                }
            }else{
                $email=new Email();
                $lastId=Email::count() ? Email::latest()->first()->id : 0;
                $hashids = new Hashids('email', 10);
                $hash_id=$hashids->encode($lastId+1);
                $email->hashid=$hash_id;
            }


            //check for send email to have receiver, title and body. save to drafts doesn't need any
        if(request()->has('send')){
            $this->validate($request, [
                'receiver' => 'required|string',
                'title' => 'required|string',
                'body' => 'required|string',
            ]);
            $email->is_draft=false;
            if($request->receiver===Auth::id()){
                Session::flash('error', 'You can\'t send email to yourself!');
                return redirect()->back();
            }
        }
            $message=$request->has('save') ? 'saved' : 'sent';
            $email->sender = Auth::id();
            $email->receiver = $receiver ? $receiver : null;
            $email->title = $request->title ? $request->title : null;
            $email->body = $request->body ? $request->body : null;
            if($request->has('save')){
                $email->is_draft=true;
            }



            if ($email->save()) {
                Session::flash('success', "Email ".$message." successfully!");
            } else {
                Session::flash('error','Something went wrong!');
            }
            return redirect()->route('email.inbox');

        }else{
            //something was messed with html
            return redirect()->back();
        }


    }



    public function show($hashid)
    {
        $email=Email::where('hashid', $hashid)->first();

        //auth user can read email only if he is sender or receiver
        if($email->sender === Auth::id() || $email->receiver === Auth::id()){

            //if receiver is reading received email and email was not read before, update to read
            if($email->receiver===Auth::id() && $email->was_read===0){
                $email->was_read=true;
                $email->save();
            }
            return view('admin.mail.show')->with('email', $email)->with('users', User::whereIn('role_id', [2, 3, 4])->get());
        }else{
            return redirect()->back();
        }

    }


    public function edit($hashid)
    {
        $draft_email=Email::where('hashid', $hashid)->first();
        if($draft_email->sender !== Auth::id() || $draft_email->is_draft==0){
            Session::flash('error','You can not edit this email');
            return redirect()->back();
        }else{
            $users=User::whereIn('role_id', [2, 3, 4])->get();
           // dd($draft_email);
            return view('admin.mail.edit')->with('draft_email', $draft_email)->with('users', $users);
        }
    }

    public function favorite(Request $request, $hashid){
        $email=Email::where('hashid', $hashid)->first();

        if($email->sender===Auth::id()){
            if($email->important_sender){
                $email->important_sender=false;
            }else{
                $email->important_sender=true;
            }
            $email->save(['timestamps' => false]);
            return response()->json(['success'=>$email->hashid]);

        }elseif($email->receiver===Auth::id()){
            if($email->important_receiver){
                $email->important_receiver=false;
            }else{
                $email->important_receiver=true;
            }
            $email->save(['timestamps' => false]);
            return response()->json(['success'=>$email->hashid]);

        }else{
            return response()->json(['error'=>'Something went wrong']);
        }


    }
//receives page_name and array of hashids to be deleted
    public function delete(Request $request)
    {

        $hashids=explode(",",$request->hashids);

        for($i=0; $i<count($hashids); $i++){
            //delete each row = give it trash_sender=true or trash_receiver=true, depending on Auth::id()
            $email=Email::where('hashid', $hashids[$i])->first();
            if($email->sender===Auth::id()){
                $email->trash_sender=Auth::id();
            }elseif($email->receiver===Auth::id()){
                $email->trash_receiver=Auth::id();
            }
            $this->saveChangedHashids($email);

        }

        if(count($this->savedHashids) > 0 && count($this->unsavedHashids)===0){
            return response()->json(['success',$this->savedHashids]);
        }else{
            return response()->json(['success'=>$this->savedHashids, 'error'=>$this->unsavedHashids]);
        }
    }

    //restores deleted emails
    public function restore(Request $request)
    {

        $hashids=explode(",",$request->hashids);
        //emails are restored by user who deleted them

            for($i=0; $i<count($hashids); $i++){
                //delete each row = give it trash_sender=true
                $email=Email::where('hashid', $hashids[$i])->first();
                if($email->trash_receiver===Auth::id()){
                    $email->trash_receiver=false;
                    $this->saveChangedHashids($email);
                }elseif($email->trash_sender===Auth::id()){
                    $email->trash_sender=false;
                    $this->saveChangedHashids($email);
                }else{
                    //provided email hashid doesn't belong to auth user
                    return redirect()->back();
                }

            }



        if(count($this->savedHashids) > 0 && count($this->unsavedHashids)===0){
            return response()->json(['success',$this->savedHashids]);
        }else{
            return response()->json(['success'=>$this->savedHashids, 'error'=>$this->unsavedHashids]);
        }
    }

    protected function saveChangedHashids($email){

        if($email->save()){
            $this->savedHashids[]=$email->hashid;
        }else{
            $this->unsavedHashids[]=$email->hashid;
        }

    }



    public function reply($hashid){
        return view('admin.mail.reply')
            ->with('email', Email::where('hashid',$hashid)->first())
            ->with('page_name', 'Reply page');
    }

    public function forward($hashid){
        return view('admin.mail.reply')
            ->with('email', Email::where('hashid',$hashid)->first())
            ->with('users', User::whereIn('role_id', [2, 3, 4])->get())
            ->with('page_name', 'Forward page');

    }

//permanently deletes emails from trash page
    public function destroy(Request $request)
    {

        $hashids=explode(",",$request->hashids);
        //emails are restored by user who deleted them

        for($i=0; $i<count($hashids); $i++){
            //delete each row = give it trash_sender=true
            $email=Email::where('hashid', $hashids[$i])->first();
            if($email->trash_receiver===Auth::id()){
                $email->killed_receiver=true;
                $this->saveChangedHashids($email);
            }elseif($email->trash_sender===Auth::id()){
                $email->killed_sender=true;
                $this->saveChangedHashids($email);
            }else{
                //provided email hashid doesn't belong to auth user
                return redirect()->back();
            }
            //if both sender and receiver have permanently deleted email, then remove it from DB
            if($email->killed_sender && $email->killed_receiver){
                $email->delete();
            }

        }

        if(count($this->savedHashids) > 0 && count($this->unsavedHashids)===0){
            return response()->json(['success',$this->savedHashids]);
        }else{
            return response()->json(['success'=>$this->savedHashids, 'error'=>$this->unsavedHashids]);
        }
    }


}
