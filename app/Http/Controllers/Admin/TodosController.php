<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Todos;

use App\History;

use Carbon\Carbon;

class TodosController extends Controller
{
    //
    public function add()
    {
        return view('admin.todos.create');
    }

    public function create(Request $request)
    {
        // admin/todos/createにリダイレクトする
        // 以下を追記
      // Varidationを行う
      $this->validate($request, Todos::$rules);

      $todos = new Todos;
      $form = $request->all();


        // if (isset($form['date'])) {
        //     // $path = $request->file('image')->store('public/image');
        //     // $news->image_path = basename($path);
        // } else {
        //     $date = null;
        // }
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
    //   unset($form['date']);

      // データベースに保存する
      $todos->fill($form);
      $todos->save();
        return redirect('admin/todos');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = Todos::where('title', $cond_title)->get();
        } else {
            // それ以外はすべてのtodoを取得する
            $posts = Todos::all();
        }
        return view('admin.todos.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }

    public function edit(Request $request)
    {
        // Todos Modelからデータを取得する
        $todos = Todos::find($request->id);
        if (empty($todos)) {
            abort(404);
        }
        return view('admin.todos.edit', ['todos_form' => $todos]);
    }


    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, todos::$rules);
        // Todos Modelからデータを取得する
        $todos = todos::find($request->id);
        // 送信されてきたフォームデータを格納する
        $todos_form = $request->all();
        unset($todos_form['_token']);


        // 該当するデータを上書きして保存する
        $todos->fill($todos_form)->save();

        $history = new History;
        $history->todos_id = $todos->id;
        $history->edited_at = Carbon::now();
        $history->save();


        return redirect('admin/todos');
    }

    public function delete(Request $request)
    {
        // 該当するTodos Modelを取得
        $todos = Todos::find($request->id);
        // 削除する
        $todos->delete();
        return redirect('admin/todos/');
    }

}
