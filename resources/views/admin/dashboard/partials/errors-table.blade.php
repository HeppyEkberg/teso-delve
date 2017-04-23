<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Errors</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table m-b-0">
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
                        <td>
                            @if(is_null($last_logs_watched) or $log->created_at->gt($last_logs_watched))
                                <i class="fa fa-exclamation-circle text-danger"></i>
                            @endif
                        </td>
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
            </table>
        </div>
    </div>
</div>

