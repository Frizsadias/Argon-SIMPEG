<?php

namespace App\Http\Controllers;

use App\Models\agama;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Employee;
use App\Models\department;
use App\Models\User;
use App\Models\module_permission;
use App\Models\pendidikan;

class EmployeeController extends Controller
{
    /** all employee card view */
    public function cardAllEmployee(Request $request)
    {
        $users = DB::table('users')
            ->join('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->select('users.*', 'profil_pegawai.name', 'profil_pegawai.email', 'profil_pegawai.nip', 'profil_pegawai.nama', 'profil_pegawai.gelar_depan', 'profil_pegawai.gelar_belakang', 'profil_pegawai.tempat_lahir', 'profil_pegawai.tanggal_lahir', 'profil_pegawai.jenis_kelamin', 'profil_pegawai.agama', 'profil_pegawai.jenis_dokumen', 'profil_pegawai.no_dokumen', 'profil_pegawai.kelurahan', 'profil_pegawai.kecamatan', 'profil_pegawai.kota', 'profil_pegawai.provinsi', 'profil_pegawai.kode_pos', 'profil_pegawai.no_hp', 'profil_pegawai.no_telp', 'profil_pegawai.jenis_pegawai', 'profil_pegawai.kedudukan_pns', 'profil_pegawai.status_pegawai', 'profil_pegawai.tmt_pns', 'profil_pegawai.no_seri_karpeg', 'profil_pegawai.tmt_cpns', 'profil_pegawai.tingkat_pendidikan', 'profil_pegawai.pendidikan_terakhir')
            ->get();
        $userList = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('employees.allemployeecard', compact('users', 'userList', 'permission_lists'));
    }

    /** all employee list */
    public function listAllEmployee()
    {
        $users = DB::table('users')
            ->join('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->select('users.*', 'profil_pegawai.name', 'profil_pegawai.email', 'profil_pegawai.nip', 'profil_pegawai.nama', 'profil_pegawai.gelar_depan', 'profil_pegawai.gelar_belakang', 'profil_pegawai.tempat_lahir', 'profil_pegawai.tanggal_lahir', 'profil_pegawai.jenis_kelamin', 'profil_pegawai.agama', 'profil_pegawai.jenis_dokumen', 'profil_pegawai.no_dokumen', 'profil_pegawai.kelurahan', 'profil_pegawai.kecamatan', 'profil_pegawai.kota', 'profil_pegawai.provinsi', 'profil_pegawai.kode_pos', 'profil_pegawai.no_hp', 'profil_pegawai.no_telp', 'profil_pegawai.jenis_pegawai', 'profil_pegawai.kedudukan_pns', 'profil_pegawai.status_pegawai', 'profil_pegawai.tmt_pns', 'profil_pegawai.no_seri_karpeg', 'profil_pegawai.tmt_cpns', 'profil_pegawai.tingkat_pendidikan', 'profil_pegawai.pendidikan_terakhir')
            ->get();
        $userList = DB::table('users')->get();
        $permission_lists = DB::table('permission_lists')->get();
        return view('employees.employeelist', compact('users', 'userList', 'permission_lists'));
    }

    /** save data employee */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email',
            'nip'        => 'required|string|max:255',
            'gelar_depan'        => 'required|string|max:255',
            'gelar_belakang'        => 'required|string|max:255',
            'tempat_lahir'        => 'required|string|max:255',
            'tanggal_lahir'        => 'required|string|max:255',
            'jenis_kelamin'        => 'required|string|max:255',
            'agama'        => 'required|string|max:255',
            'jenis_dokumen'        => 'required|string|max:255',
            'no_dokumen'        => 'required|string|max:255',
            'kelurahan'        => 'required|string|max:255',
            'kecamatan'        => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'provinsi'        => 'required|string|max:255',
            'kode_pos'        => 'required|string|max:255',
            'no_hp'        => 'required|string|max:255',
            'no_telp'        => 'required|string|max:255',
            'jenis_pegawai'        => 'required|string|max:255',
            'kedudukan_pns'        => 'required|string|max:255',
            'status_pegawai'        => 'required|string|max:255',
            'tmt_pns'        => 'required|string|max:255',
            'no_seri_karpeg'        => 'required|string|max:255',
            'tmt_cpns'        => 'required|string|max:255',
            'tingkat_pendidikan'        => 'required|string|max:255',
            'pendidikan_terakhir'        => 'required|string|max:255',
            // 'birthDate'   => 'required|string|max:255',
            // 'jk'      => 'required|string|max:255',
            'employee_id' => 'required|string|max:255',
            // 'company'     => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $employees = Employee::where('email', '=', $request->email)->first();
            if ($employees === null) {

                $employee = new Employee;
                $employee->name = $request->input('name');
                $employee->email = $request->input('email');
                $employee->nip = $request->input('nip');
                $employee->gelar_depan = $request->input('gelar_depan');
                $employee->gelar_belakang = $request->input('gelar_belakang');
                $employee->tempat_lahir = $request->input('tempat_lahir');
                $employee->tanggal_lahir = $request->input('tanggal_lahir');
                $employee->jenis_kelamin = $request->input('jenis_kelamin');
                $employee->agama = $request->input('agama');
                $employee->jenis_dokumen = $request->input('jenis_dokumen');
                $employee->no_dokumen = $request->input('no_dokumen');
                $employee->kelurahan = $request->input('kelurahan');
                $employee->kecamatan = $request->input('kecamatan');
                $employee->kota = $request->input('kota');
                $employee->provinsi = $request->input('provinsi');
                $employee->kode_pos = $request->input('kode_pos');
                $employee->no_hp = $request->input('no_hp');
                $employee->no_telp = $request->input('no_telp');
                $employee->jenis_pegawai = $request->input('jenis_pegawai');
                $employee->kedudukan_pns = $request->input('kedudukan_pns');
                $employee->status_pegawai = $request->input('status_pegawai');
                $employee->tmt_pns = $request->input('tmt_pns');
                $employee->no_seri_karpeg = $request->input('no_seri_karpeg');
                $employee->tmt_cpns = $request->input('tmt_cpns');
                $employee->tingkat_pendidikan = $request->input('tingkat_pendidikan');
                $employee->pendidikan_terakhir = $request->input('pendidikan_terakhir');
                $employee->employee_id = $request->input('employee_id');
                $employee->save();

                for ($i = 0; $i < count($request->id_count); $i++) {
                    $module_permissions = [
                        'employee_id' => $request->employee_id,
                        'module_permission' => $request->permission[$i],
                        'id_count'          => $request->id_count[$i],
                        'read'              => $request->read[$i],
                        'write'             => $request->write[$i],
                        'create'            => $request->create[$i],
                        'delete'            => $request->delete[$i],
                        'import'            => $request->import[$i],
                        'export'            => $request->export[$i],
                    ];
                    DB::table('module_permissions')->insert($module_permissions);
                }

                DB::commit();
                Toastr::success('Berhasil menambahkan pegawai baru :)', 'Success');
                return redirect()->route('all/employee/card');
            } else {
                DB::rollback();
                Toastr::error('Data tersebuut sudah tersedia :)', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Gagal menambahkan pegawai baru :)', 'Error');
            return redirect()->back();
        }
    }

    /** view edit record */
    public function viewRecord($employee_id)
    {
        $permission = DB::table('employees')
            ->join('module_permissions', 'employees.employee_id', 'module_permissions.employee_id')
            ->select('employees.*', 'module_permissions.*')->where('employees.employee_id', $employee_id)->get();
        $employees = DB::table('employees')->where('employee_id', $employee_id)->get();
        return view('employees.edit.editemployee', compact('employees', 'permission'));
    }

    /** update record employee */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            // update table Employee
            $updateEmployee = [
                'id' => $request->id,
                'name' => $request->name,
                'email' => $request->email,
                'tgl_lahir' => $request->tgl_lahir,
                'jk' => $request->jk,
                'employee_id' => $request->employee_id,
                'company' => $request->company,
            ];

            // update table user
            $updateUser = [
                'id' => $request->id,
                'name' => $request->name,
                'email' => $request->email,
            ];

            // update table module_permissions
            for ($i = 0; $i < count($request->id_permission); $i++) {
                $UpdateModule_permissions = [
                    'employee_id' => $request->employee_id,
                    'module_permission' => $request->permission[$i],
                    'id'                => $request->id_permission[$i],
                    'read'              => $request->read[$i],
                    'write'             => $request->write[$i],
                    'create'            => $request->create[$i],
                    'delete'            => $request->delete[$i],
                    'import'            => $request->import[$i],
                    'export'            => $request->export[$i],
                ];
                module_permission::where('id', $request->id_permission[$i])->update($UpdateModule_permissions);
            }

            User::where('id', $request->id)->update($updateUser);
            Employee::where('id', $request->id)->update($updateEmployee);

            DB::commit();
            Toastr::success('Berhasil update data :)', 'Success');
            return redirect()->route('all/employee/card');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Gagal update data :)', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord($employee_id)
    {
        DB::beginTransaction();
        try {
            Employee::where('employee_id', $employee_id)->delete();
            module_permission::where('employee_id', $employee_id)->delete();

            DB::commit();
            Toastr::success('Berhasil hapus data :)', 'Success');
            return redirect()->route('all/employee/card');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Gagal hapus data :)', 'Error');
            return redirect()->back();
        }
    }

    /** employee search */
    public function employeeSearch(Request $request)
    {
        $users = DB::table('users')
            ->join('employees', 'users.user_id', 'employees.employee_id')
            ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')->get();
        $permission_lists = DB::table('permission_lists')->get();
        $userList = DB::table('users')->get();

        // search by id
        if ($request->employee_id) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')->get();
        }
        // search by name
        if ($request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')->get();
        }
        // search by name
        if ($request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }

        // search by name and id
        if ($request->employee_id && $request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->get();
        }
        // search by position and id
        if ($request->employee_id && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        // search by name and position
        if ($request->name && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        // search by name and position and id
        if ($request->employee_id && $request->name && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        return view('employees.allemployeecard', compact('users', 'userList', 'permission_lists'));
    }

    /** list search employee */
    public function employeeListSearch(Request $request)
    {
        $users = DB::table('users')
            ->join('employees', 'users.user_id', 'employees.employee_id')
            ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')->get();
        $permission_lists = DB::table('permission_lists')->get();
        $userList         = DB::table('users')->get();

        // search by id
        if ($request->employee_id) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')->get();
        }
        // search by name
        if ($request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')->get();
        }
        // search by name
        if ($request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }

        // search by name and id
        if ($request->employee_id && $request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')->get();
        }
        // search by position and id
        if ($request->employee_id && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        // search by name and position
        if ($request->name && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        // search by name and position and id
        if ($request->employee_id && $request->name && $request->position) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.tgl_lahir', 'employees.jk', 'employees.company')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.position', 'LIKE', '%' . $request->position . '%')->get();
        }
        return view('employees.employeelist', compact('users', 'userList', 'permission_lists'));
    }

    /** employee profile with all controller user */
    public function profileEmployee($user_id)
    {
        $user = DB::table('users')
            ->leftJoin('personal_information as pi', 'pi.user_id', 'users.user_id')
            ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
            ->leftJoin('user_emergency_contacts as ue', 'ue.user_id', 'users.user_id')
            ->select(
                'users.*',
                'pi.passport_no',
                'pi.passport_expiry_date',
                'pi.tel',
                'pi.nationality',
                'pi.religion',
                'pi.marital_status',
                'pi.employment_of_spouse',
                'pi.children',
                'pr.tgl_lahir',
                'pr.jk',
                'pr.alamat',
                'ue.name_primary',
                'ue.relationship_primary',
                'ue.phone_primary',
                'ue.phone_2_primary',
                'ue.name_secondary',
                'ue.relationship_secondary',
                'ue.phone_secondary',
                'ue.phone_2_secondary'
            )
            ->where('users.user_id', $user_id)->get();
        $users = DB::table('users')
            ->leftJoin('personal_information as pi', 'pi.user_id', 'users.user_id')
            ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
            ->leftJoin('user_emergency_contacts as ue', 'ue.user_id', 'users.user_id')
            ->select(
                'users.*',
                'pi.passport_no',
                'pi.passport_expiry_date',
                'pi.tel',
                'pi.nationality',
                'pi.religion',
                'pi.marital_status',
                'pi.employment_of_spouse',
                'pi.children',
                'pr.tgl_lahir',
                'pr.jk',
                'pr.alamat',
                'ue.name_primary',
                'ue.relationship_primary',
                'ue.phone_primary',
                'ue.phone_2_primary',
                'ue.name_secondary',
                'ue.relationship_secondary',
                'ue.phone_secondary',
                'ue.phone_2_secondary'
            )
            ->where('users.user_id', $user_id)->first();

        return view('employees.employeeprofile', compact('user', 'users'));
    }

    /** page departments */
    public function index()
    {
        $departments = DB::table('departments')->get();
        return view('employees.departments', compact('departments'));
    }

    /** save record department */
    public function saveRecordDepartment(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $department = department::where('department', $request->department)->first();
            if ($department === null) {
                $department = new department;
                $department->department = $request->department;
                $department->save();

                DB::commit();
                Toastr::success('Add new department successfully :)', 'Success');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Add new department exits :)', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Add new department fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** update record department */
    public function updateRecordDepartment(Request $request)
    {
        DB::beginTransaction();
        try {
            // update table departments
            $department = [
                'id' => $request->id,
                'department' => $request->department,
            ];
            department::where('id', $request->id)->update($department);

            DB::commit();
            Toastr::success('updated record successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** delete record department */
    public function deleteRecordDepartment(Request $request)
    {
        try {
            department::destroy($request->id);
            Toastr::success('Department deleted successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Department delete fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** page agama */
    public function agamaIndex()
    {
        $agama = DB::table('agama_id')->get();
        return view('employees.agama', compact('agama'));
    }

    /** save record agama */
    public function saveRecordAgama(Request $request)
    {
        $request->validate([
            'agama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $agama = agama::where('agama', $request->agama)->first();
            if ($agama === null) {
                $agama = new agama;
                $agama->agama = $request->agama;
                $agama->save();

                DB::commit();
                Toastr::success('Tambahkan agama baru berhasil :)', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Agama sudah ada :)', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Tambahkan agama baru gagal :)', 'Error');
            return redirect()->back();
        }
    }


    /** update record agama */
    public function updateRecordAgama(Request $request)
    {
        DB::beginTransaction();
        try {
            // update table agama
            $agama = [
                'id' => $request->id,
                'agama' => $request->agama,
            ];
            agama::where('id', $request->id)->update($agama);

            DB::commit();
            Toastr::success('updated record successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** delete record agama */
    public function deleteRecordAgama(Request $request)
    {
        try {
            agama::destroy($request->id);
            Toastr::success('Agama berhasil dihapus :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Agama gagal dihapus :)', 'Error');
            return redirect()->back();
        }
    }

    /** page pendidikan */
    public function pendidikanIndex()
    {
        $pendidikan = DB::table('pendidikan_id')->get();
        return view('employees.pendidikan', compact('pendidikan'));
    }

    /** save record pendidikan */
    public function saveRecordPendidikan(Request $request)
    {
        $request->validate([
            'pendidikan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $pendidikan = pendidikan::where('pendidikan', $request->pendidikan)->first();
            if ($pendidikan === null) {
                $pendidikan = new pendidikan;
                $pendidikan->pendidikan = $request->pendidikan;
                $pendidikan->tk_pendidikan_id = $request->tk_pendidikan_id;
                $pendidikan->status_pendidikan = $request->status_pendidikan;
                $pendidikan->save();

                DB::commit();
                Toastr::success('Tambahkan pendidikan baru berhasil :)', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Pendidikan sudah ada :)', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Tambahkan pendidikan baru gagal :)', 'Error');
            return redirect()->back();
        }
    }


    /** update record pendidikan */
    public function updateRecordPendidikan(Request $request)
    {
        $request->validate([
            'pendidikan' => 'required|string|max:255',
            'tk_pendidikan_id' => 'required|string|max:255',
            'status_pendidikan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // update table pendidikan
            $pendidikan = [
                'pendidikan' => $request->pendidikan,
                'tk_pendidikan_id' => $request->tk_pendidikan_id,
                'status_pendidikan' => $request->status_pendidikan,
            ];
            DB::table('pendidikan_id')->where('id', $request->id)->update($pendidikan);

            DB::commit();
            Toastr::success('Berhasil update pendidikan :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Gagal update pendidikan :)', 'Error');
            return redirect()->back();
        }
    }

    /** delete record pendidikan */
    public function deleteRecordPendidikan(Request $request)
    {
        try {
            pendidikan::destroy($request->id);
            Toastr::success('Pendidikan berhasil dihapus :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Pendidikan gagal dihapus :)', 'Error');
            return redirect()->back();
        }
    }

    /** page designations */
    public function designationsIndex()
    {
        return view('employees.designations');
    }

    /** page time sheet */
    public function timeSheetIndex()
    {
        return view('employees.timesheet');
    }

    /** page overtime */
    public function overTimeIndex()
    {
        return view('employees.overtime');
    }
}