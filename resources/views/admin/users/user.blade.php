@extends('admin.base_template')

@push('head')
    <script src='/js/admin/users.js'></script>
@endpush

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
            <td>@if($thisUser->NotUseAdminPanel() || $thisUser->id == $user->id ||
                ($thisUser->isAdmin() && !$user->isAdmin()) ||
                ($thisUser->isManager() && !$user->isAdmin())
            ) {{ $thisUser->roleName() }}
            @else
                <select onchange="setRoleUser({{ $thisUser->id }}, this.value)" onclick="return cancel(event);" class="form-control">
                @foreach ($roles as $roleID => $caption)
                    <option value="{{$roleID}}"
                        @if($thisUser->group_role == $roleID) selected @endif
                    >{{$caption}}</option>
                @endforeach
                </select>
            @endif</td>
        </tr>
    </table>
@endsection
