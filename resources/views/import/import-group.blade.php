<div id="import-group" class="panel panel-default bg-gray-dark">
    <div class="panel-body">

        <div class="row">

            <div class="col-md-6">
                @if($importGroup->isDone == 0)
                    <h2 class="m-t-0">Processing upload <small>- {{number_format($importGroup->rowCount())}} rows left</small> </h2>
                @else
                    <h2 class="m-t-0">Previous upload <small>- {{$importGroup->created_at->format('Y-m-d H:i')}}</small> </h2>
                @endif
            </div>

            <div class="col-md-6 text-right">
                @if($importGroup->isDone)
                    <i class="fa fa-check text-success fa-3x" aria-hidden="true"></i>
                @else
                    <i class="fa fa-spinner text-primary fa-3x fa-pulse" aria-hidden="true"></i>
                @endif
            </div>

        </div>

        <div class="row m-t-1">

            <!-- START Revenue -->
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-default b-a-0 bg-primary-i">
                    <div class="panel-heading b-b-0">Characters</div>
                    <div class="panel-body text-center p-t-0">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{number_format($importGroup->characters)}}</h1>
                        <p class="text-white">Imported</p>
                    </div>
                </div>
            </div>
            <!-- END Revenue -->

            <!-- START Total Item Sold -->
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-default b-a-0 bg-gray-dark bg-success-i">
                    <div class="panel-heading b-b-0">Items</div>
                    <div class="panel-body text-center p-t-0">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{number_format($importGroup->items)}}</h1>
                        <p class="text-white">Imported</p>
                    </div>
                </div>
            </div>
            <!-- END Total Item Sold -->

            <!-- START Total Visitor -->
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-default b-a-0 bg-gray-dark bg-warning-i">
                    <div class="panel-heading b-b-0">Crafting research</div>
                    <div class="panel-body text-center p-t-0">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{number_format($importGroup->smithing)}}</h1>
                        <p class="text-white">Imported</p>
                    </div>
                </div>
            </div>
            <!-- END Total Visitor -->

            <!-- START Total Visitor -->
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-default b-a-0 bg-gray-dark bg-danger-i">
                    <div class="panel-heading b-b-0">Motifs</div>
                    <div class="panel-body text-center p-t-0">
                        <h1 class="m-t-0 m-b-0 f-w-300">{{number_format($importGroup->itemStyles)}}</h1>
                        <p class="text-white">Imported</p>
                    </div>
                </div>

            </div>
            <!-- END Total Visitor -->

        </div>
    </div>
</div>