@extends('layouts.admin')

@section('meta-title')
    Edit dungeon {{$dungeon->name}} - @parent
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <form method="post" action="{{$dungeon->exists ? route('admin.dungeon.update', [$dungeon]) : route('admin.dungeon.store')}}" class="form-horizontal">
                            {{csrf_field()}}
                            {{method_field($dungeon->exists ? 'put' : 'post')}}

                            <div class="form-content">
                                <div class="form-group">
                                    <label for="dungeon[name]" class="control-label col-md-2">Dungeon name</label>
                                    <div class="col-md-10"><input type="text" id="dungeon[name]" name="dungeon[name]" value="{{$dungeon->name}}" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <label for="dungeon[image]" class="control-label col-md-2">Image</label>
                                    <div class="col-md-10"><input type="text" id="dungeon[image]" name="dungeon[image]" value="{{$dungeon->image}}" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <label for="dungeon[dungeonTypeEnum]" class="control-label col-md-2">Type</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="dungeon[dungeonTypeEnum]">
                                            <option value="">Select type</option>
                                            @foreach(\App\Enum\DungeonType::constants() as $dungeonType)
                                                <option {{$dungeonType == $dungeon->dungeonTypeEnum ? 'selected="selected"' : ''}} value="{{$dungeonType}}">{{trans('eso.dungeonType.'.$dungeonType)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dungeon[zone]" class="control-label col-md-2">Zone</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="dungeon[zone]">
                                            <option value="">Select zone</option>
                                            @foreach($zones as $zone)
                                                <option {{$dungeon->zone_id == $zone['id'] ? 'selected="selected"' : ''}} value="{{$zone['id']}}">{{$zone['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dungeon[description]" class="control-label col-md-2">Description</label>
                                    <div class="col-md-10"><textarea id="dungeon[description]" rows="12" name="dungeon[description]" class="form-control">{{$dungeon->description}}</textarea></div>
                                </div>

                                <div class="form-group">
                                    <label for="dungeon[groupSize]" class="control-label col-md-2">Group size</label>
                                    <div class="col-md-10"><input type="text" id="dungeon[groupSize]" name="dungeon[groupSize]" value="{{$dungeon->groupSize}}" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" value="Update dungeon" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(Auth::id() == 1 and isset($all_sets))
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <h3>Add set to Dungeon</h3>
                            <form method="post" action="{{route('dungeon.addSet', [$dungeon])}}">
                                {{method_field('PUT')}}
                                {{csrf_field()}}

                                <div class="form-group">
                                    <select class="form-control" name="setId">
                                        @foreach($all_sets as $set)
                                            <option value="{{$set->id}}">{{$set->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-default pull-right" value="Add set">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
