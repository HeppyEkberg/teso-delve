@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row m-t-1">

        <!-- START Revenue -->
        <div class="col-lg-3 col-md-4">
            <div class="panel panel-default b-a-0 bg-primary-i">
                <div class="panel-heading b-b-0">Users <span class="label label-white label-outline pull-right">{{$data['total_users']}}</span></div>
                <div class="panel-body text-center p-t-0">
                    <div class="col-md-6">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{$data['new_users']}}</h1>
                        <p class="text-white">New Users</p>
                    </div>
                    <div class="col-md-6">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{$data['users_activity']}}</h1>
                        <p class="text-white">Online 24 hrs</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Revenue -->

        <!-- START Total Item Sold -->
        <div class="col-lg-3 col-md-4">
            <div class="panel panel-default b-a-0 bg-gray-dark bg-success-i">
                <div class="panel-heading b-b-0">Characters <span class="label label-white label-outline  pull-right">{{$data['total_characters']}}</span></div>
                <div class="panel-body text-center p-t-0">
                    <h1 class="m-t-0 m-b-0 f-w-300">{{$data['new_characters']}}</h1>
                    <p class="text-white">New Characters</p>
                </div>
            </div>
        </div>
        <!-- END Total Item Sold -->

        <!-- START Total Visitor -->
        <div class="col-lg-3 col-md-4">
            <div class="panel panel-default b-a-0 bg-gray-dark bg-warning-i">
                <div class="panel-heading b-b-0">Uploads</div>
                <div class="panel-body text-center p-t-0">
                    <div class="col-md-6">
                    <h1 class="m-t-0 m-b-0 f-w-300">{{$data['dumps_activity']}}</h1>
                    <p class="text-white">Last 24 hrs</p>
                    </div>
                    <div class="col-md-6">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{$data['itemsCount']}}</h1>
                        <p class="text-white">New items</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Total Visitor -->

        <!-- START Total Visitor -->
        <div class="col-lg-3 col-md-4">
            <div class="panel panel-default b-a-0 bg-gray-dark bg-danger-i">
                <div class="panel-heading b-b-0">Sales <span class="label label-white label-outline  pull-right">{{$data['total_sales']}}</span></div>
                <div class="panel-body text-center p-t-0">
                    <h1 class="m-t-0 m-b-0 f-w-300">{{$data['sales_activity']}}</h1>
                    <p class="text-white">Sales last 24 hrs</p>
                </div>
            </div>

        </div>
        <!-- END Total Visitor -->

    </div>


    <div class="row">
        <div class="col-md-6">
            @include('admin.dashboard.partials.users-table')
        </div>
        <div class="col-md-6">
            @include('admin.dashboard.partials.dump-users', ['users' => $dumpUsers])
        </div>
        <div class="col-md-6">
            @include('admin.dashboard.partials.jobs-table')
        </div>
        <div class="col-md-12">
            @include('admin.dashboard.partials.errors-table')
        </div>
    </div>
</div>
@endsection
