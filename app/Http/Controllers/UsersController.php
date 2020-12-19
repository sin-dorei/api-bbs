<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Storage;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // dd($request->avatar->getSize());
            if(!in_array($request->avatar->extension(), ['jpg', 'png', 'gif'])) {
                throw new Exception('只能上传后缀为jpg|png|jpeg|gif的图片，请重新操作！');
            }

            $path = $request->file('avatar')->store('images/avatars', 'upload');
        }
        $data = $request->except('_token');
        $data['avatar'] = Storage::disk('upload')->url($path);
        // dd($data);
        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', '个人资料更新成功！');
    }
}
