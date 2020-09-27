@extends('layouts.admin')
@section('title', '完了済みのtodo')

@section('content')
<div class="container">
    <div class="row">
        <h2>完了済のtodo一覧</h2>
    </div>
    <div class="col-md-4">
        <a href="{{ action('Admin\TodosController@complete_data_delete') }}" role="button" class="btn btn-primary" value="all_delete">すべて削除</a>
    </div>

    <div class="row">
        <div class="list-news col-md-12 mx-auto">
            <div class="row">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="40%">やること</th>
                            <th width="30%">いつまでに</th>
                            <th width="10%">操作</th>
                            {{-- <th width="50%">本文</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $todos)
                        @if ($todos->is_complete == 1)
                        <tr>
                            <th>{{ $todos->id }}</th>
                            <td>{{ \Str::limit($todos->title, 100) }}</td>
                            <td>{{ \Str::limit($todos->deadline_date, 100) }}</td>
                            <td>

                                <div>
                                    <a href="{{ action('Admin\TodosController@delete', ['id' => $todos->id]) }}">削除</a>
                                </div>
                                <div>
                                    <a href="{{ action('Admin\TodosController@complete_data_edit', ['id' => $todos->id]) }}">未完了</a>
                                </div>
                            </td>
                        </tr>

                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
