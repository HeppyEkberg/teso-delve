@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">

            <form method="post" action="{{route('admin.users.update', [$user])}}">
                {!! csrf_field() !!}
                <div class="col-md-12">
                    <div>
                        <div>
                            <h1>{{$user->name}}</h1>

                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td class="text-right min-width"><input type="checkbox" value="" name="role[{{$role->id}}]" {{ $userRoles->has($role->id) ? ' checked="checked"' : '' }}></td>
                                        <td>{{$role->display_name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>




                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <input type="submit" value="Update user" class="btn btn-primary">
                </div>
            </form>

        </div>
    </div>
@endsection
