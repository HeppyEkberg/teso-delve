<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Latest seen users</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                <tr>
                    <th class="small text-muted text-uppercase"><strong>User</strong>
                    </th>
                    <th class="small text-muted text-uppercase text-right"><strong>Seen at</strong>
                    </th>
                    <th class="small text-muted text-uppercase text-right"><strong>Created at</strong>
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                    <tr>
                        <td class="text-white">{{$user->name}}</td>
                        <td class="text-right">{{$user->seen_at}}</td>
                        <td class="text-right">{{$user->created_at->format('Y-m-d')}}</td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

