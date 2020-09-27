{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'todoの新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>todo新規作成</h2>
            {{-- {{$category}} --}}
            <form action="{{ action('Admin\TodosController@create') }}" method="post" enctype="multipart/form-data">

                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2">やること</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2">いつまでに<br>(〇〇〇〇-〇〇-〇〇)</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="deadline_date" value="{{ old('deadline_date') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">優先度</label>
                    {{-- <select> --}}
                    <div class="col-md-10">
                        <select class="form-control" name="priority">
                            <option value="1" selected>1</option>
                            <option value="2" selected>2</option>
                            <option value="3" selected>3</option>
                            <option value="4" selected>4</option>
                            <option value="5" selected>5</option>
                            <option value="" selected>選択してください</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">category</label>
                    {{-- <select> --}}
                    <div class="col-md-10">
                    <select class="form-control"  name="category_id">

                        {{-- $indexと書いていたためにoption 要素内のテキストが出力さてなかった。 --}}
                        {{-- @foreach($category_titles as $index => $category_title) --}}
                        <option value="" selected>選択してください</option>
                        @foreach($categories as $category)
                        {{-- <option {{$index}}> --}}
                        {{-- @if(old('category_title') === $category_title) selected @endif> --}}
                        <option value="{{ $category->id }}">{{$category->title}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                {{ csrf_field() }}
                <input type="submit" class="btn btn-primary" value="更新">
            </form>

        </div>
    </div>
</div>
@endsection
