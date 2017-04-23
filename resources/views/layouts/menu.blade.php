<div class="navbar-inverse navbar navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <a class="current navbar-brand" href="/">
                TESO Delve
            </a>
            <sup class="betaLogo label label-danger">Beta</sup>
            <button class="action-right-sidebar-toggle navbar-toggle collapsed active" data-target="#navdbar" data-toggle="collapse" type="button" data-original-title="" title="">
                <i class="fa fa-fw fa-align-right text-white"></i>
            </button>
            <button class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse" type="button">
                <i class="fa fa-fw fa-user text-white"></i>
            </button>
            <button class="action-sidebar-open navbar-toggle collapsed" type="button">
                <i class="fa fa-fw fa-bars text-white"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar">

            <!-- START Search Mobile -->
            <div class="form-group hidden-lg hidden-md hidden-sm">
                <div class="input-group hidden-lg hidden-md">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><i class="fa fa-fw fa-search"></i></button>
                    </span>
                </div>
            </div>
            <!-- END Search Mobile -->

            <!-- START Left Side Navbar -->
            <ul class="nav navbar-nav navbar-left clearfix yamm">


                <!-- START Menu Only Visible on Navbar -->

                <li>
                    <a href="{{route('import.index')}}" aria-expanded="false">
                        <span class="m-r-1">Import</span>
                    </a>
                </li>


                @if(Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">Sets</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('set.my-sets')}}">My sets</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{route('set.index')}}">All sets</a>
                                <a href="{{route('zones.index')}}">Zones</a>
                                <a href="{{route('set.monster')}}">Monster</a>
                                <a href="{{route('set.craftable')}}">Craftable</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">Dungeons</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('dungeons.groups.index')}}">Group dungeons</a>
                                <a href="{{route('dungeons.public.index')}}">Public dungeons</a>
                                <a href="{{route('dungeons.trials.index')}}">Trials</a>
                                <a href="{{route('dungeons.delves.index')}}">Delves</a>
                                <a href="{{route('dungeons.arenas.index')}}">Arenas</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">Characters</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('characters.index')}}">My characters</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            @foreach(Auth::user()->characters()->orderBy('championLevel', 'desc')->orderBy('level', 'desc')->get() as $character)
                                <li>
                                    <a href="{{route('characters.show', [$character->id])}}">{{$character->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('inventory.index')}}" aria-expanded="false">
                            <span class="m-r-1">Inventory</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('item-styles.index')}}" aria-expanded="false">
                            <span class="m-r-1">Styles & Motifs</span>
                        </a>
                    </li>
                    @if(Auth::id() == 1)
                        <li class="dropdown">
                            <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                                <span class="m-r-1">Guilds</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(Auth::user()->guilds as $guild)
                                    <li><a href="{{route('guilds.show', [$guild])}}">{{$guild->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">Sets</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('set.index')}}">All sets</a>
                                <a href="{{route('zones.index')}}">Zones</a>
                                <a href="{{route('set.monster')}}">Monster</a>
                                <a href="{{route('set.craftable')}}">Craftable</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">Dungeons</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('dungeons.groups.index')}}">Group dungeons</a>
                                <a href="{{route('dungeons.public.index')}}">Public dungeons</a>
                                <a href="{{route('dungeons.trials.index')}}">Trials</a>
                                <a href="{{route('dungeons.delves.index')}}">Delves</a>
                                <a href="{{route('dungeons.arenas.index')}}">Arenas</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('item-styles.index')}}" aria-expanded="false">
                            <span class="m-r-1">Styles & Motifs</span>
                        </a>
                    </li>
                @endif


            </ul>
            <!-- START Left Side Navbar -->

            <!-- START Right Side Navbar -->
            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">

                    <li role="separator" class="divider hidden-lg hidden-md hidden-sm"></li>
                    <li class="dropdown-header hidden-lg hidden-md hidden-sm text-gray-lighter text-uppercase">
                        <strong>Your Profile</strong>
                    </li>

                    <!-- START Notification -->
                    <li class="dropdown hidden">

                        <!-- START Icon Notification with Badge (10)-->
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <i class="fa fa-lg fa-fw fa-bell hidden-xs"></i>
                            <span class="hidden-sm hidden-md hidden-lg">
                                Notifications <span class="badge badge-primary m-l-1">10</span>
                            </span>
                            <span class="label label-primary label-pill label-with-icon hidden-xs">10</span>
                            <span class="fa fa-fw fa-angle-down hidden-lg hidden-md hidden-sm"></span>
                        </a>
                        <!-- END Icon Notification with Badge (10)-->

                        <!-- START Notification Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-right p-t-0 b-t-0 p-b-0 b-b-0 b-a-0">
                            <li>
                                <div class="yamm-content p-t-0 p-r-0 p-l-0 p-b-0">
                                    <ul class="list-group m-b-0 b-b-0">
                                        <li class="list-group-item b-r-0 b-l-0 b-r-0 b-t-r-0 b-t-l-0 b-b-2 w-350">
                                            <small class="text-uppercase">
                                                <strong>Notifications</strong>
                                            </small>
                                            <a role="button" href="../apps/settings-edit.html" class="btn m-t-0 btn-xs btn-default pull-right">
                                                <i class="fa fa-fw fa-gear"></i>
                                            </a>
                                        </li>

                                        <!-- START Scroll Inside Panel -->
                                        <li class="list-group-item b-a-0 p-x-0 p-y-0 b-t-0">
                                            <div class="scroll-300 custom-scrollbar ps-container ps-theme-default" data-ps-id="6c88d4fc-b8ae-f440-0615-9d4c6dd92cc3">
                                                <a href="../pages/timeline.html" class="list-group-item b-r-0 b-t-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left">
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-circle-thin fa-stack-2x text-danger"></i>
                                                    <i class="fa fa-close fa-stack-1x fa-fw text-danger"></i>
                                                </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="m-t-0">
                                                                <span>You can't generate the sensor without parsing the mobile USB transmitter!</span>
                                                            </h5>
                                                            <p class="text-nowrap small m-b-0">
                                                                <span>23-Mar-2016, 12:57</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="../pages/timeline.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left">
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-circle-thin fa-stack-2x text-primary"></i>
                                                    <i class="fa fa-info fa-stack-1x text-primary"></i>
                                                </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="m-t-0">
                                                                <span>If we bypass the card, we can get to the IB driver through the 1080p RAM bus!</span>
                                                            </h5>
                                                            <p class="text-nowrap small m-b-0">
                                                                <span>16-Jan-2013, 08:48</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="../pages/timeline.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left">
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-circle-thin fa-stack-2x text-success"></i>
                                                    <i class="fa fa-check fa-stack-1x text-success"></i>
                                                </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="m-t-0">
                                                                <span>Try to bypass the TCP alarm, maybe it will transmit the back-end feed!</span>
                                                            </h5>
                                                            <p class="text-nowrap small m-b-0">
                                                                <span>26-Feb-2014, 05:14</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="../pages/timeline.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left">
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-circle-thin fa-stack-2x text-warning"></i>
                                                    <i class="fa fa-exclamation fa-stack-1x fa-fw text-warning"></i>
                                                </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="m-t-0">
                                                                <span>If we connect the card, we can get to the ADP feed through the mobile EXE program!</span>
                                                            </h5>
                                                            <p class="text-nowrap small m-b-0">
                                                                <span>03-Jan-2014, 04:48</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                        </li>

                                        <!-- END Scroll Inside Panel -->
                                        <li class="list-group-item b-a-0 p-x-0 p-y-0 r-a-0 b-b-0">
                                            <a class="list-group-item text-center b-r-0 b-b-0 b-l-0 b-r-b-r-0 b-r-b-l-0" href="../pages/timeline.html">
                                                See All Notifications <i class="fa fa-angle-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </li>
                        </ul>
                        <!-- END Notification Dropdown Menu -->

                    </li>
                    <!-- END Notification -->

                    <li class="dropdown hidden">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <i class="fa fa-lg fa-fw fa-envelope hidden-xs"></i>
                            <span class="hidden-sm hidden-md hidden-lg">Messages <span class="badge badge-info m-l-1">3</span></span>
                            <span class="label label-info label-pill label-with-icon hidden-xs">3</span>
                            <span class="fa fa-fw fa-angle-down hidden-lg hidden-md hidden-sm"></span>
                        </a>

                        <!-- START Messages Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-right p-t-0 b-t-0 p-b-0 b-b-0 b-a-0">
                            <li>
                                <div class="yamm-content p-t-0 p-r-0 p-l-0 p-b-0">
                                    <ul class="list-group m-b-0">
                                        <li class="list-group-item b-r-0 b-l-0 b-r-0 b-t-r-0 b-t-l-0 b-b-2 w-350">
                                            <small class="text-uppercase">
                                                <strong>Messages</strong>
                                            </small>
                                            <a role="button" href="../apps/new-email.html" class="btn m-t-0 btn-xs btn-default pull-right">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>

                                        <!-- START Scroll Inside Panel -->
                                        <li class="list-group-item b-a-0 p-x-0 p-y-0 b-t-0">
                                            <div class="scroll-200 custom-scrollbar ps-container ps-theme-default" data-ps-id="bf4e2a80-3860-1c90-3b82-9e069e0368f9">

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-t-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/spacewood_/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-danger b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>Braulio Stehr</span>
                                                                <small><span>04:15</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>At esse fugiat ea et vero vitae culpa repellendus.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/scottgallant/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-warning b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>Devan Nienow</span>
                                                                <small><span>02:17</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>Quisquam hic et impedit quaerat adipisci dolorem repellat.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/hermanobrother/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-success b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>Freeda Hegmann</span>
                                                                <small><span>11:01</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>Quisquam rem ipsa ratione est molestiae ullam.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/melvindidit/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-danger b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>Andrew Schultz</span>
                                                                <small><span>10:40</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>Enim nisi cum.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/vivekprvr/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-warning b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>John Robel</span>
                                                                <small><span>08:16</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>Consequatur nesciunt enim a cum.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <a href="../apps/email-details.html" class="list-group-item b-r-0 b-l-0">
                                                    <div class="media">
                                                        <div class="media-left media-middle">
                                                            <div class="avatar">
                                                                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/craigelimeliah/128.jpg" alt="Avatar">
                                                                <i class="avatar-status avatar-status-bottom bg-success b-gray-darker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body media-auto">
                                                            <h5 class="m-b-0 m-t-0">
                                                                <span>Howell Barton</span>
                                                                <small><span>02:55</span></small>
                                                            </h5>
                                                            <p class="m-t-0 m-b-0">
                                                                <span>Amet ipsam occaecati delectus consequatur cupiditate voluptatem perferendis facilis est.</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>

                                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                        </li>
                                        <!-- END Scroll Inside Panel -->

                                        <li class="list-group-item b-a-0 p-x-0 b-b-0 p-y-0 r-a-0">
                                            <a class="list-group-item text-center b-b-0 b-r-0 b-l-0 b-r-b-r-0 b-r-b-l-0" href="../apps/inbox.html">
                                                See All Messages <i class="fa fa-angle-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <!-- END Messages Dropdown Menu -->

                    </li>

                    @role('admin')
                        <li class="dropdown">
                            <a href="{{route('admin.index')}}">
                                <span class="m-r-1">Admin</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{route('admin.crafting.itemstyles')}}">Styles & Motifs</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.users.index')}}">Users</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.crafting-table.edit', [\App\Enum\CraftingType::BLACKSMITHING])}}">Crafting table</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.generate-slugs')}}">Generate slugs</a>
                                </li>
                            </ul>
                        </li>
                    @endrole

                    <li class="dropdown">
                        <a class="dropdown-toggle user-dropdown" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
                            <span class="m-r-1">{{Auth::user()->name}}</span>
                            <div class="avatar avatar-image avatar-sm avatar-inline loaded">
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header text-gray-lighter">
                                <strong class="text-uppercase">Account</strong>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
                <!-- END Right Side Navbar -->
            @else
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="{{route('contribute')}}" aria-expanded="false">
                            <span class="m-r-1">Contribute</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('login')}}" aria-expanded="false">
                            <span class="m-r-1">Login</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('register')}}" aria-expanded="false">
                            <span class="m-r-1">Register</span>
                        </a>
                    </li>

                </ul>
            @endif
        </div>

    </div>
</div>