<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Current jobs</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                <tr>
                    <th class="small text-muted text-uppercase"><strong>id</strong>
                    </th>
                    <th class="small text-muted text-uppercase"><strong>Job</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Queue</strong></th>
                    <th class="small text-muted text-uppercase text-right"><strong>Attemtps</strong>
                    </th>
                    <th class="small text-muted text-uppercase text-right"><strong>Reserved at</strong>
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($jobs->take(20) as $job)
                    <tr>
                        <td>{{$job->id}}</td>
                        <?php
                        $name = $job->className();
                        $shortName = explode('\\', $name);
                        ?>
                        <td><span title="{{$name}}">{{array_pop($shortName)}}</span></td>
                        <td>{{$job->queue}}</td>

                        <td class="text-right">
                            @if($job->attempts > 0)
                                <i class="fa fa-fw fa-exclamation-circle text-danger"></i>
                            @endif
                            {{$job->attempts}}
                        </td>

                        <td class="text-right"><span title="{{$job->created_at}}">{{$job->reserved_at}}</span></td>
                    </tr>
                @endforeach


                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6" class="text-right">Total: {{number_format($jobs->count())}}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

