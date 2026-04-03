@extends('admin.base_template')

@section('content')
    <a href="/admin/users" class="btn btn-light"><i class="fa fa-arrow-left"></i> Назад к таблице пользователей</a><br><br>

    <table class='r-t'>
        <tr>
            <td>Email:</td>
            <td><a href="mailto:{{ $thisUser->email }}">{{ $thisUser->email }}</a></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td>{{ $thisUser->name }}</td>
        </tr>
        <tr>
            <td>Роль:</td>
            <td>{{ $thisUser->roleName() }}</td>
        </tr>
    </table>
@endsection
