@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    <h1 class="col-md-12 m-t-0">{{$role->display_name}}</h1>


                    <div class="col-md-12">
                        <form class="form-horizontal" method="post" action="{{route('admin.role.save', [$role])}}">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th>Granted</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($permissions as $permission)
                                            <tr>
                                                <td><span class="text-white">{{$permission->display_name}}</span> ({{$permission->name}})</td>
                                                <td class="text-right"><input type="checkbox" value="{{$permission->id}}" name="permission[]" {{ $role->permissions->keyBy('id')->has($permission->id) ? ' checked="checked" ' : '' }}></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-4">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title text-white">Update role</div>
                                        </div>
                                        <div class="panel-body">
                                            @include('admin.roles.create')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title text-white">Create permission</div>
                            </div>
                            <div class="panel-body">
                                <form method="post" action="{{route('admin.permission.store')}}" class="form-horizontal">
                                    {!! csrf_field() !!}

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="permission[name]" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="permission[display_name]" placeholder="Display name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="permission[description]" placeholder="Description" rows="6"></textarea>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <input type="submit" class="btn btn-primary" value="Save">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
