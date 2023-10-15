<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function doLogin(Request $request)
    {
        // Validate requests
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|alpha_num',
        ]);

        $userInfo = User::where('email', $request->email)->first();

        if (!$userInfo) {
            return back()->with('fail', 'We do not recognize your email address');
        } else {
            if ($userInfo->status === \App\Constants\AppConstants::USER_ACTIVE) {
                if (Hash::check($request->password, $userInfo->password)) {
                    $request->session()->put('LoggedUser', $userInfo->id);
                    return redirect('dashboard');
                } else {
                    return back()->with('fail', 'Incorrect password');
                }
            } else {
                return back()->with('fail', 'Your account is not active. Please contact the administrator.');
            }
        }
    }
    public function save(CreateUserRequest $request)
    {

        //Insert data into database
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->mobile = $request->input('mobile');
        $user->dob = $request->input('dob');
        $user->gender = $request->input('gender');
        if ($request->hasFile('profile_images')) {
            $images = $request->file('profile_images');

            foreach ($images as $image) {
                $this->processAndAttachImage($image, $user);
            }
        }
        $user->status = $request->input('status');

        $save = $user->save();

        if ($save) {
            return back()->with('success', 'New User has been successfuly added to database');
        } else {
            return back()->with('fail', 'Something went wrong, try again later');
        }
    }

    public function showLoginView()
    {
        return view('auth.login');
    }

    public function showRegisterView()
    {
        return view('auth.register');
    }
    public function edit($id)
    {
        // Retrieve the user by ID for editing
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            // Handle the case where the user is not found
            return redirect()->route('users')->with('error', 'User not found');
        }

        return view('users.user-update', compact('user'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::withCount('blogs')->get();

            return Datatables::of($users)
                ->addColumn('action', function ($user) {
                    // Generate the edit and delete buttons
                    return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-primary">Edit</a> ';
                })
                ->make(true);
        }

        return view('users.user-list');
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $user->name = $request->input('name') ?? null;
        $user->mobile = $request->input('mobile') ?? null;
        $user->gender = $request->input('gender') ?? null;
        $user->status = $request->input('status') ?? null;

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();


        return redirect()->route('users.index')->with('success', 'User updated successfully');

    }

    public function destroy($id)
    {
        // Check if the user is authenticated
        if (!Session::has('LoggedUser')) {
            throw new BadRequestHttpException(__('You are not logged In'));
        }

        // Validate the $id parameter
        $user = User::find($id);
        if (!$user) {
            throw new BadRequestHttpException(__('User not found'));
        }
        if ($user->id === 1) {
            throw new BadRequestHttpException(__("This user cannot be deleted"));
        }

        // Delete the user
        $user->delete();

        // Redirect the user to the users index page
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    private function processAndAttachImage($image, $user)
    {
        $imagePath = 'profile_images';
        $imageName = $image->getClientOriginalName();
        $image->storeAs($imagePath, $imageName);

        $file = new File();
        $file->name = $imageName;
        $file->local_path = $imagePath . '/' . $imageName;
        $file->type = File::TYPE_PROFILE_IMAGE;
        $file->save();

        // Associate the file with the user
        $user->profile_image = $file->id;
        $user->save();
    }
    public function dashboard()
    {
        $data = ['LoggedUserInfo' => User::where('id', '=', session('LoggedUser'))->first()];
        return view('users.dashboard', $data);
    }

    public function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            return redirect('/login');
        }
    }


}
