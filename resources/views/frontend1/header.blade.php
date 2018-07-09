    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Static Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <link rel="icon" href="{{$basesite}}assets/frontend/favicon.ico">
        <link href="{{$basesite}}assets/backend/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{$basesite}}assets/frontend/css/reset.css" rel="stylesheet">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/accordion.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/select2.min.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/jquery.bxslider.css">
        <link rel="stylesheet" type="text/css" href="{{$basesite}}assets/frontend/css/nouislider.css">
        <link rel="stylesheet" type="text/css" href="{{$basesite}}assets/frontend/css/easy-responsive-tabs.css">
        <link rel="stylesheet" type="text/css" href="{{$basesite}}assets/frontend/css/daterangepicker.css" />
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/tooltipster.bundle.css">
        <link rel="stylesheet" type="text/css" href="{{$basesite}}assets/frontend/css/tooltipster-light2.min.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/style.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/dekstop.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/tablet.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/mobile.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/custom.css">
        <link rel="stylesheet" href="{{$basesite}}assets/frontend/css/jquery-ui.1.12.1.css">
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/jquery-ui.1.12.1.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/jquery.hideseek.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/moment.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/daterangepicker.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/TweenMax.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/select2.full.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/easyResponsiveTabs.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/tooltipster.bundle.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/nouislider.min.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/wNumb.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/js_lib.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/js_run.js"></script>
        <script type="text/javascript" src="{{$basesite}}assets/frontend/js/custom.js"></script>
        <style type="text/css">
            .ui-autocomplete .ui-menu-item {
                font-size: 11px;
            }
            .ui-autocomplete-category  {
                line-height: 1.5;
                padding: 10px;
                color: black;
                font-size: 12px;
                text-align: right;
                border-bottom: 1px solid #8A8A8A;
            }
            .ui-menu-item .ui-menu-item-wrapper {
                padding: 10px;
                background: none !important;
                border: none !important;
                color: black;
            }
            .ui-menu-item .ui-menu-item-wrapper:hover {
                padding: 11px;
                background-color: #EAEAEA !important;
            }
            .ui-menu-item .ui-menu-item-wrapper .Product img {
                height:40px !important;
            }
            .ui-menu-item .ui-menu-item-wrapper .Product .ProductNote {
                float: right;
                text-align: left;
                width:240px;
            }
            .ui-menu-item .ui-menu-item-wrapper .Product .ProductPrice {
                float: right;
                text-align: left;
                width:240px;
            }
            .ui-menu-item .ui-menu-item-wrapper .Product .ProductPrice span {
                color:#820000;
            }
            header .boxMenu nav > div:nth-child(1) .drop-box {
                width: 650px;
            }
            header .boxMenu nav > div:nth-child(2) .drop-box {
                width: 630px;
            }
            header .boxMenu nav > div:nth-child(3) .drop-box {
                width: 580px;
            }
            header .boxMenu nav > div:nth-child(4) .drop-box {
                width: 380px;
            }
            header .top_bar .lang .boxLanguage {
                background-color: white;
            }
            header .drop-box .sub_box .title {
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <span id="closeMenuMobile" class="closeMenuMobile">
        </span>        
        <div class="overlay_mob"></div>
        <header>
            <div class="top_bar after_clear">
                <div class="wrapper">
                    <div class="lang">
                        <a class="label_lang" href="javascript:;">ENG | IDR</a>
                        <div class="boxLanguage">
                            <div class="title">LANGUAGE</div>
                            <ul>
                                @if(isset($config['frontend']['lang']))
                                @foreach($config['frontend']['lang'] as $obj)
                                @if($obj['link'] == 'en')
                                    @php
                                        $obj['link'] = "";
                                        if($lang['frontend']['link'] != 'en') {
                                            $baseuri = ltrim($baseuri, $lang['frontend']['link'].'/');
                                        }
                                    @endphp
                                @else
                                    @php $obj['link'] .= "/" @endphp
                                @endif
                                <li>
                                    <a href="{{$realbasesite}}{{$obj['link']}}{{$baseuri}}">
                                        <img class="img-lang" src="{{$basesite}}assets/frontend/images/material/{{$obj['flag']}}" style="height: 16px;">
                                        <span>{{$obj['name']}}</span>
                                    </a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                            <div class="title">ALL PRICE IN</div>
                            <select id="selectcurrency" class="select">
                                @foreach($arrcurr as $obj)
                                @php $cur = "/cur_".$obj['Code'] @endphp
                                @if($obj['Code'] == 'IDR')
                                    @php $cur = "" @endphp
                                @endif
                                <option value="{{$realbasesite}}{{$baseuri}}{{$cur}}" @if(isset($getcur) and $getcur == $obj['Code']) selected @endif >{{$obj['Code']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <ul class="list_top after_clear">
                        @if(\Session::get('customerdata'))
                        <li class="kotaklaci"><a href="javascript:;" class="my_laci">{{\Session::get('customerdata')['ccustomername']}}</a>
                            <div class="boxLaci">
                                <div class="title"><a href="{{$basesite}}account">MY ACCOUNT</a></div>
                                <ul class="list1 after_clear">
                                    <li><a href="{{$basesite}}account">Profile Details</a></li>
                                    <li><a href="{{$basesite}}affiliate">Invite Friends/Credits</a></li>
                                </ul>
                                <ul class="list2 after_clear">
                                    <li><a href="{{$basesite}}order">My Orders</a></li>
                                    <li><a href="{{$basesite}}wallet">My Wallet</a></li>
                                    <li><a href="{{$basesite}}return">My Returns</a></li>
                                    <li><a href="{{$basesite}}wishlist">My Wishlist</a></li>
                                    <li><a href="{{$basesite}}favlabel">My Favourite Labels</a></li>
                                </ul>
                                <ul class="list3 after_clear">
                                    <li><a href="{{$basesite}}logout">Log out</a></li>
                                </ul>
                            </div>
                        </li>
                        @else
                        <li><a href="{{$basesite}}login">LOG IN</a></li>
                        @endif

                        <li class="shopping_bag"><a href="{{$basesite}}shopping-bag">SHOPPING BAG <span id="ViewCartCount1" class="badge" @if(!isset($ArrayViewCart)) style="display: none;" @endif >@if(isset($ArrayViewCart)){{count($ArrayViewCart)-1}}@endif</span> <span class="chart"></span></a>
                            <div class="boxShoppingBag" @if(!isset($ArrayViewCart)) style="display: none;" @endif>
                                <div class="title">MY SHOPPING BAG (<span id="ViewCartCount2">@if(isset($ArrayViewCart)){{count($ArrayViewCart)-1}}@endif</span> ITEMS)</div>
                                <div class="contentBag">
                                    <div id="ViewCart" class="contentScrollBag">
                                        @if(isset($ArrayViewCart))
                                        @foreach($ArrayViewCart as $key => $val)
                                        @if(is_numeric($key))
                                        <div class="listBag after_clear" id="{{$val['ProductLink']}}">
                                            <a href="javascript:;" class="remove_bag" data-id="{{$val['ProductLink']}}" onclick="RemoveHeader('{{$val['ProductLink']}}')">x</a>
                                            <div class="img">
                                                <img src="{{$basesite}}assets/frontend/images/content/product/small_{{$val['ProductImage']}}">
                                            </div>
                                            <div class="desc">
                                                <div class="titledesc">{{$val['ProductBrand']}}</div>
                                                <div class="textdesc">{{$val['ProductName']}}</div>
                                                <div class="otherdet">COLOR : {{$val['ProductColor']}}</div>
                                                <div class="otherdet">SIZE VARIANT : {{$val['ProductSize']}}</div>
                                                <div class="otherdet">Quantity : {{$val['ProductQty']}}</div>
                                                <div class="price">{{$val['ProductPrice']}}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="footerBag">
                                        <div class="totalBag after_clear">
                                            <div class="label">TOTAL</div>
                                            <div id="ViewCartTotal" class="price">@if(isset($ArrayViewCart)){{$ArrayViewCart['TotalPrice']}}@endif</div>
                                        </div>
                                        <div class="actionBag after_clear">
                                            <a href="{{$basesite}}shopping-bag" class="btn black">VIEW MY BAG</a>
                                            <a href="{{$basesite}}payment-method" class="btn red">BUY NOW</a>
                                        </div>
                                        <div class="descShipp">
                                            <div class="titleShipp">FREE SHIPPING</div>
                                            <div class="descShipp">WITH MINIMAL PURCHASE 300K</div>
                                            <a href="{{$basesite}}faq" class="more_info">More Info Here ></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="boxMenu">
                <div class="wrapper after_clear">
                    <div class="logo">
                        <a href="{{$basesite}}">
                            <img src="{{$basesite}}assets/frontend/images/material/logo.png" style="height:72px;">
                        </a>
                    </div>
                    <nav class="navMenu after_clear">
                    @php $loop1 = 1 @endphp
                    @foreach($arrmenu as $key => $val)
                        @if($val != 'SALE')
                        <div>
                            <a href="{{$basesite}}{{strtolower($key)}}" class="ico-{{$loop1}}">{{$key}}</a>
                            <span class="ico hasChild" data-child="drop_{{strtolower($key)}}"></span>
                            <div class="drop-box" id="drop_{{strtolower($key)}}">
                            @php $loop2 = 0 @endphp
                            @foreach($val as $keys => $vals)
                                @if($loop2 != count($val) - 1)
                                @php $style = "" @endphp
                                @if(key($vals) == 'CATEGORIES' and strtolower($key) == 'women')
                                    @php $style = "margin-right: 0px;" @endphp
                                @elseif(key($vals) == 'CATEGORIES' and (strtolower($key) == 'men' or strtolower($key) == 'kids'))
                                    @php $style = "margin-right: 40px;" @endphp
                                @endif
                                <div class="sub_box" @if(key($vals) == 'CATEGORIES') style="{{$style}}" @endif>
                                @php $i = 0 @endphp
                                @foreach($vals as $tmpkeys => $tmpvals)
                                @if($tmpvals['Name'] == 'CATEGORIES')
                                <div class="title" @if($i > 0) style="margin-top: 20px;" @endif>{{$tmpvals['Name']}}</div>
                                @else
                                @php
                                    $tmpvalsname = $tmpvals['Name'];
                                    $arrlist = ['New Born', 'Baby Girl', 'Baby Boy', 'Girl Size', 'Boy Size'];
                                    $check = $inv->_strposarr($tmpvalsname, $arrlist, false);
                                    if($check) {
                                        $tmpvalsname = $check.' <span style="font-family: \'robotoreguler\' !important; text-transform: none !important;">'.str_replace($check, '', $tmpvals['Name']).'</span>';
                                    }
                                    $SubMenu = '';
                                    if(isset($tmpvals['SubMenu']) && count($tmpvals['SubMenu'])) {
                                        $SubMenu = '['.implode(',', array_column($tmpvals['SubMenu'], 'Permalink')).']';
                                    }
                                @endphp
                                <div class="title" @if($i > 0) style="margin-top: 20px;" @endif><a href="@if(strtolower($key) != 'labels'){{$basesite}}{{strtolower($key)}}/detail/category_[{{$tmpvals['Permalink']}}{{$SubMenu}}] @else{{$tmpvals['Permalink']}}@endif">{!!$tmpvalsname!!}</a></div>
                                @endif
                                @if(isset($tmpvals['SubMenu']))
                                    <ul>
                                    @foreach($tmpvals['SubMenu'] as $keylast => $vallast)
                                        @if(strtolower($key) != 'labels')
                                        @if($vallast['Permalink'] == 'view-all')
                                        <li><a href="{{$basesite}}{{strtolower($key)}}/detail">{{$vallast['Name']}}</a></li>
                                        @elseif($vallast['Permalink'] == 'new-arrivals')
                                        <li><a href="{{$basesite}}{{strtolower($key)}}/detail/select_{{$vallast['Permalink']}}">{{$vallast['Name']}}</a></li>
                                        @elseif($vallast['Permalink'] == 'sale' or $vallast['Permalink'] == 'most-wanted')
                                        <li><a href="{{$basesite}}{{strtolower($key)}}/detail/sort_{{$vallast['Permalink']}}" @if($vallast['Permalink'] == 'sale')style="color: red"@endif>{{$vallast['Name']}}</a></li>
                                        @else
                                        <li><a href="{{$basesite}}{{strtolower($key)}}/detail/category_[{{$tmpvals['Permalink']}}[{{str_replace($tmpvals['Permalink'].'-', '', $vallast['Permalink'])}}]]">{{$vallast['Name']}}</a></li>
                                        @endif
                                        @else
                                        <li><a href="{{$basesite}}labels/style_[{{$vallast['Permalink']}}]">{{$vallast['Name']}}</a></li>
                                        @endif
                                    @endforeach
                                    </ul>
                                @endif
                                @php $i = $i + 1 @endphp
                                @endforeach
                                </div>
                                @else
                                <div id="linemenu" class="sub_box" style="border-left:1px solid #000;padding:0px;padding-left:20px;margin:0px;">
                                </div>
                                <div class="sub_box">
                                @php $i = 0 @endphp
                                @foreach($vals as $tmpkeys => $tmpvals)
                                <div class="title" @if($i > 0) style="margin-top: 20px;" @endif><a href="{{$basesite}}{{$tmpvals['Permalink']}}">{{$tmpvals['Name']}}</a></div>
                                @if(isset($tmpvals['SubMenu']))
                                    <ul>
                                    @foreach($tmpvals['SubMenu'] as $keylast => $vallast)
                                        @if($vallast['Permalink'] != 'sale')
                                        @php $main = '/main_'.strtolower($key) @endphp
                                        @if(strtolower($key) == 'labels')
                                        @php $main = '' @endphp
                                        @endif
                                        @if(strpos($tmpvals['Name'], 'FEATURE') !== false)
                                        <li><a href="{{$basesite}}feature/id_{{$vallast['Permalink']}}{{$main}}">{{$vallast['Name']}}</a></li>
                                        @elseif(strpos($tmpvals['Name'], 'ARTIST') !== false)
                                        <li><a href="{{$basesite}}artist/id_{{$vallast['Permalink']}}{{$main}}">{{$vallast['Name']}}</a></li>
                                        @elseif(strpos($tmpvals['Name'], 'INDIE') !== false)
                                        <li><a href="{{$basesite}}indie/id_{{$vallast['Permalink']}}{{$main}}">{{$vallast['Name']}}</a></li>
                                        @endif
                                        @else
                                        <li><a href="{{$basesite}}sale/main_{{strtolower($key)}}" style="color: red">{{$vallast['Name']}}</a></li>
                                        @endif
                                    @endforeach
                                    </ul>
                                @endif
                                @php $i = $i + 1 @endphp
                                @endforeach
                                </div>
                                @endif
                                @php $loop2 = $loop2 + 1 @endphp
                            @endforeach
                            </div>
                        </div>
                        @else
                        <div>
                            <a href="{{$basesite}}{{strtolower($val)}}" class="ico-{{$loop1}}">{{$val}}</a>
                        </div>
                        @endif
                        @php $loop1 = $loop1 + 1 @endphp
                    @endforeach
                    </nav>
                    <div class="boxNewMenu after_clear">
                        <a href="javascript:;" class="toggle">MENU <span></span></a>
                    </div>
                    <div class="boxSearch">
                        <input name="SearchLacigue" class="text" placeholder="Search Lacigue">
                    </div>
                </div>
            </div>
            <input id="basesite" value="{{$basesite}}" style="display:none;">
        </header>
        <script type="text/javascript">
            function RemoveHeader(ID) {
                $('#popup .titlenew').contents()[0].nodeValue = 'Remove ?';

                var contentnew = 
                '<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
                    '<div class="control-label colorred">Anda yakin akan menghapus ?</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
                '</div></div>';

                $('#popup .contentnew').css('height', 'auto');
                $('#popup .contentnew').html(contentnew);

                openPopup('popup');

                $("#btnok").on('click', function() {
                    $.ajax({
                        url         : '{{$basesite}}shopping-bag/ajaxpost',
                        type        : 'POST',
                        data        : {'ajaxpost':"Remove",'_token':'{{csrf_token()}}','ID':ID},
                        success     : function(data) {
                            var data = JSON.parse(data);
                            if(data['response'] == 'OK') {
                                location.href = '{{$basesite}}shopping-bag';
                            } else {
                                var messageerror = '';
                                $.each(data['data']['error'], function(keys, vals) {
                                    messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
                                });
                                _alertvalidation(messageerror);
                            }
                        }
                    });
                });

                $("#btncancel").on('click', function() { closePopup('popup'); });
            }
       </script> 