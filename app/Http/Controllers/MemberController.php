<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;



class MemberController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = $request->input('str', '');
            $members = Member::whereHas('user', function($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })->with('user')->get();

            return response()->json(['members' => $members]);
        }

        // normal page load
        $members = Member::with('user')->paginate(10);
        return view('pages.admin.members.index', compact('members'));
    }


    public function create ()
    {
        return view('pages.admin.members.create');
    }


    public function store(Request $request)
    {
    $validatedData = $request->validate([
        "username" => "required|string|min:5",
        "email" => "required|email",
        "password" => "required|string|min:5",
        "phone_number" => "required|string"
    ]);

    DB::beginTransaction();
    try {
        // Path source avatar
        $avatarPath = Storage::disk('public')->putFileAs(
    'avatar',
    new File(public_path('assets/avatar/profile.jpeg')),
    'profile-'.$validatedData['username'].'.jpeg'
);

        // Buat user
        $user = User::create([
            "username" => $validatedData['username'],
            "email" => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            "avatar" => $avatarPath
        ]);

        // Buat member
        Member::create([
            'user_id' => $user->id_user,
            'phone_number' => $validatedData['phone_number'],
        ]);

        DB::commit();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function edit(Member $member)
    {
        return view('pages.admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validatedData = $request->validate([
            'phone_number'   => 'required|string|max:20',
            'username'   => 'required|string|max:50',
            'email'   => 'required|email'
        ]);

        // Update data di tabel members
        $member->update([
            'phone_number' => $validatedData['phone_number'],
        ]);

        // Update data di tabel users
        $member->user->update([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
        ]);
        if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data berhasil diupdate.']);
            }

    }


    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Hapus juga user terkait kalau ada
        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();
  if (request()->ajax()) {
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
    }

    }
}
