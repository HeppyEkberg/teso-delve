<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Latest dumps uploaded</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                <tr>
                    <th class="small text-muted text-uppercase"><strong>User</strong>
                    </th>
                    <th class="small text-muted text-uppercase text-right"><strong>Dump at</strong>
                    </th>
                    <th class="small text-muted text-uppercase text-right"><strong>Characters</strong>
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                    <tr>
                        <td class="text-white">{{$user->name}}</td>
                        <td class="text-right">{{$user->dumpUploaded_at ? $user->dumpUploaded_at->format('Y-m-d') : null}}</td>
                        <td class="text-right">{{$user->characters->count()}}</td>
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

