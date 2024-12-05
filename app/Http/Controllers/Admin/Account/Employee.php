<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Employee extends Controller
{
    //
    public function ShowEmployee()
    {
        $listEmployee = AdminAccount::where('role_id', '!=', 1)->paginate(8);
        $countEmployee = $listEmployee->count();
        $countEmployeeDeleted = AdminAccount::where('is_deleted', 1)->count();
        return view('Admin.Account.Employee', compact('listEmployee', 'countEmployee', 'countEmployeeDeleted'));
    }
    public function SearchEmployee(Request $request)
    {
        $findEmployee = AdminAccount::where('username', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->where('role_id', '!=', 1)->paginate(8);
        if ($request->ajax()) {
            return response()->json([
                'table_html' => view('Admin.Components.employee-table', ['listEmployee' => $findEmployee])->render(),
                'pagination_html' => $findEmployee->links('vendor.pagination.tailwind')->render()
            ]);
        }
        return response()->json($findEmployee);
    }
    public function DeletedEmployee(Request $request)
    {
        try
        {
            $id = $request->id;
            $employee = AdminAccount::find($id);
            $employee->is_deleted = 1;
            $employee->save();
            return response()->json(['success' => true, 'message' => 'Khóa nhân viên thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Khóa nhân viên thất bại' . $e->getMessage()]);
        }
    }
    public function ActiveEmployee(Request $request)
    {
        try
        {
            $id = $request->id;
            $employee = AdminAccount::find($id);
            $employee->is_deleted = 0;
            $employee->save();
            return response()->json(['success' => true, 'message' => 'Mở khoá nhân viên thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Mở khoá nhân viên thất bại' . $e->getMessage()]);
        }
    }
    public function InsertEmployee(Request $request)
    {
        if(AdminAccount::where('email', $request->email)->exists())
        {
            return response()->json(['success' => false, 'message' => 'Email đã tồn tại']);
        }
        try
        {
            $employee = new AdminAccount();
            $employee->username = $request->username;
            $employee->email = $request->email;
            $employee->avatar_url = "https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/AvatarAdmin/default_avatar.jpg";
            $employee->password = Hash::make("password123");
            $employee->role_id = 2;
            $employee->save();

            $employee->load('adminRole');
            return response()->json(['success' => true, 'message' => 'Thêm nhân viên thành công', 'employee' => $employee, 'role' => $employee->adminRole->role_name]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Thêm nhân viên thất bại' . $e->getMessage()]);
        }
    }
    public function UpdateEmployee(Request $request)
    {
        try
        {
            $id = $request->id;
            $employee = AdminAccount::find($id);
            $employee->username = $request->username;
            $employee->email = $request->email;
            $employee->save();
            return response()->json(['success' => true, 'message' => 'Cập nhật nhân viên thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cập nhật nhân viên thất bại' . $e->getMessage()]);
        }
    }
}
