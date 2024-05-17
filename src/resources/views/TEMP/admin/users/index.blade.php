@extends('admin.content')

@section('title') Users @endsection

@section('content')
    <div class="mt-5 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>

                <div class="card-tools">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->getKey() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->is_admin ? 'badge-success' : 'badge-danger'}}">Admin</span>
                                <span class="badge {{ $user->is_manager ? 'badge-success' : 'badge-danger'}}">Manager</span>
                                <span class="badge {{ $user->is_executive ? 'badge-success' : 'badge-danger'}}">Executive</span>
                                <span class="badge {{ $user->is_hr ? 'badge-success' : 'badge-danger'}}">HR</span>
                                <span class="badge {{ $user->is_accountant ? 'badge-success' : 'badge-danger'}}">Accountant</span>
                                <span class="badge {{ $user->is_logist ? 'badge-success' : 'badge-danger'}}">Logist</span>
                                <span class="badge {{ $user->is_mover ? 'badge-success' : 'badge-danger'}}">Mover</span>




                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('erp.admin.users.edit', ['user' => $user->getKey()]) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('erp.admin.users.delete', ['user' => $user->getKey()]) }}" class="btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    
@endsection
