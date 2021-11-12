<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use Auth;
use DB;

class HomeController extends Controller
{
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
    public function index(){
        $link_url = request()->segment(1);
        $roles = Roles::all();
        $my_roles = User::find(Auth::id());
        $users = User::join('roles', 'roles.id', '=', 'users.roles_id')->get(['users.*', 'roles.role']);
        $expense_category = ExpenseCategory::all();
        $expenses = Expenses::join('users', 'users.id', '=', 'expenses.users_id')
                                ->join('expense_category', 'expense_category.id', '=', 'expenses.expense_category_id')
                                ->get(['expenses.*', 'expense_category.category', 'users.name']);
        $report = Expenses::join('expense_category', 'expense_category.id', '=', 'expenses.expense_category_id')
                            ->groupBy('expense_category.category')
                            ->get(DB::raw("SUM(expenses.amount) as total, expense_category.category"));
        return view('home', ['link' => $link_url, 'roles' => $roles, 'users' => $users, 'expense_category' => $expense_category, 
                                'expenses' => $expenses, 'my_roles' => $my_roles, 'report' => $report]);
    }
    
    public function resetPassword(){
        return view('auth.change-password');
    }

    public function storeNewPassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:6|same:confirm_password',
            'confirm_password' => 'required'
        ]);
        $user = \Auth::user();
    	if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => 'error', 'message'=>'current password does not match']);
        }
        $user->password = \Hash::make($request->new_password);
        $user->save();
        return response()->json(['status' => 'success', 'message'=>'Password successfully changed!']);
    }
    
    public function saveUsers(Request $request){
        $user = User::find($request->id);
        if (is_null($user)) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'roles_id' => $request->roles_id,
                'password' => \Hash::make(str_replace(' ', '', $request->name))
            ]);   
            return response()->json(['message'=>'Successfully Added']);
        } else {
            $user->password = \Hash::make(str_replace(' ', '', $request->name));
            $user->name = $request->name;
            $user->email = $request->email;
            $user->roles_id = $request->roles_id;
            $user->save();
            return response()->json(['message'=>'Successfully Updated']);
        }
    }
    
    public function saveExpenseCategory(Request $request){
        $expenseCategory = ExpenseCategory::find($request->id);
        if (is_null($expenseCategory)) {
            ExpenseCategory::create([
                'category' => $request->category,
                'description' => $request->description,
            ]);   
            return response()->json(['message'=>'Successfully Added']);
        } else {
            $expenseCategory->category = $request->category;
            $expenseCategory->description = $request->description;
            $expenseCategory->save();
            return response()->json(['message'=>'Successfully Updated']);
        }
    }
    
    public function saveExpenses(Request $request){
        $expenses = Expenses::find($request->id);
        if (is_null($expenses)) {
            Expenses::create([
                'expense_category_id' => $request->expense_category_id,
                'users_id' => Auth::id(),
                'entry_date' => date('Y-m-d H:i:s', strtotime($request->entry_date)),
                'amount' => $request->amount,
            ]);   
            return response()->json(['message'=>'Successfully Added']);
        } else {
            $expenses->expense_category_id = $request->expense_category_id;
            $expenses->users_id = Auth::id();
            $expenses->entry_date = date('Y-m-d H:i:s', strtotime($request->entry_date));
            $expenses->amount = $request->amount;
            $expenses->save();
            return response()->json(['message'=>'Successfully Updated']);
        }
    }

    public function saveRole(Request $request){
        $roles = Roles::find($request->id);
        if (is_null($roles)) {
            Roles::create([
                'role' => $request->role,
                'description' => $request->description
            ]);   
            return response()->json(['message'=>'Successfully Added']);
        } else {
            $roles->role = $request->role;
            $roles->description = $request->description;
            $roles->save();
            return response()->json(['message'=>'Successfully Updated']);
        }
    }

    public function deleteData(Request $request){
        switch ($request->type) {
            case 'expense_category':
                ExpenseCategory::where('id', $request->id)->delete();
                break;
            case 'expenses':
                Expenses::where('id', $request->id)->delete();
                break;
            case 'roles':
                Roles::where('id', $request->id)->delete();
                break;
            case 'users':
                User::where('id', $request->id)->delete();
                break;
            default:
                # code...
                break;
        }
    }
}
