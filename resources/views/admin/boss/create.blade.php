@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row-fluid">

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <form method="post" action="{{$boss->exists ? route('admin.boss.update', [$boss]) : route('admin.boss.store')}}" class="form-horizontal">
                            {{csrf_field()}}
                            {{method_field($boss->exists ? 'put' : 'post')}}

                            <div class="form-content">
                                <div class="form-group">
                                    <label for="boss[name]" class="control-label col-md-2">Name</label>
                                    <div class="col-md-10"><input type="text" id="boss[name]" name="boss[name]" value="{{$boss->name}}" class="form-control"></div>
                                </div>


                                    <div class="form-group">
                                        <label for="boss[dungeon_id]" class="control-label col-md-2">Dungeon</label>
                                        <div class="col-md-10">
                                            <select id="boss[dungeon_id]" name="boss[dungeon_id]" class="form-control">
                                                <option value="">None</option>
                                                @foreach($dungeons as $dungeon)
                                                    <option {{$dungeon_id == $dungeon->id ? 'selected="selected"' : ''}} value="{{$dungeon->id}}">{{$dungeon->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                <div class="form-group">
                                    <label for="boss[zone_id]" class="control-label col-md-2">Zone</label>
                                    <div class="col-md-10">
                                        <select id="boss[zone_id]" name="boss[zone_id]" class="form-control">
                                            <option value="">None</option>
                                            @foreach($zones as $zone)
                                                <option {{$zone_id == $zone['id'] ? 'selected="selected"' : ''}}>{{$zone['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="boss[order]" class="control-label col-md-2">Order</label>
                                    <div class="col-md-10"><input type="text" id="boss[order]" name="boss[order]" value="{{$boss->order}}" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <label for="boss[description]" class="control-label col-md-2">Description</label>
                                    <div class="col-md-10"><textarea id="boss[description]" rows="8" name="boss[description]" class="form-control">{{htmlspecialchars($boss->description)}}</textarea></div>
                                </div>

                                <div class="form-group">
                                    <label for="boss[mechanics]" class="control-label col-md-2">Mechanics</label>
                                    <div class="col-md-10"><textarea id="boss[mechanics]" rows="8" name="boss[mechanics]" class="form-control">{{htmlspecialchars($boss->mechanics)}}</textarea></div>
                                </div>

                                <div class="form-group">
                                    <label for="boss[strategy]" class="control-label col-md-2">Strategy</label>
                                    <div class="col-md-10"><textarea id="boss[strategy]" rows="8" name="boss[strategy]" class="form-control">{{htmlspecialchars($boss->strategy)}}</textarea></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" value="{{$boss->exists ? 'Update' : 'Create'}} boss" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
