@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 15px;">
                <div class="card-header">{{ __('Поиск') }}</div>

                <div class="card-body">
                    <!-- Отображене ошибок проверки ввода -- >
                    @ include('common.errors')-->

                    <!-- Форма редактора постов -->
                    <form action="{{ route('search') }}" method="GET" class="form-horizontal">
                        <span class="form-group">
                            <input type="text" name="search" id="post-code" class="form-controll">
                        </span>

                        <span class="form-group">
                            <select size="1" name="operation">
                                <option selected value="=">=</option>
                                <option value=">">></option>
                                <option value="<"><</option>
                            </select>
                        </span>

                        <span class="form-group">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus"></i> Найти
                            </button>
                        </span>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @forelse ($computings as $computing)
                        <div style="border-width: 1px; border-style: solid; border-color: gray; border-radius: 5px; margin: 10px;">
                            <div style="margin: 10px;">
                                <a href="{{ route('post', ['id' => $computing->id]) }}"><h3>{{$computing>title}}</h3></a>
                                <p>{{$computing->created_at}} <i>{{$computing->user->name}}</i></p>
                            </div>
                        </div>
                    @empty
                        <p>Нет рассчётов.</p>
                    @endforelse

                    @if ($page > 1)
                        <a href="{{ route($route, ['page' => 1]).$query }}"><<</a>
                        <a href="{{ route($route, ['page' => $page - 1]).$query }}"><</a>
                    @endif
                    {{$page}}/{{$count}}
                    @if ($page < $count)
                        <a href="{{ route($route, ['page' => $page + 1]).$query }}">></a>
                        <a href="{{ route($route, ['page' => $count]).$query }}">>></a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
