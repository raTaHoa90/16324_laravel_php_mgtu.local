@extends('admin.base_template')

@section('content')
    <form action="/admin/login" method='POST'>
        @csrf

        @if($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
        @endif

        <table>
            <tr>
                <td> Логин: </td>
                <td><input value="{{ old('login', '') }}"
                    required class="form-control" name="login" autocomplete="off"></td>
            </tr>
            <tr>
                <td> Пароль: </td>
                <td><input required class="form-control" name="pass" type="password" autocomplete="off"></td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn btn-primary" type="submit" value="Авторизоваться"></td>
            </tr>

        </table>
    </form>
@endsection
