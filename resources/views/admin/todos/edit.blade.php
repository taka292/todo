@extends('layouts.admin')
@section('title', 'todoの編集')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>todo編集</h2>
            <form action="{{ action('Admin\TodosController@update') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2" for="title">やること</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ $todos_form->title }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="date">いつまでに</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="deadline_date" value="{{ $todos_form->deadline_date }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="date">優先度</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="priority" value="{{ $todos_form->priority }}">
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-md-2" for="body">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">{{ $todos_form->body }}</textarea>
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $todos_form->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>
            </form>

            <div class="row mt-5">
                <div class="col-md-4 mx-auto">
                    <h2>編集履歴</h2>
                    <ul class="list-group">
                        @if ($todos_form->histories != NULL)
                        @foreach ($todos_form->histories as $history)
                        <li class="list-group-item">{{ $history->edited_at }}</li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
