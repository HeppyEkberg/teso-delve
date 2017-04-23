@extends('layouts.admin')

@section('content')

            <div class="col-md-12">
                <div class="row">
                    <h1 class="col-md-12 m-t-0">Roles</h1>

                    <div class="col-md-8">
                        <table class="table table-condensed">
                            <thead></thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr class="bg-gray-darker v-a-m">
                                    <td class="text-white text-bold">{{$role->display_name}}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-xs" role="group">
                                            <a href="{{route('admin.role.edit', [$role])}}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                            <a href="{{route('admin.role.edit', [$role])}}" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($role->permissions as $permission)
                                    <tr>
                                        <td><i class="fa fa-fw fa-angle-right"></i> {{$permission->display_name}} ({{$permission->name}})</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-default b-a-2 no-bg b-gray-dark">
                            <div class="panel-heading"><h4 class="panel-title">Create role</h4></div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="{{route('admin.role.save')}}">
                                    {!! csrf_field() !!}
                                    @include('admin.roles.create', ['role' => null])
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

@endsection
