<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Storage;
use Image;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function show(User $user)
    {
        $topics = $user->topics()->orderBy('created_at', 'desc')->paginate(5);
        return view('users.show', compact('user', 'topics'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->except('_token');
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // dd($request->avatar->getSize());
            if(!in_array($request->avatar->extension(), ['jpg', 'png', 'gif'])) {
                throw new Exception('只能上传后缀为jpg|png|jpeg|gif的图片，请重新操作！');
            }

            $path = $request->file('avatar')->store('images/avatars', 'upload');

            // 裁剪图片
            $image = Image::make('uploads/' . $path);
            $image->fit(416);
            $image->save();

            $data['avatar'] = Storage::disk('upload')->url($path);
        }

        // dd($data);
        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', '个人资料更新成功！');
    }
}
