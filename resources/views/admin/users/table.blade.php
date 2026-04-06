@extends('admin.base_template')

@push('head')
    <script src='/js/admin/users.js'></script>
    <style>
        tbody.table-group-divider > tr {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <dialog id="addUserDlg" closedby="any">
        <form id="adduser" onsubmit="sendNewUser(); return false">
            {{-- @csrf --}}
            <table>
                <tr>
                    <td>Email</td>
                    <td><input class="form-control" name="email" type="email" autocomplete="off"> </td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><input class="form-control" name="name" autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Роль пользователя</td>
                    <td><select class="form-control" name="role">
                    @foreach ($roles as $roleID => $caption)
                        <option value="{{$roleID}}">{{$caption}}</option>
                    @endforeach
                    </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="form-control" type="submit" value="Создать пользователя"></td>
                </tr>
            </table>
        </form>
    </dialog>

    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>
                        <i class="fa fa-cog"></i>
                        <button class="btn btn-success" style="float:right" onclick="openNewUserDlg()"><i class="fa fa-user-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach ($users as $userData)
                <tr onclick="location = '/admin/users/{{ $userData->name }}'">
                    <td>{{ $userData->id }}</td>
                    <td>{{ $userData->name }}</td>
                    <td>{{ $userData->email }}</td>
                    <td>@if($userData->NotUseAdminPanel() || $userData->id == $user->id ||
                        ($userData->isAdmin() && !$user->isAdmin()) ||
                        ($userData->isManager() && !$user->isAdmin())
                    ) {{ $userData->roleName() }}
                    @else
                        <select onchange="setRoleUser({{ $userData->id }}, this.value)" onclick="return cancel(event);" class="form-control">
                        @foreach ($roles as $roleID => $caption)
                            <option value="{{$roleID}}"
                                @if($userData->group_role == $roleID) selected @endif
                            >{{$caption}}</option>
                        @endforeach
                        </select>
                    @endif
                    </td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </section>
@endsection
