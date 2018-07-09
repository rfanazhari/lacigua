<section class="faq">
	<ul class="slider">
        <li>
            <img src="{{$basesite}}assets/frontend/images/slider/faq-1.png" alt="slide1"/>
            <div class="boxSearch">
        		<input type="text" class="search" name="FaqSearch" placeholder="Search">
            </div>
        </li>
    </ul>
	<div class="wrapper">
		<div class="faqDetail after_clear">
			<div class="menulink">
				<div class="title">
					<span>FAQ</span>
				</div>
				<ul>
					@foreach($arrfaqsub as $obj)
					<li><a href="{{$basesite}}faqdetail/faq_{{$obj['permalinksub']}}/faqsub_{{$obj['permalink']}}">{{$obj['Name']}}</a></li>
					@endforeach
				</ul>
			</div>
			<div class="contentFaq">
				<div class="boxAccordion">                
	                <ul class="cd-accordion-menu animated">
	                	@php $i = 1; @endphp
	                	@foreach($arrfaqsubdetail as $obj)
						<li class="has-children">
	                        <input type="checkbox" name ="group-{{$i}}" id="group-{{$i}}" @if($i == 1) checked @endif>
	                        <label for="group-{{$i}}">{{$i}}. {{$obj['Title']}}</label>
	                        <ul>
								{!!$obj['Description']!!}
	                        </ul>
	                    </li>
	                    @php $i++; @endphp
						@endforeach
	                </ul> 
                </div>
			</div>
		</div>
		<div class="faqInfo" style="margin-top: 100px;">
			<h3>CAN’T FIND WHAT YOU’RE LOOKING FOR?</h3>
			<p>Contact our customer service <a href="{{$basesite}}contact">here</a><br/>Senin - Jumat : 08.00-17.30 WIB</p>
		</div>
	</div>
</section>

<script type="text/javascript">
	var FaqSearch = $('.slider').find('[name="FaqSearch"]');
    FaqSearch.bind("keydown", function( event ) {
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
                data        : {'ajaxpost':"FaqSearch", 'search':FaqSearch.val()},
                success     : function(data) {
                    var data = JSON.parse(data);

                    if(data['response'] != 'error') {
                        response($.map(data['response'], function (item) {
                            var AC = new Object();

                            AC.Label = item.FaqName+'<br/>'+item.FaqSubName+'<br/>'+item.FaqSubDetailTitle;
                            AC.FaqLink = item.FaqLink;

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
                var t = String(item.Label).replace( new RegExp(this.term, "gi"), "<strong>$&</strong>");

                t = "<div class='FaqResult'>" +
                        "<div class='ProductNote'>" + t + "</div>" +
                    "</div>";
                return $("<li onclick='GoTo(\"" + item.FaqLink + "\")'></li>").data("item.autocomplete", item).append("<div>" + t + "</div>").appendTo(ul);
            };
        },
        search: function(e,ui){
            $(this).data("ui-autocomplete").menu.bindings = $();
        },
        open: function() {
            $("ul.ui-menu").width( $(this).innerWidth() );
        },
        select: function (event, ui) {                    
            FaqSearch.val(ui.item.Label);
        }
    }).focus(function () {
        $(this).autocomplete("search");
        FaqSearch.autocomplete({
            autoFocus: true
        })
    });
</script>