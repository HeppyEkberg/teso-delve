@extends('layouts.admin')

@section('stylesheet')
    <link href="/css/app.css" rel="stylesheet">
@endsection

@section('javascript')
    <script src="/js/importDropzone.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="col-md-12">
                <div>
                    <div>
                        <h1>{{$itemStyle->name}}</h1>

                        <form method="post" action="{{route('admin.crafting.item-style.update', [$itemStyle])}}" class="form-group form-horizontal">
                            {{csrf_field()}}

                            <div class="form-content">
                                <div class="form-group">
                                    <label for="itemStyle[name]" class="control-label col-md-2">Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="itemStyle[name]" value="{{$itemStyle->name}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="itemStyle[externalId]" class="control-label col-md-2">External id</label>
                                    <div class="col-md-10">
                                        <input type="text" name="itemStyle[externalId]" value="{{$itemStyle->externalId}}" class="form-control" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="itemStyle[location]" class="control-label col-md-2">Description</label>
                                    <div class="col-md-10">
                                        <textarea name="itemStyle[location]" rows="8" name="itemStyle[location]" class="form-control">{{$itemStyle->location}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="itemStyle[isHidden]" class="control-label col-md-2">Hidden</label>
                                    <div class="col-md-10">
                                        <input type="checkbox" value="1" name="itemStyle[isHidden]" {{ $itemStyle->isHidden ? 'checked="checked"' : ''}}>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="itemStyle[craftable]" class="control-label col-md-2">Craftable</label>
                                    <div class="col-md-10">
                                        <input type="checkbox" value="1" name="itemStyle[craftable]" {{ $itemStyle->craftable ? 'checked="checked"' : ''}}>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="itemStyle[material_id]" class="control-label col-md-2">Material</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="itemStyle[material_id]">
                                            <option value="">Select material</option>
                                            @foreach($materials as $material)
                                                <option {{$itemStyle->material_id == $material->id ? 'selected="selected"' : ''}} value="{{$material->id}}">{{$material->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        @if(!empty($itemStyle->material))
                                            <img src="{{$itemStyle->image}}" title="{{$itemStyle->material}}" class="icon-size-40">
                                            <br>
                                            <p>{{$itemStyle->material}}</p>
                                        @endif
                                    </div>

                                </div>

                                <hr>

                                <div class="row">
                                    @foreach(\App\Enum\ItemStyleChapter::order() as $chapter)
                                        <div class="form-group col-md-6">
                                            <label for="itemStyle[chapter][{{$chapter}}]" class="control-label col-md-4">@lang('enums.styleItemChapter.'.$chapter.'.self')</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="itemStyle[chapter][{{$chapter}}]">
                                                    <option value="">Select motif</option>
                                                    <?php  $itemStyleChapterSelected = $chapters->where('itemStyleChapterEnum', $chapter)->first(); ?>
                                                    @foreach($motifs as $motif)
                                                        @if(! in_array($motif->id, $assignedMotifs) or (!is_null($itemStyleChapterSelected) and $itemStyleChapterSelected->itemId == $motif->id))
                                                            <option {{ (!is_null($itemStyleChapterSelected) and $itemStyleChapterSelected->itemId == $motif->id)  ? 'selected="selected"' : '' }} value="{{$motif->id}}">{{$motif->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Upload style images</h3>
                                        <div url="{{route('admin.crafting.item-style.upload-images', [$itemStyle])}}" id="importDropzone" class=" panel panel-default no-bg b-a-2 b-gray b-dashed m-b-0"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-condensed">
                                            @foreach($items as $item)
                                                @include('item.item_row')
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" value="Save style" class="btn btn-primary">
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
