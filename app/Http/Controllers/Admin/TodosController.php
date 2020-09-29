<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Todos;

use App\History;
use App\Category;
use Carbon\Carbon;

class TodosController extends Controller
{
    //
    public function add()
    {
        $categories = Category::all();

        return view('admin.todos.create')->with(['categories' => $categories]);
    }

    public function create(Request $request)
    {
        $this->validate($request, Todos::$rules);

        $todos = new Todos;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        $todos->fill($form);
        $todos->save();
        return redirect('admin/todos');
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $carbon1 = Carbon::now()->toDateString();

        $todoQuery = Todos::where('is_complete', 0);
        $cond_title = $request->cond_title;
        $cond_category = $request->cond_category;

        if ($cond_title != '') {
            $todoQuery->where('title', $cond_title);
            if ($cond_category != '') {
                $todoQuery->where('category_id', $cond_category);
            }
            // 検索されたら検索結果を取得する
            // $todoQuery->where('category_id', $request->all());
            // $todoQuery->where('categorytitle', $cond_title);

        }

        if ($cond_category) {
            $todoQuery->where('category_id', $cond_category);
        }

        $todoQuery->orderBy('priority', 'desc');
        $todos = $todoQuery->paginate(5);
        // dd($todos);

        return view('admin.todos.index', ['todos' => $todos, 'cond_title' => $cond_title, 'cond_category' => $cond_category, 'carbon1' => $carbon1, 'categories' => $categories]);
    }

    public function edit(Request $request)
    {
        // Todos Modelからデータを取得する
        $todos = Todos::find($request->id);
        $categories = Category::all();

        if (empty($todos)) {
            abort(404);
        }
        return view('admin.todos.edit', ['todos_form' => $todos, 'categories' => $categories]);
    }


    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Todos::$rules);
        // Todos Modelからデータを取得する
        $todos = Todos::find($request->id);
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

    public function complete(Request $request)
    {

        // $todos = new Todos();だけで処理を書くとtitleが記入されていないといわれたため、$todos = Todos::find($request->id);によりデータを見つけきた。
        // $todos->fill(['is_complete' => 1])
        // $todos->is_complete = 1;
        // これらは同じことをしている。
        // routesに関してはdeleteと同じでgetを使用している。

        // // // Todos Modelからデータを取得する
        $todos = Todos::find($request->id);
        $todos->fill(['is_complete' => 1]);
        $todos->save();
        return redirect('admin/todos');
    }

    public function complete_data(Request $request)
    {
        $cond_title = $request->cond_title;
        $posts = Todos::all();
        return view('admin.todos.complete_data', ['posts' => $posts, 'cond_title' => $cond_title]);

    }
    public function complete_data_edit(Request $request)
    {
        $posts = Todos::all();
        $uncomplete = Todos::find($request->id)->fill(['is_complete' => 0])->save();

        return view('admin.todos.complete_data', ['posts' => $posts,'uncomplete' =>$uncomplete]);
    }

    public function complete_data_delete(Request $request)
    {
        $all_delete = Todos::where('is_complete', 1)->delete();

        // プログラム処理後にindexに戻りたいが、以下のコードがないとエラーになってしまう。
        // もっと良いやり方があるはずだ。

        $categories = Category::all();
        $carbon1 = Carbon::now()->toDateString();

        $todoQuery = Todos::where('is_complete', 0);
        $cond_title = $request->cond_title;
        $cond_category = $request->cond_category;

        if ($cond_title != '') {
            $todoQuery->where('title', $cond_title);
            if ($cond_category != '') {
                $todoQuery->where('category_id', $cond_category);
            }

        }

        if ($cond_category) {
            $todoQuery->where('category_id', $cond_category);
        }

        $todoQuery->orderBy('priority', 'desc');
        $todos = $todoQuery->paginate(5);

        return view('admin.todos.index', [ 'all_delete' => $all_delete,'todos' => $todos, 'cond_title' => $cond_title, 'cond_category' => $cond_category, 'carbon1' => $carbon1, 'categories' => $categories]);
    }

    public function get_carendar_dates($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        $date = new Carbon($dateStr);
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);
        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $date->copy();
        }
        // return $dates;
        return view('admin.todos.carender', ['dates' => $dates]);

    }

}
