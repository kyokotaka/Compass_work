<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;//権限を定義・チェックするためのもの
use App\Models\Users\User;//ユーザーのモデル
use App\Models\Users\Subjects;//科目のモデル
use App\Searchs\DisplayUsers;//ユーザー検索のモデル
use App\Searchs\SearchResultFactories;//検索結果のモデル
class UsersController extends Controller
{

    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = null;// ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}