@extends('admin.base_template')

@section('content')
    Вы авторизовались как {{ $user->name }} ({{ $user->email }})!
    <a href="/admin/logout">Выйти</a>
@endsection
