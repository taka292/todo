@extends('layouts.admin')
@section('title', '記載済みのtodo')

@section('content')
<div class="container">
    <div class="row">
        <h2>todo一覧</h2>
    </div>
    <div class="row">

        <div class="col-md-4">
            <a href="{{ action('Admin\TodosController@add') }}" role="button" class="btn btn-primary">新規作成</a>
        </div>
        <div class="col-md-4">
            <a href="{{ action('Admin\TodosController@complete_data') }}" role="button" class="btn btn-primary">完了済みのtodo</a>
        </div>
        <div class="col-md-4">
            <a href="{{ action('Admin\CategoriesController@index') }}" role="button" class="btn btn-primary">categorty一覧</a>
        </div>
        <div class="col-md-8">
            <form action="{{ action('Admin\TodosController@index') }}" method="get">
                <div class="form-group row">
                    <label class="col-md-2">todo</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                    </div>
                    <div class="col-md-2">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="検索">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">category</label>
                    <div class="col-md-10">
                        <select class="form-control" name="cond_category">
                            <option value="" selected>選択してください</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="list-news col-md-12 mx-auto">
            <div class="row">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="10%">優先度</th>
                            <th width="25%">やること</th>
                            <th width="30%">いつまでに:
                                <a style="background:#fffb00;color:#312b2b;">期限切れ</a>
                                <a style="background:#e04733;color:#ffffff;">3日以内</a>
                                <a style="background:#78ee78;color:#413d3d;">1週間以内</a>
                            </th>
                            <th width="15%">category</th>
                            <th width="10%">操作</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($todos as $todo)
                        {{-- $posts を $todos  後はtodo--}}

                        {{-- 完了していないリストの作成 --}}
                        {{-- @if ($todos->is_complete == 0) --}}

                        {{-- phpの読み込み --}}

                        @php
                        $day1 = new DateTime($todo->deadline_date);
                        $day2 = new DateTime($carbon1);

                        $interval = $day1->diff($day2);

                        $deadlineInterval = $interval->format('%a');
                        @endphp

{{--期限が過ぎているかのチェック --}}
@if($deadlineInterval < 0)
<tr style="background:#fffb00;color:#312b2b;opacity: 0.7;">
    @elseif(0 <= $deadlineInterval && $deadlineInterval < 3)
    <tr style="background:#e04733;color:#ffffff;opacity: 0.7;">
        @elseif(3 <= $deadlineInterval && $deadlineInterval < 7)
        <tr style="background: rgba(143, 252, 0, 0.801) ;color:#413d3d;">
                            @else
                            <tr>
                                @endif

                            <th>{{ $todo->id }}</th>
                            <th>{{ $todo->priority}}</th>
                            <td>{{ \Str::limit($todo->title, 100) }}</td>
                            <td>{{ \Str::limit($todo->deadline_date, 100) }}</td>
                            <td>{{($todo->category->title)}}</td>
                            <td>
                                <div>
                                    <a href="{{ action('Admin\TodosController@edit', ['id' => $todo->id]) }}">編集</a>
                                </div>
                                <div>
                                    <a href="{{ action('Admin\TodosController@delete', ['id' => $todo->id]) }}">削除</a>
                                </div>
                                <div>
                                    <a href="{{ action('Admin\TodosController@complete', ['id' => $todo->id]) }}">完了</a>
                                </div>

                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                        {{ $todos->links() }}
                    </div>

                </div>
            </div>
        </div>
</div>
@endsection
