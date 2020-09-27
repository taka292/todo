<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;

class CategoriesController extends Controller
{
    //
    //
    public function add()
    {
        return view('admin.category.create');
    }

    public function create(Request $request)
    {
        // admin/category/createにリダイレクトする
        // 以下を追記
      // Varidationを行う
      $this->validate($request, Category::$rules);

      $category = new Category;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);


      // データベースに保存する
      $category->fill($form);
      $category->fill(array('now' => Carbon::now()));
      $category->save();
      return redirect('admin/category');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $category_variation = Category::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $category_variation = Category::all();
      }
      return view('admin.category.index', ['categories' => $category_variation, 'cond_title' => $cond_title]);


    }

    public function edit(Request $request)
    {
        // category Modelからデータを取得する
        $category = Category::find($request->id);
        if (empty($category)) {
            abort(404);
        }
        return view('admin.category.edit', ['category_form' => $category]);
    }


    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Category::$rules);
        // category Modelからデータを取得する
        $category = Category::find($request->id);
        // 送信されてきたフォームデータを格納する
        $category_form = $request->all();
        unset($category_form['_token']);


        // 該当するデータを上書きして保存する
        $category->fill($category_form)->save();



        return redirect('admin/category');
    }

    public function delete(Request $request)
    {
        // 該当するcategory Modelを取得
        $category = Category::find($request->id);
        // 削除する
        $category->delete();
        return redirect('admin/category/');
    }
}
