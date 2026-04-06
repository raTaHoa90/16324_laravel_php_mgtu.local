@extends('admin.base_template')

@section('content')
    @if($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    @endif

    <form id="repassword" method="POST" action="/admin/profile/update-password">@csrf</form>
    <form id="savedata" method="POST" action="/admin/profile/save">@csrf</form>
    <table class='r-t'>
        <tr>
            <td>Email:</td>
            <td><input form="savedata" class="form-control" name="email" value="{{ old('email',$user->email) }}"></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td><input form="savedata" class="form-control" name="name" value="{{ old('name', $user->name) }}"></td>
        </tr>
        <tr>
            <td>Роль:</td>
            <td>{{ $user->roleName() }}</td>
        </tr>
        <tr>
            <td></td>
            <td><input form="savedata" class="btn btn-success" type="submit" value="Сохранить изменения">
        </tr>
        <tr><td colspan="2"><hr></td></tr>
        <tr>
            <td>Смена пароля:</td>
            <td><input form="repassword" class="form-control" name="pass" type="password">
        </tr>
        <tr>
            <td>Повторение пароля:</td>
            <td><input form="repassword" class="form-control" name="pass_confirmation" type="password">
        </tr>
        <tr>
            <td></td>
            <td><input form="repassword" class="btn btn-success" type="submit" value="Сменить пароль">
        </tr>
    </table>
@endsection
