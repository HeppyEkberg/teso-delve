@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default no-bg b-a-2 b-gray-dark">
                <div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="small text-muted text-uppercase"><strong></strong></th>
                            <th class="small text-muted text-uppercase"><strong>User</strong></th>
                            <th class="small text-muted text-uppercase"><strong>Error</strong></th>
                            <th class="small text-muted text-uppercase"><strong>Request</strong></th>
                            <th class="small text-muted text-uppercase text-right"><strong>Occured at</strong></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td></td>
                                <td class="text-white">
                                    {{$log->user->name or '-'}}
                                </td>
                                <td>
                                    <a href="{{route('admin.error.show', [$log])}}" class="text-white">{{empty($log->error) ? 'error' : $log->error}}</a><br>{{$log->file}}:{{$log->row}}</td>
                                <td>{{$log->route}}<br>/{{$log->url}}</td>
                                <td class="text-right min-width nowrap">{{$log->created_at}}</td>
                                <td class="text-right min-widht nowrap">
                                    @if($log->referer)
                                        <i class="fa fa-external-link-square" data-toggle="tooltip" title="{{$log->referer}}"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">Total: {{$logs->total()}} </td>
                            <td class="text-right" colspan="3">{{$logs->links()}}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-3 text-right m-b-3">
            <div class="panel panel-default bg-gray-dark">
                <div class="panel-body">
                    <ul class="list-unstyled">
                        @role('super-admin')
                        <li class="m-b-1"><a href="{{route('admin.errors.truncate')}}" class="btn btn-danger">Truncate table</a></li>
                        <li><a href="{{route('admin.generate-error')}}" class="btn btn-danger">Generate error</a></li>
                        @endrole
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection