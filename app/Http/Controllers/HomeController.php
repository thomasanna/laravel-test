<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use DataTables;
use App\Helpers\HtmlHelper;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{  
    protected $title = 'Users';
    protected $link = 'home';
    protected $password = '12345678';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function lists(Request $request)
    {
        $detail = User::select(['first_name', 'last_name', 'email','phone','gender','id']);
       
        if (isset($request->form)) {
            foreach ($request->form as $search) {
                if ($search['value'] != NULL && $search['name'] == 'search_name') {
                    $names = strtolower($search['value']);
                    $detail->where(function($query) use ($names) {
                         $query->whereRaw("concat(first_name, ' ', last_name) like ?", ['%'.$names.'%'])
                         ->orWhereRaw("concat(last_name, ' ', first_name) like ?", ['%'.$names.'%'])
                         ->orWhere("email","like", '%'.$names.'%')
                         ->orWhere("phone","like", '%'.$names.'%');
                    });
                }
            }
        }
        
        $detail = $detail->whereHas("roles", function($q) use($request) { 
            $q->where("name","<>","superadmin");
            if($request->has('role') && $request->role != '')
                $q->where("name",$request->role); 
        });
        $detail->orderBy('id', 'desc');
        return DataTables::of($detail)
            ->addIndexColumn()
            ->editColumn('gender',function($detail)
            {
                return $detail->gender_text;
            })

            ->addColumn('action', function ($detail) {
                $action = '';
                $edit_url = url('users/' . $detail->id . '/edit');
                $action .= HtmlHelper::editButton($edit_url);
                $action .= HtmlHelper::deleteButton($detail->id);
                return $action;
            })
            
            ->removeColumn('id')
            ->escapeColumns([])
            ->make(false);
    }

         /**
     * Show the form for create the specified resource.
     */
    public function create()
    {
        $page = collect();
        $page->title = $this->title;
        $page->link = url($this->link);
        $page->form_url = url('users/store');
        $page->form_method = 'POST';

        return view('user_manage', compact('page'));
    }

    public function edit($id)
    {
        if(!$id || !$user = User::find($id))
        {
                return redirect('users')->with('message', 'Not found');
        }
        $page = collect();
        $page->title = $this->title;
        $page->link = url($this->link);
        $page->form_url = url('users/update/' . $user->id);
        $page->form_method = 'PUT';

        return view('user_manage', compact('page', 'user'));
    }


        /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'gender' => 'required',
        ];
        
        $request->validate($rules);
        $user = new User();

        $this->saveDB($user, $request);
        $message = 'Created Successfully';
        $url = url($this->link);
        $error = false;
        return compact('error', 'message', 'url');
    }


        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

         $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
        ];
        if($id)
        {
            $rules['email'] = 'required|unique:users,email,'.$id;
        }
        
        $request->validate($rules);

        if($id && !$user = User::find($id))
        {
                return redirect('home')->with('message', 'Not found');
        }
        
        $this->saveDB($user, $request);

        $url = url($this->link);
        $error = false;
        $message = Str::singular(Str::title($this->title)) . ' saved successfully';
        return compact('error', 'message', 'url');
    }


    /**
     * @param $table
     * @param $request
     */
    public function saveDB($table, $request)
    {

        $table->first_name = $request->first_name;
        $table->last_name = $request->last_name;
        $table->phone = $request->phone;
        $table->email = $request->email;
        $table->gender = $request->gender;
        $table->password = $this->password;
        $table->save();
        $table->syncRoles('customer');

    }

    public function destroy($id): array
    {
        User::findOrFail($id);
        User::destroy($id);
        $error = false;
        $message = Str::singular(Str::title($this->title)) . ' Deleted successfully';
        return compact('error', 'message');
    }




}