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

        // $category_id = Category::get('id');
        $categories = Category::all();
        // $category = Category::get('id');
        // dd($category_id);
        return view('admin.todos.create')->with(['categories' => $categories]);
        // return view('admin.todos.create');
        // return Category::where('id', $this->pref)->first()->title;
    }

    // public function getTodosAttribute()
    // {
    //     return config('pref.' . $this->pref_id);
    // }

    public function create(Request $request)
    {
        // admin/todos/createにリダイレクトする
        // 以下を追記
        // Varidationを行う
        //   dd($request);
        $this->validate($request, Todos::$rules);

        $todos = new Todos;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);


        // データベースに保存する
        // $category = Category::select('id')->get();
        // $category_titles = Category::get('title');
        // $category_id = Category::get('id');
        // $todos->category_id = $category;
        // $category = Category::find($form->title);
        // $form->$category_title;
        // dd($form);
        // $category_id = Category::get('id');
        $todos->fill($form);

        // $todos->fill($category);
        // $todos->fill(array('now' => Carbon::now()));
        // $todos->save();
        // dd($todos);
        // $category = Category::where('title', $todos->category_title)->get('id');
        // dd($category[0]->id);
        // $todos->category_id = $category->id;
        $todos->save();
        // $category = new Category;
        // $todos->category_id=$categoryTitles;
        // $category->save();
        //   return redirect('admin/todos');
        // $prefs = config('pref');
        // $categorya = Todos::all();
        // dd($category);
        return redirect('admin/todos');
        // return view('admin.todos.create')
        //     ->with(['category_titles' => $category_titles, 'category_id' => $category]);
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

        return view('admin.todos.index', ['todos' => $todos, 'cond_title' => $cond_title, 'cond_category' => $cond_category, 'carbon1' => $carbon1, 'categories' => $categories]);
    }
    // {
    //     $query = User::query();

    // //$request->input()で検索時に入力した項目を取得します。
    //     // $search1 = $request->input('category_title');
    //     $search3 = $request->input('cond_title');

    //      // プルダウンメニューで指定なし以外を選択した場合、$query->whereで選択した棋力と一致するカラムを取得します
    //     // if ($request->has('category_title') && $search1 != ('指定なし')) {
    //     //     $query->where('category_title', $search1)->get();
    //     // }

    //     // ユーザ名入力フォームで入力した文字列を含むカラムを取得します
    //     if ($request->has('cond_title') && $search3 != '') {
    //         $query->where('cond_title', 'like', '%'.$search3.'%')->get();
    //     }

    // // //ユーザを1ページにつき10件ずつ表示させます
    // //     $data = $query->paginate(10);

    //     return view('users.search',[
    //         'data' => $data
    //     ]);
    // }

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

        // $category = new Category;
        // $category->category_id = $todos->id;
        // $category->edited_at = Category::now();
        // $category->save();



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

        // // // // Todos Modelからデータを取得する
        // $todos = Todos::find($request->id);
        // $todos->fill(['is_complete' => 1]);
        // $todos->save();
        // return redirect('admin/todos');

    }
    public function complete_data_edit(Request $request)
    {
        $posts = Todos::all();
        $uncomplete = Todos::find($request->id)->fill(['is_complete' => 0])->save();

        return view('admin.todos.complete_data', ['posts' => $posts,'uncomplete' =>$uncomplete]);

        // // // // Todos Modelからデータを取得する
        // $todos = Todos::find($request->id);
        // $todos->fill(['is_complete' => 1]);
        // $todos->save();
        // return redirect('admin/todos');

    }
    public function complete_data_delete(Request $request)
    {
        $all_delete = Todos::where('is_complete', 1)->delete();
        // $cond_title = $request->cond_title;

        // $uncomplete = Todos::find($request->id)->fill(['is_complete' => 0])->save();
        // 'posts' => $posts,'uncomplete' =>$uncomplete,
        return view('admin.todos.index', [ 'all_delete' => $all_delete]);

        // // // // Todos Modelからデータを取得する
        // $todos = Todos::find($request->id);
        // $todos->fill(['is_complete' => 1]);
        // $todos->save();
        // return redirect('admin/todos');

    }

    // public function priority($priority)
    // {
    //     $todos = Todos::orderBy('priority', 'DESC')
    //     ->get();

    //     return view('admin.app.todos', ['posts' => Postss::find($priority)]);
    // }

}
