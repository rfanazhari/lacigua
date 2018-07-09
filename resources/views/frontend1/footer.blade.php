        <style type="text/css">
            footer .foot-info .box {
                margin-right: 53px;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{$basesite}}assets/frontend/css/starability-minified/starability-all.min.css"/>
        <div class="wrap-popup" id="popup-track">
            <div class="overlay-pop2"></div>
            <div class="box-popup type_2 pop_track" style="max-width: 880px;">
                <div class="title">LACAK PESANAN ANDA
                    <span class="closepop">x</span>
                </div>
                <div class="content" style="height: 210px;">
                    <div class="boxForm" style="width: 80%;">
                        <div class="form-group">
                            <label class="control-label " for="OrderID" style="width: 100%;display: inline-block;text-align: center;">Silahkan Isi No. Order Anda</label>
                        </div>
                        <div class="form-group">
                            <div class="control-input" style="width: 100%;display: inline-block;">
                                <input type="text" class="form-control boldtext" id="OrderID" name="OrderID">
                                <span class="note tooltip" data-tooltip-content="#tooltip-content-lacak" data-tooltipster='{"side":"right","animation":"fade","maxWidth":"310", "trigger": "click", "theme": ["tooltipster-noir","tooltipster-noir-customized"]}' style="cursor: pointer">Apa itu No.Order?</span>

                                <div class="tooltip-template">
                                    <div id="tooltip-content-lacak">
                                        <p>Nomer Order/ Nomor Pesanan terdiri dari 16 digit nomor yang Anda terima ketika Anda mengkonfirmasi pesanan Anda. CONTOH: EMRKAG1509134417</p>
                                        <p>Anda dapat menemukan ID Pesanan Anda di email Anda (dikirim secara otomatis setelah pesanan konfirmasi).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="boxButton" style="margin-left: 0px;text-align: center;">
                                <button type="button" id="tracking" class="btn black" style="padding: 0 15px;height: 40px;line-height: 40px;">LACAK PESANAN</button>
                            </div>
                        </div>         
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-popup" id="popup-std2">
            <div class="overlay-pop2"></div>
            <div class="box-popup type_2 track_order" style="max-width: 880px">
                <div class="title">LACAK PESANAN ANDA
                    <span class="closepop">x</span>
                </div>
                <div class="content" style="height: auto;">
                    <div class="boxForm after_clear" style="width: 80%;">
                        <label class="control-text " style="width: 100%;display: inline-block;text-align: center;">Informasi lebih lanjut, hubungi team <br/>Customer Service kami di no. telp +62 22 751 4100.<br/>Senin - Jumat : 08.00-17.30 WIB</label> 
                        <label class="control-text " style="width: 100%;display: inline-block;text-align: center;">
                            <div class="no_order">NO ORDER : <span id="TransactionCode">BDG2310171155356</span></div>
                            <div class="tgl_order">TANGGAL PEMESANAN : <span id="CreatedDate">24/10/2017</span></div>
                        </label>    
                    </div>
                    <div id="ListOrder" class="boxtrackMulti boxTrack after_clear">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-popup" id="popup-feedback">
            <div class="overlay-pop2"></div>
            <div class="box-popup type_2 feedback" style="max-width: 550px;">
                <div class="title" style="letter-spacing: 2px;">FEEDBACK
                    <span class="closepop">x</span>
                </div>
                <div class="content" style="height: auto;">
                    <div class="boxForm">
                        <div class="form-horizontal">
                            <div class="contentScrollFeedback">
                            </div>
                            <div class="form-group">        
                                <div class="boxButton">
                                    <button id="submitfeedback" type="submit" class="btn">SUBMIT FEEDBACK</button>
                                </div>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-popup" id="popup">
            <div class="overlay-pop2"></div>
            <div class="box-popup type_2 pop_track">
                <div class="titlenew">
                    <span class="closepop">x</span>
                </div>
                <div class="contentnew"></div>           
            </div>
        </div>
        <div class="wrap-popup" id="popupnext">
            <div class="overlay-pop2"></div>
            <div class="box-popup type_2 pop_track">
                <div class="titlenew">
                    <span class="closepop">x</span>
                </div>
                <div class="contentnew"></div>           
            </div>
        </div>
        <footer>
            <div class="wrapper">
                <div class="foot-info after_clear">
                    <div class="box">
                        <div class="title">DELIVERY SERVICE</div>
                        <div class="img">
                            <span class="helper"></span>
                            <img src="{{$basesite}}assets/frontend/images/material/delivery.png" style="height:35px">
                        </div>
                        <div class="text">
                            <p>
                                FREE DELIVERY OVER IDR 300K <br/>
                                1-3 DAYS EXPRESS DELIVERY 
                                (INDONESIA ONLY)<br/>
                                2-5 DAY INTERNATIONAL <br/>
                                DELIVERY
                            </p>
                        </div>
                        <div class="visit">
                            <a href="{{$basesite}}delivery-service" class="btn">MORE INFO</a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title">TRACK MY ORDER</div>
                        <div class="img">
                            <span class="helper"></span>
                            <img src="{{$basesite}}assets/frontend/images/material/track.png" style="height:45px">
                        </div>
                        <div class="text">
                            <p>
                                WORRIED ABOUT ITS WHEREABOUTS,<br/>
                                YOU'LL FIND YOUR DELIVERY <br/>
                                NUMBER & TRACK YOUR ORDERS <br/>
                                IN EASY WAY RIGHT HERE!
                            </p>
                        </div>
                        <div class="visit">
                            <a href="javascript:;" onclick="TrackMyOrder()" class="btn">MORE INFO</a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title">INVITE FRIENDS</div>
                        <div class="img">
                            <span class="helper"></span>
                            <img src="{{$basesite}}assets/frontend/images/material/invite.png" style="height:50px">
                        </div>
                        <div class="text">
                            <p>
                                INVITE YOUR FRIEND AND ENJOY <br/>
                                SHOPPING VOUCHER IDR 200K<br/>
                                WHEN WHEN HE MADE THE <br/>
                                FIRST PURCHASE
                            </p>
                        </div>
                        <div class="visit">
                            <a href="javascript:;" onclick="GoAffiliate()" class="btn">MORE INFO</a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="title">CONTACT US</div>
                        <div class="img">
                            <span class="helper"></span>
                            <img src="{{$basesite}}assets/frontend/images/material/contact.png" style="height:50px">
                        </div>
                        <div class="text">
                            <p>
                                ID  022 751 4100<br/>
                                INT: + 61 3 9420 7971<br/>
                                MON - FRI : 8AM - 5PM
                            </p>
                        </div>
                        <div class="visit">
                            <a href="{{$basesite}}contact" class="btn">MORE INFO</a>
                        </div>
                    </div>
                </div>
                <hr>
                <hr style="margin-top: -5px;">
                <div class="foot-map after_clear">
                    <div class="boxMap">
                        <div class="title">ABOUT LACIGUE</div>
                        <ul>
                            <li><a href="{{$basesite}}our-story">OUR STORY</a></li>
                            @if(\Session::get('customerdata'))
                            <li><a href="{{$basesite}}account">MY LACI</a></li>
                            @endif
                            <li><a href="{{$basesite}}contact">CUSTOMER SERVICE</a></li>
                            <li><a href="{{$basesite}}careers">CAREERS</a></li>
                            <li><a href="{{$basesite}}faq">FAQ</a></li>
                            <li><a href="{{$basesite}}seller-partners">SELLER PARTNERS</a></li>
                            <li><a href="{{$basesite}}privacy-cookies">PRIVACY & COOKIES</a></li>
                            <li><a href="{{$basesite}}term-condition">TERM & CONDITION</a></li>
                        </ul>
                    </div>
                    <div class="boxMap">
                        <div class="title">SERVICE</div>
                        <ul>
                            <li><a href="{{$basesite}}how-to-shop">HOW TO SHOP</a></li>
                            <li><a href="{{$basesite}}delivery-returns">DELIVERY RETURNS</a></li>
                            <li><a href="{{$basesite}}gift-card">GIFT CARD & VOUCHER</a></li>
                            <li><a href="{{$basesite}}">SIZE GUIDE</a></li>
                            <li><a href="{{$basesite}}product-index">PRODUCT INDEX</a></li>
                            <li><a href="{{$basesite}}transfer-confirmation">TRANSFER CONFIRMATION</a></li>
                            <li><a href="{{$basesite}}promo-partner">PROMO PARTNER</a></li>
                            <li><a href="javascript:;" onclick="GoAffiliate()">LACIGUE AFFILIATE</a></li>
                        </ul>
                    </div>
                    <div class="boxMap">
                        <div class="title">SUBSCRIBE & GET {{$inv->_formatamount($DataSetting->SubscribeAmount, 'Rupiah', 'IDR ')}} SHOPPING VOUCHER!</div>
                        <div class="subtitle">Be the first to receive the hottest offers, sales & latest looks.</div>
                        <div class="boxSubscribe">
                            <input class="subscribe" type="email" name="subscribeemail" placeholder="Enter your email address here">
                        </div>
                        <div class="boxGender after_clear" style="margin-top: 15px;">
                            <a href="javascript:;" onclick="Subscribe('MEN')" class="btn black small">MEN</a>
                            <a href="javascript:;" onclick="Subscribe('WOMEN')" class="btn black small">WOMEN</a>                        
                        </div>
                        <div class="title" style="margin-top: 40px;">
                            QUESTION? CLICK HERE CHAT WITH US
                        </div>
                        <div class="live_chat">
                            <a href="javascript:;">
                                <img src="{{$basesite}}assets/frontend/images/material/live_chat.png" style="height: 50px;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="foot-social">
                    <div class="title social_link">
                        <a href="javascript:;">CONNECT WITH <br/> LACIGUE SOCIAL</a>
                    </div>
                    <ul class="after_clear soc_btn">
                        @foreach($ArrSocialMedia as $obj)
                        <style type="text/css">.new{{$obj['ID']}} { background: url({{$basesite}}assets/frontend/images/content/iconsocialmedia/{{$obj['IconSocialMediaImage']}}) no-repeat center center; } .new{{$obj['ID']}}:hover { background: url({{$basesite}}assets/frontend/images/content/iconsocialmedia/{{$obj['IconSocialMediaImageHover']}}) no-repeat center center; }</style>
                        <li><a href="{{$obj['Link']}}" target="_blank" class="new{{$obj['ID']}}">{{$obj['Name']}}</a></li>
                        @endforeach
                    </ul>
                    <div class="info_bank">
                        <div class="bank_all" style="margin-top: 10px;">
                            <a href="{{$basesite}}">
                                <img src="{{$basesite}}assets/frontend/images/material/bank_all.png" style="height: 25px;">
                            </a>
                        </div>
                        <div class="copy">
                            <p>© 2016. LACIGUE LTD. All Right Reserved</p>
                        </div>                  
                    </div>
                </div>
            </div>
        </footer>
        <script type="text/javascript">

            // var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            // (function(){
            // var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            // s1.async=true;
            // s1.src='https://embed.tawk.to/5a73ebded7591465c7074ef3/default';
            // s1.charset='UTF-8';
            // s1.setAttribute('crossorigin','*');
            // s0.parentNode.insertBefore(s1,s0);
            // })();

            function Subscribe(obj) {
                $.ajax({
                    url         : '{{$basesite}}api/insert',
                    type        : 'POST',
                    data        : {'ajaxpost':"Subscribe", 'Email':$('[name="subscribeemail"]').val(), 'Subscribe':obj},
                    success     : function(data) {
                        var data = JSON.parse(data);

                        if(data['response'] == 'OK') {
                            $('[name="subscribeemail"]').val('');
                            _alertvalidation('Subscribe success');
                        } else {
                            var messageerror = '';
                            $.each(data['data']['error'], function(keys, vals) {
                                messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
                            });
                            _alertvalidation(messageerror);
                        }
                    }
                });
            }

            $(document).ready(function() {
                $('.tooltip').tooltipster({
                    functionInit: function(instance, helper) {
                        var $origin = $(helper.origin),
                            dataOptions = $origin.attr('data-tooltipster');

                        if(dataOptions) {
                            dataOptions = JSON.parse(dataOptions);

                            $.each(dataOptions, function(name, option){
                                instance.option(name, option);
                            });
                        }
                    },
                    'interactive': true,
                    'contentAsHTML': true,
                    'autoClose': true,
                    'onlyOne': true,
                });
            });

            $('[name="SearchLacigue"]').focus(function() {
                $(this).animate({
                    width: 250
                }, 400 );
            }); 

            $('[name="SearchLacigue"]').blur(function() {
                $(this).animate({
                    width: 190
                }, 500 );
            });

            $('[name="SearchLacigue"]').bind("keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
            }).autocomplete({
                html: true,
                minLength: 1,
                source: function( request, response ) {
                    $.ajax({
                        url         : '{{$basesite}}api/checking',
                        type        : 'POST',
                        data        : {'ajaxpost':"SearchLacigue", 'search':$('[name="SearchLacigue"]').val()},
                        success     : function(data) {
                            var data = JSON.parse(data);

                            if(data['response'] != 'error') {
                                response($.map(data['response'], function (item) {
                                    var AC = new Object();

                                    AC.label = item.LabelName;
                                    AC.price = item.LabelPrice;
                                    AC.oldprice = item.LabelOldPrice;
                                    AC.img = item.ImageSrc;
                                    AC.value = item.ID;
                                    AC.link = item.LabelLink;
                                    AC.category = item.CategoryList;

                                    AC.ID = item.ID;

                                    return AC;
                                }));
                            } else {
                                $("ul#ui-id-1").hide();
                            }
                        }
                    });
                },
                create: function () {
                    $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                        var t = String(item.label).replace( new RegExp(this.term, "gi"), "<strong>$&</strong>");
                        if(typeof item.img != 'undefined') {
                            var price = "<div class='ProductPrice'>" + _formatamount(item.price, 'Rupiah', 'Rp. ');
                            if(item.oldprice)
                                price = price + " <span>Sebelumnya " + _formatamount(item.oldprice, 'Rupiah', 'Rp. ') + "</span>";
                            price = price + "</div>";

                            t = "<div class='Product'>" +
                                    "<img src='"+item.img+"'>" +
                                    "<div class='ProductNote'>" + t + 
                                        price + 
                                    "</div>" +
                                "</div>";
                        }
                        return $("<li onclick='GoTo(\"" + item.link + "\")'></li>").data("item.autocomplete", item).append("<div>" + t + "</div>").appendTo(ul);
                    };
                    $(this).data('ui-autocomplete')._renderMenu = function (ul, items) {
                        var self = this, currentCategory = "";
                        $.each( items, function( index, item ) {
                            if ( item.category != currentCategory ) {
                                ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                                currentCategory = item.category;
                            }
                            self._renderItem( ul, item );
                        });
                    };
                },
                search: function(e,ui){
                    $(this).data("ui-autocomplete").menu.bindings = $();
                },
                open: function() {
                    $("ul.ui-menu").width( $(this).innerWidth() );
                },
                select: function (event, ui) {                    
                    $('[name="SearchLacigue"]').val(ui.item.label);
                }
            }).focus(function () {
                $(this).autocomplete("search");
                $('[name="SearchLacigue"]').autocomplete({
                    autoFocus: true
                })
            });

            function GoTo(url) {
                window.location.href = url;
            }

            function _alertvalidation(messageerror) {
                $('#popup .titlenew').contents()[0].nodeValue = 'PESAN';

                var contentnew = 
                '<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
                    messageerror +
                '</div>';

                $('#popup .contentnew').css('height', 'auto');
                $('#popup .contentnew').html(contentnew);

                openPopup('popup');
            }

            function _formatamount(amount, currency = 'Dollar', symbol = '') {
                var newamount = '';        
                var amountrev = amount.toString().split('').reverse().join('');
                if(currency != 'Dollar') {
                    for(var i = 0; i < amountrev.length; i++) if(i%3 == 0) newamount += amountrev.substr(i,3)+'.';
                } else {
                    for(var i = 0; i < amountrev.length; i++) if(i%3 == 0) newamount += amountrev.substr(i,3)+',';
                }
                return (symbol?symbol:'')+newamount.split('',newamount.length-1).reverse().join('');
            }

            function GoAffiliate() {
                $.ajax({
                    url         : '{{$basesite}}api/checking',
                    type        : 'POST',
                    data        : {'ajaxpost':"CheckLogin"},
                    success     : function(data) {
                        var data = JSON.parse(data);
                        
                        if(data['response'] == 'OK') {
                            window.location.href = '{{$basesite}}affiliate';
                        } else {
                            $('#popup .titlenew').contents()[0].nodeValue = 'Daftar atau Login';

                            var contentnew = 
                            '<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
                                '<div class="control-label colorred">' + data['response'] + '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
                            '</div></div>';

                            $('#popup .contentnew').css('height', 'auto');
                            $('#popup .contentnew').html(contentnew);

                            openPopup('popup');

                            $("#btnok").on('click', function() { window.location.href = '{{$basesite}}login'; });
                            $("#btncancel").on('click', function() { closePopup('popup'); });
                        }
                    }
                });
            }

            function TrackMyOrder() {
                openPopup('popup-track');

                $('[name="OrderID"]').focus();

                var check = false;
                $("#tracking").on('click', function() {
                    var OrderID = $('[name="OrderID"]').val();

                    if(OrderID) {
                        if(!check) {
                            $.ajax({
                                url         : '{{$basesite}}api/checking',
                                type        : 'POST',
                                data        : {'ajaxpost':"TrackMyOrder", 'OrderID':OrderID},
                                success     : function(data) {
                                    var data = JSON.parse(data);
                                    if(data['response'] == 'OK') {
                                        check = true;
                                        var ListOrder = '';

                                        $.each(data['OrderTransaction'], function(keys1, vals1) {
                                            $('#TransactionCode').html(vals1['TransactionCode']);
                                            var CreatedDate = vals1['CreatedDate'].split(/[- :]/);
                                            CreatedDate = new Date(Date.UTC(CreatedDate[0], CreatedDate[1]-1, CreatedDate[2], CreatedDate[3], CreatedDate[4], CreatedDate[5]));
                                            $('#CreatedDate').html(("0" + CreatedDate.getDate()).slice(-2)  + "/" + ("0"+(CreatedDate.getMonth()+1)).slice(-2) + "/" + CreatedDate.getFullYear());

                                            $.each(vals1['ListSeller'], function(keys2, vals2) {
                                                ListOrder = ListOrder + '<div class="boxtrackMultiInner">';

                                                var ListProduct = '';
                                                $.each(vals2['ListProduct'], function(keys3, vals3) {
                                                    var ProductPrice = vals3['ProductPrice'];
                                                    if(vals1['CurrencyCode'] == 'IDR')
                                                        ProductPrice = _formatamount(ProductPrice, 'Rupiah', vals1['CurrencyCode'] + ' ');
                                                    else
                                                        ProductPrice = _formatamount(ProductPrice, 'Dollar', vals1['CurrencyCode'] + ' ');

                                                    ListProduct = ListProduct + '<div class="boxTrackInner after_clear">' +
                                                                                '<div class="detail">' +
                                                                                    '<div class="detail_inner after_clear">' +
                                                                                        '<div class="det1">' +
                                                                                            '<img src="{{$basesite}}assets/frontend/images/content/product/medium_' + vals3['Image1'] + '">' +
                                                                                        '</div>' +
                                                                                        '<div class="det1">' +
                                                                                            '<div class="name" style="width:250px">' + vals3['BrandName'].toUpperCase() + '</div>' +
                                                                                            '<div class="desc" style="width:250px">' + vals3['Name'].toUpperCase() + '</div>' +
                                                                                            '<div class="price">' +
                                                                                                ProductPrice +
                                                                                            '</div>' +
                                                                                            '<table class="other_det">' +
                                                                                                '<tr>' +
                                                                                                    '<td style="width: 80px;">COLOR</td>' +
                                                                                                    '<td>' + vals3['ColorName'] + '</td>' +
                                                                                                '</tr>' +
                                                                                                '<tr>' +
                                                                                                    '<td>SIZE</td>' +
                                                                                                    '<td>' + vals3['SizeName'] + '</td>' +
                                                                                                '</tr>' +
                                                                                                '<tr>' +
                                                                                                    '<td>Quantity</td>' +
                                                                                                    '<td>' + vals3['Qty'] + '</td>' +
                                                                                                '</tr>' +
                                                                                            '</table>' +
                                                                                        '</div>' +
                                                                                    '</div>' +
                                                                                '</div>' +
                                                                            '</div>';
                                                });

                                                var ShippingDate = '';
                                                if(vals2['StatusShipment'] == 0)
                                                    ShippingDate = vals2['CreatedDate'].toString().trim();
                                                else
                                                    ShippingDate = vals2['UpdatedDate'].toString().trim();

                                                ShippingDate = ShippingDate.substring(0, (ShippingDate.length - 3));

                                                var ImageProcess, CSSProcess = '';
                                                if(vals2['StatusShipment'] >= 0) {
                                                    ImageProcess = '<img src="{{$basesite}}assets/frontend/images/material/proses_done.png" alt="Proses">';
                                                    CSSProcess = 'done';
                                                } else {
                                                    ImageProcess = '<img src="{{$basesite}}assets/frontend/images/material/proses.png" alt="Proses">';
                                                    CSSProcess = '';
                                                }

                                                var ImagePacking, CSSPacking = '';
                                                if(vals2['StatusShipment'] >= 1) {
                                                    ImagePacking = '<img src="{{$basesite}}assets/frontend/images/material/packing_done.png" alt="Proses">';
                                                    CSSPacking = 'done';
                                                } else {
                                                    ImagePacking = '<img src="{{$basesite}}assets/frontend/images/material/packing.png" alt="Proses">';
                                                    CSSPacking = '';
                                                }

                                                var ImageShipped, CSSShipped = '';
                                                if(vals2['StatusShipment'] >= 2) {
                                                    ImageShipped = '<img src="{{$basesite}}assets/frontend/images/material/kirim_done.png" alt="Proses">';
                                                    CSSShipped = 'done';
                                                } else {
                                                    ImageShipped = '<img src="{{$basesite}}assets/frontend/images/material/kirim.png" alt="Proses">';
                                                    CSSShipped = '';
                                                }

                                                var ImageDone, CSSDone = '';
                                                if(vals2['StatusShipment'] >= 3) {
                                                    ImageDone = '<img src="{{$basesite}}assets/frontend/images/material/selesai_done.png" alt="Proses">';
                                                    CSSDone = 'done';
                                                } else {
                                                    ImageDone = '<img src="{{$basesite}}assets/frontend/images/material/selesai.png" alt="Proses">';
                                                    CSSDone = '';
                                                }

                                                var AWBNumber = '';
                                                if(vals2['StatusShipment'] >= 2) {
                                                    AWBNumber = 'NO RESI : ' + vals2['AWBNumber'];
                                                }

                                                var ButtonAlreadyShipped = '';
                                                if(vals2['StatusShipment'] == 2) {
                                                    ButtonAlreadyShipped = '<a id="' + vals2['TransactionSellerCode'] + '" href="javascript:;" class="btn small" onclick="_alertvalidation(\'Silahkan check nomor resi anda di website resmi ' + vals2['ShippingName'] + ' : <b>' + vals2['AWBNumber'] + '</b>\')">Lacak Pesanan</a>' +
                                                        '<a id="' + vals2['TransactionSellerCode'] + '" href="javascript:;" class="btn small" onclick="DeliveryTransaction(\'' + vals2['TransactionSellerCode'] + '\')">Sudah Terima</a>';
                                                }

                                                ListOrder = ListOrder + ListProduct + '</div>' +
                                                            '<div class="boxtrackMultiInner">' +
                                                                '<div class="boxTrackInner">' +
                                                                    '<div class="status">' +
                                                                        '<div id="status' + vals2['TransactionSellerCode'] + '" class="label_status">' +
                                                                            'Status Pesanan : <span>' + data['ArrShippingStatus'][vals2['StatusShipment']] + '</span>' +
                                                                        '</div>' +
                                                                        '<div id="date' + vals2['TransactionSellerCode'] + '" class="tgl_status">' +
                                                                            (ShippingDate).toString() +
                                                                        '</div>' +
                                                                        '<div class="shipment after_clear">' +
                                                                            '<div class="confirm '+ CSSProcess +'">' +
                                                                                '<div class="imgcircle">' +
                                                                                    ImageProcess +
                                                                                '</div>' +
                                                                                '<span class="line"></span>' +
                                                                            '</div>' +
                                                                            '<div class="packing '+ CSSPacking +'">' +
                                                                                '<div class="imgcircle">' +
                                                                                    ImagePacking +
                                                                                '</div>' +
                                                                                '<span class="line"></span>' +
                                                                            '</div>' +
                                                                            '<div class="delivery '+ CSSShipped +'">' +
                                                                                '<div class="imgcircle">' +
                                                                                    ImageShipped +
                                                                                '</div>' +
                                                                                '<span class="line"></span>' +
                                                                            '</div>' +
                                                                            '<div id="done' + vals2['TransactionSellerCode'] + '" class="selesai '+ CSSDone +'">' +
                                                                                '<div class="imgcircle">' +
                                                                                    ImageDone +
                                                                                '</div>' +
                                                                            '</div>' +
                                                                        '</div>' +
                                                                        '<div class="no_resi">' +
                                                                            AWBNumber +
                                                                        '</div>' +
                                                                        '<div class="buttonAction after_clear">' +
                                                                            ButtonAlreadyShipped +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                            '</div>';
                                            });
                                        });

                                        $('#ListOrder').html(ListOrder);
                                        closePopup('popup-track');
                                        openPopup('popup-std2');
                                    } else {
                                        var messageerror = '';
                                        $.each(data['error'], function(keys, vals) {
                                            messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
                                        });
                                        _alertvalidation(messageerror);
                                    }
                                }
                            });
                        }
                    } else $('[name="OrderID"]').attr('style', 'border: 1px solid red;');
                });
            }

            function DeliveryTransaction(ID) {
                $('#popup .titlenew').contents()[0].nodeValue = 'PESAN';

                var contentnew = 
                '<div class="boxFormInline register after_clear" style="width: 100%; margin-top: 0px;"><div class="form-group">' +
                    '<div class="control-label colorred">Anda telah menerima barang anda ?</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<button id="btnok" class="btn black" style="top: auto;">OK</button> <button id="btncancel" class="btn white" style="top: auto;">Cancel</button>' +
                '</div></div>';

                $('#popup .contentnew').css('height', 'auto');
                $('#popup .contentnew').html(contentnew);

                openPopup('popup');

                $("#btnok").on('click', function() {
                    var check = false;
                    $.ajax({
                        url         : '{{$basesite}}api/update',
                        type        : 'POST',
                        data        : {'ajaxpost':"DeliveryTransaction",'_token':'{{csrf_token()}}','ID':ID},
                        success     : function(data) {
                            var data = JSON.parse(data);
                            if(data['response'] == 'OK') {
                                closePopup('popup');

                                if(data['data']['OrderTransactionDetail']) {
                                    var contentfeedback = '';

                                    $.each(data['data']['OrderTransactionDetail'], function(keys, vals) {
                                        contentfeedback = contentfeedback + '<div class="boxFeedBackSend after_clear">' +
                                            '<div class="imgProd">' +
                                                '<img style="height:211px;" src="{{$basesite}}assets/frontend/images/content/product/medium_'+vals['ProductImage']+'">' +
                                            '</div>' +
                                            '<div class="listGiveRating">' +
                                                '<div class="listGiveRatingInner after_clear">' +
                                                    '<div class="label">Accuration</div>' +
                                                    '<div class="rating-stars text-center">' +
                                                        '<fieldset class="starability-slot" style="min-height:auto !important;">' +
                                                            '<input type="radio" id="no-rate" class="input-no-rate" name="ratingAccuration'+vals['ID']+'" value="0" checked aria-label="No rating." />' +
                                                            '<input title="Poor" type="radio" id="rate1Accuration'+vals['ID']+'" name="ratingAccuration'+vals['ID']+'" value="1" />' +
                                                            '<label for="rate1Accuration'+vals['ID']+'">1 star.</label>' +
                                                            '<input title="Fair" type="radio" id="rate2Accuration'+vals['ID']+'" name="ratingAccuration'+vals['ID']+'" value="2" />' +
                                                            '<label for="rate2Accuration'+vals['ID']+'">2 stars.</label>' +
                                                            '<input title="Average" type="radio" id="rate3Accuration'+vals['ID']+'" name="ratingAccuration'+vals['ID']+'" value="3" />' +
                                                            '<label for="rate3Accuration'+vals['ID']+'">3 stars.</label>' +
                                                            '<input title="Good" type="radio" id="rate4Accuration'+vals['ID']+'" name="ratingAccuration'+vals['ID']+'" value="4" />' +
                                                            '<label for="rate4Accuration'+vals['ID']+'">4 stars.</label>' +
                                                            '<input title="Excellent" type="radio" id="rate5Accuration'+vals['ID']+'" name="ratingAccuration'+vals['ID']+'" value="5" />' +
                                                            '<label for="rate5Accuration'+vals['ID']+'">5 stars.</label>' +
                                                            '<span class="starability-focus-ring"></span>' +
                                                        '</fieldset>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="listGiveRatingInner after_clear">' +
                                                    '<div class="label">Quality</div>' +
                                                    '<div class="rating-stars text-center">' +
                                                        '<fieldset class="starability-slot" style="min-height:auto !important;">' +
                                                            '<input type="radio" id="no-rate" class="input-no-rate" name="ratingQuality'+vals['ID']+'" value="0" checked aria-label="No rating." />' +
                                                            '<input type="radio" id="rate1Quality'+vals['ID']+'" name="ratingQuality'+vals['ID']+'" value="1" />' +
                                                            '<label for="rate1Quality'+vals['ID']+'">1 star.</label>' +
                                                            '<input type="radio" id="rate2Quality'+vals['ID']+'" name="ratingQuality'+vals['ID']+'" value="2" />' +
                                                            '<label for="rate2Quality'+vals['ID']+'">2 stars.</label>' +
                                                            '<input type="radio" id="rate3Quality'+vals['ID']+'" name="ratingQuality'+vals['ID']+'" value="3" />' +
                                                            '<label for="rate3Quality'+vals['ID']+'">3 stars.</label>' +
                                                            '<input type="radio" id="rate4Quality'+vals['ID']+'" name="ratingQuality'+vals['ID']+'" value="4" />' +
                                                            '<label for="rate4Quality'+vals['ID']+'">4 stars.</label>' +
                                                            '<input type="radio" id="rate5Quality'+vals['ID']+'" name="ratingQuality'+vals['ID']+'" value="5" />' +
                                                            '<label for="rate5Quality'+vals['ID']+'">5 stars.</label>' +
                                                            '<span class="starability-focus-ring"></span>' +
                                                        '</fieldset>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="listGiveRatingInner after_clear">' +
                                                    '<div class="label">Service</div>' +
                                                    '<div class="rating-stars text-center">' +
                                                        '<fieldset class="starability-slot" style="min-height:auto !important;">' +
                                                            '<input type="radio" id="no-rate" class="input-no-rate" name="ratingService'+vals['ID']+'" value="0" checked aria-label="No rating." />' +
                                                            '<input type="radio" id="rate1Service'+vals['ID']+'" name="ratingService'+vals['ID']+'" value="1" />' +
                                                            '<label for="rate1Service'+vals['ID']+'">1 star.</label>' +
                                                            '<input type="radio" id="rate2Service'+vals['ID']+'" name="ratingService'+vals['ID']+'" value="2" />' +
                                                            '<label for="rate2Service'+vals['ID']+'">2 stars.</label>' +
                                                            '<input type="radio" id="rate3Service'+vals['ID']+'" name="ratingService'+vals['ID']+'" value="3" />' +
                                                            '<label for="rate3Service'+vals['ID']+'">3 stars.</label>' +
                                                            '<input type="radio" id="rate4Service'+vals['ID']+'" name="ratingService'+vals['ID']+'" value="4" />' +
                                                            '<label for="rate4Service'+vals['ID']+'">4 stars.</label>' +
                                                            '<input type="radio" id="rate5Service'+vals['ID']+'" name="ratingService'+vals['ID']+'" value="5" />' +
                                                            '<label for="rate5Service'+vals['ID']+'">5 stars.</label>' +
                                                            '<span class="starability-focus-ring"></span>' +
                                                        '</fieldset>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="listGiveRating">' +
                                                '<div style="width: 100%; margin-top: 5px; font-family: \'robotocondensedreguler\'; font-size: 18px; line-height: 23px; letter-spacing: 2px;">'+vals['ProductName'].toUpperCase()+'</div>' +
                                                '<div style="margin-top: 5px; font-family: \'robotoboldcondensed\'; font-size: 20px;">'+vals['BrandName'].toUpperCase()+'</div>' +
                                            '</div>' +
                                        '</div>';
                                    });

                                    $('.contentScrollFeedback').html(contentfeedback);

                                    openPopup('popup-feedback');

                                    $("#submitfeedback").on('click', function() {
                                        if(!check) {
                                            var feedbackresult = [];
                                            var i = 0;
                                            $.each(data['data']['OrderTransactionDetail'], function(keys, vals) {
                                                feedbackresult[i] = {
                                                    'ID' : vals['ID'],
                                                    'Accuration' : $('[name="ratingAccuration'+vals['ID']+'"]:checked').val(),
                                                    'Quality' : $('[name="ratingQuality'+vals['ID']+'"]:checked').val(),
                                                    'Service' : $('[name="ratingService'+vals['ID']+'"]:checked').val(),
                                                };
                                                i = i + 1;
                                            });

                                            $.ajax({
                                                url         : '{{$basesite}}api/update',
                                                type        : 'POST',
                                                data        : {'ajaxpost':"FeedbackResponse",'_token':'{{csrf_token()}}','feedbackresult':JSON.stringify(feedbackresult)},
                                                success     : function(newdata) {
                                                    var newdata = JSON.parse(newdata);
                                                    if(newdata['response'] == 'OK') {
                                                        check = true;
                                                        CloseFeedBack(ID, data);
                                                        closePopup('popup-feedback');
                                                    } else {
                                                        var messageerror = '';
                                                        $.each(newdata['data']['error'], function(keys, vals) {
                                                            messageerror = messageerror + '<div class="control-label"><span class="colorred">*</span> '+vals+'</div>';
                                                        });
                                                        _alertvalidation(messageerror);
                                                    }
                                                }
                                            });
                                        }
                                    })
                                    $("#popup-feedback").find('.closepop').on('click', function() {
                                        CloseFeedBack(ID, data);
                                        closePopup('popup-feedback');
                                    });
                                } else {
                                    CloseFeedBack(ID, data);
                                }
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

            function CloseFeedBack(ID, data) {
                $('[id^='+ID+']').remove();
                $('#done'+ID).addClass('done');
                $('#done'+ID).find('.imgcircle').find('img').attr('src', '{{$basesite}}assets/frontend/images/material/selesai_done.png');
                $('#date'+ID).html(data['data']['date']);
                $('#status'+ID).html('Status Pesanan : <span>'+data['data']['status']+'</span>');
            }
        </script>
    </body>
</html>