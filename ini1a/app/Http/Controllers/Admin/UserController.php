<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Repositories\Interfaces\UserRepositoryInterface  $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        // Validate the data and create a new user
        $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'in:admin,user'],
            ]);
        $this->userRepository->createUser($data);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        
        if (!$currentUser || ($currentUser->role !== 'admin' && $currentUser->id !== $user->id)) {
            abort(403);
        }
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        
        if (!$currentUser || ($currentUser->role !== 'admin' && $currentUser->id !== $user->id)) {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $currentUser = Auth::user();
    
    if (!$currentUser || ($currentUser->role !== 'admin' && $currentUser->id !== $user->id)) {
        abort(403);
    }

    // Inisialisasi array untuk data yang akan diupdate
    $data = [];

    // Update name jika diisi
    if ($request->filled('name')) {
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
    }

    // Update email jika diisi dan berbeda dari yang sekarang
    if ($request->filled('email') && $request->email !== $user->email) {
        $validator = Validator($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['email'] = $request->email;
    }

    // Update password jika diisi
    if ($request->filled('password')) {
        $validator = Validator($request->all(), [
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['password'] = $request->password;
    }

    // Update role jika user adalah admin dan role diisi
    if ($currentUser->role === 'admin' && $request->filled('role')) {
        $validator = Validator($request->all(), [
            'role' => 'required|in:admin,user'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['role'] = $request->role;
    }

    // Jika ada data yang akan diupdate
    if (!empty($data)) {
        $this->userRepository->updateUser($id, $data);
        return redirect()
            ->route($currentUser->role === 'admin' ? 'users.index' : 'dashboard')
            ->with('success', 'User updated successfully');
    }

    return redirect()->back()->with('info', 'No changes were made');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        
        if (!$currentUser || $currentUser->role !== 'admin') {
            abort(403);
        }
        
        if ($currentUser->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Cannot delete yourself');
        }

        $this->userRepository->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}