<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;
use App\Models\User;

use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $this->storeValidation($request);

        $requestArray = $this->makeHashPassword($request->all());

        User::create($requestArray);

        session()->flash('flash_message', '登録しました。');
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->updateValidation($request, $user);

        $requestArray = $this->makeHashPassword($request->all());

        if (array_key_exists('avatar', $requestArray) && $requestArray['avatar']) {
            $image_path = $request->file('avatar')->store('public/avatar/');
            $requestArray['avatar'] = basename($image_path);
        }

        $user->update($requestArray);

        session()->flash('flash_message', '更新しました。');
        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, User $user)
    {
        // INFO : logical deletion
        // $carbon = new Carbon();
        // $user->update(['deleted_at' => $carbon]);

        $user->delete();

        session()->flash('flash_message', '削除しました。');
        return redirect()->route('admin.users.index');
    }

    private function storeValidation(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:512|unique:authors,name',
            'password' => 'required|confirmed',
            'email'    => 'required|email:filter|unique:users,email',
        ],
        [
            'name.required'      => '名前は必須です。',
            'name.unique'        => '名前はすでに登録されています。',
            'password.required'  => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが異なります。',
            'email.required'     => 'メールアドレスは必須です。',
            'email.unique'       => 'メールアドレスはすでに登録されています。',
            'email.email'        => 'メールアドレスが不正です。',
        ]);
    }

    private function updateValidation(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:512|unique:authors,name',
            'password' => 'required|confirmed',
            'email'    => 'required|email:filter|unique:users,email,'. $user->id . ',id',
        ],
        [
            'name.required'      => '名前は必須です。',
            'name.unique'        => '名前はすでに登録されています。',
            'password.required'  => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが異なります。',
            'email.required'     => 'メールアドレスは必須です。',
            'email.unique'       => 'メールアドレスはすでに登録されています。',
            'email.email'        => 'メールアドレスが不正です。',
        ]);
    }

    private function makeHashPassword($params)
    {
        if (!is_null($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        } else {
            unset($params['password']);
        }
        return $params;
    }
}
