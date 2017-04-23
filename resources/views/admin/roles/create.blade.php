
    <div class="form-group">
        <div class="col-sm-12">
            <input type="text" class="form-control" name="role[name]" placeholder="Name" value="{{$role->name or ''}}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="text" class="form-control" name="role[display_name]" placeholder="Display name" value="{{$role->display_name or ''}}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <textarea class="form-control" name="role[description]" placeholder="Description" rows="6">{{$role->description or ''}}</textarea>
        </div>
    </div>

    <div class="text-right">
        <input type="submit" class="btn btn-primary" value="Save">
    </div>