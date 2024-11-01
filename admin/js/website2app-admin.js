var topNavTabs = null;
(function( $ ) {
	'use strict';
	 	$(window).load(function(){
            // was trying to get the loading gif to be added into the iframe
            // var iFrame = $(".appPreviewiFrame").get(0);
            // $(iFrame).ready(function() {
            //     var iDoc = iFrame.contentWindow || iFrame.contentDocument;
            //     console.log($(".overlay.loader").parent().html());
            //     $(iDoc.body).prepend($(".overlay.loader").parent().html());
            //     $(iDoc.body).find(".overlay.loader").fadeIn();
            // });

            $(".overlay.loader").fadeIn();

        
	 	    $(".preview-popup-trigger").on("click", function() {
	 	        showQRCodePopup();
	 	    });
	 	    $(".popup-bg").on("click", function() {
	 	       $(".popup-bg").css('display', 'none');
	 	    });
			$('.color-picker').wpColorPicker();
			document.currentTabInput = getUrlParameter('section');
			document.topNavTabsCurrent = getUrlParameter('topnav');
			// var selectedMainTab = $('input#something').val();
			// var topNav = $('input#something').val();
			// var settingsMainTab = $('#w2a_settings_tabs').tabs({active : $('input#currentTab').val()});
			var settingsMainTab = $('#w2a_settings_tabs').tabs({active :  document.currentTabInput });
			// this.topNavTabs = $('#topNavTabs').tabs({active : $('input#topNavTabsCurrent').val()});
			this.topNavTabs = $('#topNavTabs').tabs({active :  document.topNavTabsCurrent });

			$('a.tabcontrol').click(function(event){
				// event.preventDefault();
				var context = $('.w2a_tabs_wrap');
				$('a.tabcontrol', context).removeClass('nav-tab-active');
				$(this).addClass('nav-tab-active');
				$('div.tab-content', context).addClass('hide');
				$( 'div'+$(this).attr('targetTab'), context ).removeClass('hide');
			});

      $("#wpPayNow").on("click press", function(){
        $.ajax({
            url: "https://api.website2app.com/v1/subscription/checkout/setup-payment?returnUrl="+$(this).attr("data-returnurl"),
            headers: {
                'Website2AppId': $(this).attr("data-website2appid"),
                'Website2AppSecret': $(this).attr("data-website2appsecret"),
                'Website2AppRequestKey': 'sO4nl&W5sVTpBOQ#Wo07bJGMdJTZ&isi$HTe#j3x'
            },
            success: function(result){
            if(result.success){
                    window.location.href = result.checkout.url;
            }
            // console.log("Result from AJAX: ", result)
            }
        });
      })
		});

        setTimeout(function () {
            setPreviewFrame();
            setiPhonePreviewFrame();
        }, 2000);
		$(window).resize(function () {
		   setiPhoneFrame();
           setPreviewFrame();
           setiPhonePreviewFrame();
		});

	$(document).on('change','#accountAddressCountry',function(){
		var country = $(this).val();
		// console.log(country);
		// console.log('Render State here...');
	});

})( jQuery );
$=jQuery;

function reloadPreviewer() {
    var iFrame = $(".appPreviewiFrame").get(0);
    iFrame.contentWindow.location.reload();
}
function injectIframeCss(){
    var $head = $("iframe").contents().find("head");                
    $head.append('<style type="text/css">body::-webkit-scrollbar{display:none;} body{-ms-overflow-style: none;scrollbar-width: none;}</style>');
}
function appPreviewerDidLoad() {
    var iFrame = $(".appPreviewiFrame").get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    if (iDoc.document) {
        iDoc = iDoc.document;
        // $(iDoc.body).find("*").each(function () {
        //     $(this).on("click", function (event) {
        //         event.preventDefault();
        //         $(".popup-bg").css('display', 'flex');
        //     });
        // });
        setTimeout(function () {
            var headerPath = $("input[name='headerToHide']").val();
            var footerPath = $("input[name='footerToHide']").val();
            var pathsToHide = [headerPath, footerPath];
            $("input[name='otherHide[]']").each(function () {
                if ($(this).val().length > 0) {
                    pathsToHide.push($(this).val());
                }
            });
    
            for (var p = 0; p < pathsToHide.length; p++) {
                $(iDoc.body).find(pathsToHide[p]).hide();
            }

            var topNavType = $("input[name='topNav_1_structure']:checked").val();
            // console.log(topNavType);
            // logoLeftBurgerRight, logoOnly, logoLeftNavRight, logoMidNavBoth

            var replaceVals = {
                "BACKGROUND_COLOUR":$("#topbar_navigation_backgroundColor").val(),
                "LOGO_POSITION":"logo-"+$("input[name='topNav_1_"+topNavType+"_align']:checked").val(),
                "LOGO_URL":$("input[name='topBarNav_styles_bannerLogo_image_url']").val(),
                "PAGE_TITLE":$("input[name='topNav_1_text']").val(),
                "LOGO_OR_TEXT":"show-"+$("input[name='topNav_1_"+topNavType+"_type']:checked").val(),
                "TEXT_COLOUR":$("input[name='topbar_textColour']:checked").val()
            };

            var topNavTemplate = "top-nav-logo-only";

            if (topNavType === "logoLeftBurgerRight") {
                topNavTemplate = "top-nav-logo-left-burger-right";
                replaceVals['HAMBURGER_ICON'] = $("input[name='topNav_1_logoLeftBurgerRight_HamburgerMenuIcon_image_url']").val();
            } else if (topNavType === "logoLeftNavRight") {
                topNavTemplate = "top-nav-logo-left-nav-right";
                var numTopNavItems = $("#topNavPage_1 section[data-structure=3] .topNavPageIconItem").length;
                replaceVals['MENU_ITEM_1'] = numTopNavItems > 0 ? "active" : "";
                replaceVals['MENU_ITEM_1_ICON_URL'] = numTopNavItems > 0 ? $("input[name='topNav_1_logoLeftNavRight_iconImage_1_image_url']").val() : "";
                replaceVals['MENU_ITEM_2'] = numTopNavItems > 1 ? "active" : "";
                replaceVals['MENU_ITEM_2_ICON_URL'] = numTopNavItems > 1 ? $("input[name='topNav_1_logoLeftNavRight_iconImage_2_image_url']").val() : "";
                replaceVals['MENU_ITEM_3'] = numTopNavItems > 2 ? "active" : "";
                replaceVals['MENU_ITEM_3_ICON_URL'] = numTopNavItems > 2 ? $("input[name='topNav_1_logoLeftNavRight_iconImage_3_image_url']").val() : "";
            } else if (topNavType === "logoMidNavBoth") {
                topNavTemplate = "top-nav-logo-middle-nav-both";
                var numTopNavItems = $("#topNavPage_1 section[data-structure=4] .topNavPageIconItem").length;
                replaceVals['MENU_ITEM_1'] = numTopNavItems > 0 ? "active" : "";
                replaceVals['MENU_ITEM_1_ICON_URL'] = numTopNavItems > 0 ? $("input[name='topNav_1_logoMidNavBoth_iconImage_1_image_url']").val() : "";
                replaceVals['MENU_ITEM_2'] = numTopNavItems > 1 ? "active" : "";
                replaceVals['MENU_ITEM_2_ICON_URL'] = numTopNavItems > 1 ? $("input[name='topNav_1_logoMidNavBoth_iconImage_2_image_url']").val() : "";
                replaceVals['MENU_ITEM_3'] = numTopNavItems > 2 ? "active" : "";
                replaceVals['MENU_ITEM_3_ICON_URL'] = numTopNavItems > 2 ? $("input[name='topNav_1_logoMidNavBoth_iconImage_3_image_url']").val() : "";
            }
            //load app header
            getPreviewTemplate(topNavTemplate, replaceVals, function (data) {
                $(iDoc.body).prepend("<div class='w2a-appHeader'>" + data + "</div>");
                $(iDoc.body).css({
                    "padding-top":"50px"
                })
                
            });
            $(".overlay.loader").fadeOut(); 

            //load app footer
            var bottomNavTotal = $(".navigationBottomBarItem").length;
            var bottomNavHtml = "<div class='w2a-appFooter'>";
            var appendedMenuItems = 0;

            const rgb = $("input[name='bottombarNavStyle_activeIconColor']").val().replace("rgb\(", "").replace("\)", "").split(",");
            
            if (rgb.length !== 3) {
            // alert('Invalid format!');
            return;
            }

            const color = new W2A_Color(rgb[0], rgb[1], rgb[2]);
            const solver = new W2A_Solver(color);
            const result = solver.solve();

            let lossMsg;
            if (result.loss < 1) {
            lossMsg = 'This is a perfect result.';
            } else if (result.loss < 5) {
            lossMsg = 'The is close enough.';
            } else if (result.loss < 15) {
            lossMsg = 'The color is somewhat off. Consider running it again.';
            } else {
            lossMsg = 'The color is extremely off. Run it again!';
            }

            // $('.realPixel').css('background-color', color.toString());
            // $('.filterPixel').attr('style', result.filter);
            // $('.filterDetail').text(result.filter);
            // $('.lossDetail').html(`Loss: ${result.loss.toFixed(1)}. <b>${lossMsg}</b>`);
            getPreviewTemplate("bottom-nav", {
                "BACKGROUND_COLOUR":$("#bottombarNavStyle_backgroundColor").val(),
                "DEFAULT_COLOUR":$("input[name='bottombarNavStyle_defaultIconColor']").val(),
                "ACTIVE_COLOUR":$("input[name='bottombarNavStyle_activeIconColor']").val(),
                "ACTIVE_ICON_CSS":result.filter
            }, function (data) {
                bottomNavHtml += data;
                
                for (let i = 1; i < bottomNavTotal+1; i++) {
                    getPreviewTemplate("bottom-nav-menu-item", {
                        "MENU_ITEM_ICON":$('input[name="bottomBarNavLogo_'+i+'_image_url' + '"]').val(),
                        "MENU_ITEM_LABEL":$(".bottomBarItemText.item_"+i).val(),
                        "INDEX":i
                    }, function (data) {
                        bottomNavHtml += data;
                        appendedMenuItems++;
                    });
                }
                
            });
            var footerInterval = setInterval(function () {
                // element.innerHTML += "Hello"
                if (appendedMenuItems === bottomNavTotal) {
                    // console.log(bottomNavHtml);
                    bottomNavHtml += "</div>";
                    bottomNavHtml += "</div>";
                    $(iDoc.body).append(bottomNavHtml);
                    $(iDoc.body).css({"padding-bottom":"80px"});
                    $(iDoc.body).find("*").each(function () {
                        $(this).on("click", function (event) {
                            event.preventDefault();
                            showQRCodePopup()
                        });
                    });
                    clearInterval(footerInterval);
                }
            }, 200);
            
            
        }, 1000);
    }
    injectIframeCss();
}

function showQRCodePopup(){
    var $ = jQuery;
    $('#qrcode').empty();
    const qrcode = new QRCode(document.getElementById('qrcode'), {
      text: `${Website2App.W2A_CONFIG_URL}`,
      width: 240,
      height: 240,
      colorDark : '#000',
      colorLight : '#fff',
      correctLevel : QRCode.CorrectLevel.H
    });
    
    $(".popup-bg").css('display', 'flex');
}

function setiPhonePreviewFrame() {
    var $ = jQuery;

    var iPhoneFrame = $(".iFrameiPhoneFrame-Previewer").get(0);
    var iframe = $(".appPreviewiFrame").get(0);
    var iPhoneWidthScale = 1.1143923363;
    var iPhoneHeightScale = 2.1641025641;
    $(iPhoneFrame).css({
       width: $(iframe).innerWidth()*0.9,
       height: (($(iframe).innerWidth()*0.9*iPhoneHeightScale)-55)
    });
    var iFrameWidth = $(iframe).outerWidth();
    var width = iFrameWidth * iPhoneWidthScale;
    var height = width*iPhoneHeightScale-55;
    $(iPhoneFrame).css({
       width:width,
       height:height*0.9383155397,
       opacity:1
    });
}

function setPreviewFrame() {
    var $ = jQuery;
    var iframe = $("#appPreview iframe").get(0);
    var width = $(iframe).outerWidth();
    $(iframe).css("height", (width*2.1641025641)+"px");
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

$(document).on('click','#w2a_settings_tabs li.settingsTab',function(){
	$('input#currentTabInput').val($(this).index());
	// document.currentTabInput =  $(this).index();
	// console.log($(this).index());
});

$(document).on('click','li.topNavTabs',function(){
	$('input#topNavTabsCurrent').val($(this).index());
	// document.topNavTabsCurrent =  $(this).index();
	// console.log($(this).index());
});

function add_element_to_hide(el){
	var elementCount = $(el).parents('.general_hideElements').find('.otherHideElement').length;
	var __count = parseInt(elementCount) + 1;
	$('a#removeHideItem').remove();
	var hideElementHtml = `
	<div class="hideOtherItemWrap">
		<h4>Is there anything else you want to hide?</h4>
		<div class="flex-row jc-sb ai-fe selectorInputs">
			<div class="flex-row">
				<input
							type="text"
							name="otherHide[]"
							class="otherHideElement"
							value=""
							required
				/>
				<div class="flex-column">
					<div class="choose_button_with_icon" onclick="buildElementiFrame(${__count});"><a href="javascript:void(0);" class="" data-title="Select Element to Hide">Choose Element</a><span class="arrow_north"></span></div>
				</div>
				<div class="removeIcon"> <a id="removeHideItem" class="button trash" href="javascript:void(0);" onclick="removeHideItem(this)"> Remove </a> </div>
			</div>
		</div>
	</div>
	`
	$(el).before(hideElementHtml);

}
function removeHideItem(el){
	var elementCount = $(el).parents('.general_hideElements').find('.otherHideElement').length;
	$(el).parents('.hideOtherItemWrap').remove();
	var count = parseInt(elementCount) - 1;
	// console.log(count);
	if(count > 1){
		// $('.hideOtherItemWrap:last').append('Hello world');
		$('.hideOtherItemWrap:last').find('.removeIcon').html('<a id="removeHideItem" class="button trash" href="javascript:void(0);" onclick="removeHideItem(this)"> Remove </a>');

	}
}

function getTemplate(template, params, callback) {
    var $ = jQuery;
    $.ajax({
        url: Website2App.pluginURL + "templates/" + template + ".html",
        success: function (data){
            for (var key in params) {
                var val = params[key];
                data = data.replaceAll("[[" + key + "]]", val);
            }
            callback(data);
        }
    });
}

function getPreviewTemplate(template, params, callback) {
    var $ = jQuery;
    $.ajax({
        url: Website2App.pluginURL + "preview-templates/" + template + ".html",
        success: function (data){
            params["ABSOLUTE_URL_PATH"] = Website2App.pluginURL;
            params['VERSION_NUMBER'] = Date.now();
            for (var key in params) {
                var val = params[key];
                data = data.replaceAll("[[" + key + "]]", val);
            }
            callback(data);
        }
    });
}

function cssPath(el) {
    if (typeof el.nodeName === "undefined") {
        return;
    }

    var path = [];
    //while (el.nodeType === Node.ELEMENT_NODE) {
    while (el !== null) {
        if (el.nodeName !== "#document") {
            var selector = el.nodeName.toLowerCase();
            if (el.id) {
                selector += '#' + el.id;
            } else if (el.className) {
                selector += '.' + el.className.replace(/ /g, ".");
            } else {
                var sib = el, nth = 1;
                while (sib.nodeType === Node.ELEMENT_NODE && (sib = sib.previousSibling) && nth++);
                //selector += ":nth-child("+nth+")";
            }
            if (el.tagName !== "HTML" && el.tagName !== "BODY") {
                path.unshift(selector);
            }
        }
        el = el.parentNode;
    }
    return path.join(" > ");
}

var selectedHeader = "";
var selectedFooter = "";

function buildiFrame(config) {
    var $ = jQuery;
    getTemplate(config.template, config, function (content) {
        $("body").append(content);
        setTimeout(function () {
            setiPhoneFrame();
        }, 500);
        $("#" + config.ID).on("load", function () {
            var iFrame = $("#" + config.ID).get(0);
            var iDoc = iFrame.contentWindow || iFrame.contentDocument;
            if (iDoc.document) {
                iDoc = iDoc.document;
                $(iDoc.body).find("*").each(function () {
                    this.addEventListener("mouseover", function (event) {
                        if (config.type == "element") {
                            var elementType = $(".elementSelection").val();
                            if (elementType == "Any" || elementType == event.target.tagName) {
                                $(event.target).css({
                                    outline: "8px solid red"
                                });
                            }
                        } else {
                            $(event.target).css({
                                outline: "8px solid red"
                            });
                        }
                    });
                    this.addEventListener("mouseout", function (event) {
                        handleHeaderFooterMouseOut(event, config.type);
                    });
                    this.addEventListener("click", function (event) {
                        event.preventDefault();
                        if (config.type == "element") {
                            var elementType = $(".elementSelection").val();
                            if (elementType == "Any" || elementType == event.target.tagName) {
                                handleHeaderFooterClick(event, config.type, iDoc);
                            }
                        } else {
                            handleHeaderFooterClick(event, config.type, iDoc);
                        }
                    });
                });
            };
        });
    });
}

function handleHeaderFooterMouseOut(event, type) {
    var $ = jQuery;
    if (type == "header") {
        if (cssPath(event.target) !== selectedHeader) {
            $(event.target).css({
                outline: "0px"
            });
        }
    } else if (type == "footer") {
        if (cssPath(event.target) !== selectedFooter) {
            $(event.target).css({
                outline: "0px"
            });
        }
    } else {
        if (cssPath(event.target) !== selectedElement) {
            $(event.target).css({
                outline: "0px"
            });
        }
    }
}

function handleHeaderFooterClick(event, type, iDoc) {
    var $ = jQuery;
    var path = cssPath(event.target);
    if (type == "header") {
        if (path !== selectedHeader) {
            $(iDoc.body).find(selectedHeader).css({
                outline: "0px"
            });
            var selected = $(iDoc.body).find(selectedHeader).get(0);
            if (!$(selected).is(":visible")) {
                $(selected).fadeIn();
                $(".selectionApplyButton").text("Apply");
            }
            selectedHeader = path;
            setHeaderInput();
        }
    } else if (type == "footer") {
        if (path !== selectedFooter) {
            $(iDoc.body).find(selectedFooter).css({
                outline: "0px"
            });
            var selected = $(iDoc.body).find(selectedFooter).get(0);
            if (!$(selected).is(":visible")) {
                $(selected).fadeIn();
                $(".selectionApplyButton").text("Apply");
            }
            selectedFooter = path;
            setFooterInput();
        }
    } else {
        if (path !== selectedElement) {
            // console.log("true");
            $(iDoc.body).find(selectedElement).css({
                outline: "0px"
            });
            var selected = $(iDoc.body).find(selectedElement).get(0);
            if (!$(selected).is(":visible")) {
                $(selected).fadeIn();
                $(".selectionApplyButton").text("Apply");
            }
            selectedElement = path;
            setElementInput();
        } else {
            // console.log("false");
        }
    }
}

function buildHeaderiFrame() {
    selectedHeader = "";
    buildiFrame({
        ID:"header_selection_iframe",
        URL:Website2App.homeURL + "?hidetoolbar=true",
        DISPLAY_URL:Website2App.homeURL,
        template:"selection_popover",
        type:"header"
    });
}

function buildFooteriFrame() {
    selectedFooter = "";
    buildiFrame({
        ID:"footer_selection_iframe",
        URL:Website2App.homeURL + "?hidetoolbar=true",
        DISPLAY_URL:Website2App.homeURL,
        template:"selection_popover_footer",
        type:"footer"
    });
}

var elementSelectioniFrameIndex = -1;

function buildElementiFrame(index) {
    elementSelectioniFrameIndex = index;
    selectedElement = "";
    buildiFrame({
        ID:"element_selection_iframe",
        URL:Website2App.homeURL + "?hidetoolbar=true",
        DISPLAY_URL:Website2App.homeURL,
        template:"selection_popover_element",
        type:"element"
    });
}

function selectNext(id, type) {
    var $ = jQuery;
    var iFrame = $("#" + id).get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    var currentSelector = "";

    if (iDoc.document) {
        iDoc = iDoc.document;
        var child = null;

        if (type == "header") {
            child = $(iDoc.body).find(selectedHeader).get(0);
            currentSelector = selectedHeader;
            if (typeof child !== "undefined") {
                if (child.nextSibling !== null) {
                    var siblingTest = child;
                    var nextCount = 0;
                    while (siblingTest.nextSibling !== null && nextCount == 0) {
                        if (typeof siblingTest.nextSibling.tagName === "undefined") {
                            siblingTest = siblingTest.nextSibling;
                            child = siblingTest;
                            nextCount = 1;
                        }
                    }
                    child = siblingTest;
                    if (typeof child.nextSibling.tagName !== "undefined") {
                        child = child.nextSibling;
                    }
                }
            }
        } else if (type == "footer") {
            child = $(iDoc.body).find(selectedFooter).get(0);
            currentSelector = selectedFooter;
            if (typeof child !== "undefined") {
                if (child.nextSibling !== null) {
                    var siblingTest = child;
                    while (typeof siblingTest.nextSibling.tagName === "undefined" && siblingTest.nextSibling !== null) {
                        siblingTest = siblingTest.nextSibling;
                    }
                    child = siblingTest;
                    if (typeof child.nextSibling.tagName !== "undefined") {
                        child = child.nextSibling;
                    }
                }
            }
        } else {
            child = $(iDoc.body).find(selectedElement).get(0);
            currentSelector = selectedElement;
            if (typeof child !== "undefined") {
                if (child.nextSibling !== null) {
                    var siblingTest = child;
                    while (typeof siblingTest.nextSibling.tagName === "undefined" && siblingTest.nextSibling !== null) {
                        siblingTest = siblingTest.nextSibling;
                    }
                    child = siblingTest;
                    if (typeof child.nextSibling.tagName !== "undefined") {
                        child = child.nextSibling;
                    }
                }
            }
        }

        var newCssPath = cssPath(child);
        if (newCssPath !== currentSelector) {
            if (typeof child !== "undefined") {
                while (child.tagName == "SCRIPT" || child.tagName == "STYLE") {
                    child = $(child).next().get(0);
                }
                var childPath = cssPath(child);
                if (type == "header") {
                    $(iDoc.body).find(selectedHeader).css({
                        outline: "0px"
                    });
                    selectedHeader = childPath;
                    setHeaderInput();
                } else if (type == "footer") {
                    $(iDoc.body).find(selectedFooter).css({
                        outline: "0px"
                    });
                    selectedFooter = childPath;
                    setFooterInput();
                } else {
                    $(iDoc.body).find(selectedElement).css({
                        outline: "0px"
                    });
                    selectedElement = childPath;
                    setElementInput();
                }
                $(child).css({
                    outline: "8px solid red"
                });
            }
        }
    }
}


function selectPrev(id, type) {
    var $ = jQuery;
    var iFrame = $("#" + id).get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    var currentSelector = "";

    if (iDoc.document) {
        iDoc = iDoc.document;
        var child = null;

        if (type == "header") {
            child = $(iDoc.body).find(selectedHeader).get(0);
            currentSelector = selectedHeader;
            if (typeof child !== "undefined") {
                if (child.previousSibling !== null) {
                    if (typeof child.previousSibling.tagName !== "undefined") {
                        child = child.previousSibling;
                    }
                }
            }
        } else if (type == "footer") {
            child = $(iDoc.body).find(selectedFooter).get(0);
            currentSelector = selectedFooter;
            if (typeof child !== "undefined") {
                if (child.previousSibling !== null) {
                    if (typeof child.previousSibling.tagName !== "undefined") {
                        child = child.previousSibling;
                    }
                }
            }
        } else {
            child = $(iDoc.body).find(selectedElement).get(0);
            currentSelector = selectedElement;
            if (typeof child !== "undefined") {
                if (child.previousSibling !== null) {
                    if (typeof child.previousSibling.tagName !== "undefined") {
                        child = child.previousSibling;
                    }
                }
            }
        }

        var newCssPath = cssPath(child);
        if (newCssPath !== currentSelector) {
            if (typeof child !== "undefined") {
                while (child.tagName == "SCRIPT" || child.tagName == "STYLE") {
                    child = $(child).next().get(0);
                }
                var childPath = cssPath(child);
                if (type == "header") {
                    $(iDoc.body).find(selectedHeader).css({
                        outline: "0px"
                    });
                    selectedHeader = childPath;
                    setHeaderInput();
                } else if (type == "footer") {
                    $(iDoc.body).find(selectedFooter).css({
                        outline: "0px"
                    });
                    selectedFooter = childPath;
                    setFooterInput();
                } else {
                    $(iDoc.body).find(selectedElement).css({
                        outline: "0px"
                    });
                    selectedElement = childPath;
                    setElementInput();
                }
                $(child).css({
                    outline: "8px solid red"
                });
            }
        }
    }
}

function selectChild(id, type) {
    var $ = jQuery;
    var iFrame = $("#" + id).get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    if (iDoc.document) {
        iDoc = iDoc.document;
        var child = null;

        if (type == "header") {
            child = $(iDoc.body).find(selectedHeader).get(0).children[0];
        } else if (type == "footer") {
            child = $(iDoc.body).find(selectedFooter).get(0).children[0];
        } else {
            child = $(iDoc.body).find(selectedElement).get(0).children[0];
        }

        if (typeof child !== "undefined") {
            while (child.tagName == "SCRIPT" || child.tagName == "STYLE") {
                child = $(child).next().get(0);
            }
            var childPath = cssPath(child);
            if (type == "header") {
                $(iDoc.body).find(selectedHeader).css({
                    outline: "0px"
                });
                selectedHeader = childPath;
                setHeaderInput();
            } else if (type == "footer") {
                $(iDoc.body).find(selectedFooter).css({
                    outline: "0px"
                });
                selectedFooter = childPath;
                setFooterInput();
            } else {
                $(iDoc.body).find(selectedElement).css({
                    outline: "0px"
                });
                selectedElement = childPath;
                setElementInput();
            }
            $(child).css({
                outline: "8px solid red"
            });
        }
    }
}

function setiPhoneFrame() {
    var $ = jQuery;
    var iFrameShadowBox = $(".iFrameWindow").get(0);
    if (typeof iFrameShadowBox !== "undefined") {
        var iPhoneFrame = $(".iFrameiPhoneFrame").get(0);
        var iframe = $(".iFramePopoverElement").get(0);
        var iPhoneWidthScale = 1.1143923363;
        var iPhoneHeightScale = 2.1641025641;
        $(".iFrameContainer iframe").css({
           width: $(".iFrame_Half_Container").innerWidth()*0.9,
           height: $(".iFrame_Half_Container").innerWidth()*0.9*iPhoneHeightScale
        });
        var iFrameWidth = $(iframe).outerWidth();
        var width = iFrameWidth * iPhoneWidthScale;
        var height = width*iPhoneHeightScale;
        var leftOffset = (iFrameWidth-width)/-2;
        var pos = $(iframe).offset();
        $(iPhoneFrame).css({
           top:58,
           left:pos.left - leftOffset,
           width:width,
           height:height*0.9383155397,
           opacity:1
        });
    }
}

function selectParent(id, type) {
    var $ = jQuery;
    var iFrame = $("#" + id).get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    if (iDoc.document) {
        iDoc = iDoc.document;
        var parent = null;
        if (type == "header") {
            parent = $(iDoc.body).find(selectedHeader).get(0).parentNode;
        } else if (type == "footer") {
            parent = $(iDoc.body).find(selectedFooter).get(0).parentNode;
        } else {
            parent = $(iDoc.body).find(selectedElement).get(0).parentNode;
        }
        if (typeof parent !== "undefined" && parent.tagName !== "BODY" && parent.tagName !== "HTML") {
            var parentPath = cssPath(parent);
            if (type == "header") {
                $(iDoc.body).find(selectedHeader).css({
                    outline: "0px"
                });
                selectedHeader = parentPath;
                setHeaderInput();
            } else if (type == "footer") {
                $(iDoc.body).find(selectedFooter).css({
                    outline: "0px"
                });
                selectedFooter = parentPath;
                setFooterInput();
            } else {
                $(iDoc.body).find(selectedElement).css({
                    outline: "0px"
                });
                selectedElement = parentPath;
                setElementInput();
            }
            $(parent).css({
                outline: "8px solid red"
            });
        }
    }
}

function setHeaderInput() {
    var $ = jQuery;
    $(".selectionSelectorString").val(selectedHeader);
}

function setFooterInput() {
    var $ = jQuery;
    $(".selectionSelectorString").val(selectedFooter);
}

function setElementInput() {
    var $ = jQuery;
    $(".selectionSelectorString").val(selectedElement);
}

function doneSelection(type) {
    if (type == 'header') {
        jQuery("#headerToHide").val(selectedHeader);
        checkIfMultiple(selectedHeader);
    } else if (type == 'footer') {
        jQuery("#footerToHide").val(selectedFooter);
        checkIfMultiple(selectedFooter);
    } else {
        var others = jQuery(".otherHideElement").toArray();
        // console.log(others);
        var theOther = others[elementSelectioniFrameIndex-1];
        theOther.value = selectedElement;
        checkIfMultiple(selectedElement);
    }
}
function checkIfMultiple(path){
    console.log(path);
    var count = $("iframe.iFramePopoverElement").contents().find(path.toString()).length;
    if(count > 1){
        if(confirm("There are "+count+" elements with same path, are you sure to hide them all")){
            jQuery(".iFrameWindow").remove();
            reloadPreviewer();   
        }else{
            return false;
        }
    }else{
        // Hide the previewer if only 1 element found
        jQuery(".iFrameWindow").remove();
        reloadPreviewer();  
    }
}

function closeiFrameWindow(event) {
    var element = event.target;
    var $ = jQuery;
    var cl = $(element).attr('class');
    var ignores = [
        "iFrameContainer",
        "iFrameTitle",
        "iFrameNavigationWindow",
        "iFrameURL",
        "iFrameCloseWindow",
        "iFrameBackButton",
        "iFrameForwardButton",
        "selectionContainer",
        "selectionType",
        "elementSelection",
        "selectionSelector",
        "selectionSelectorString",
        "selectionSelectorChild",
        "selectionSelectorParent",
        "selectionDone",
        "selectionDoneButton",
        "iFrame_Half_Container",
        "iFrame_Half_ContainerH3",
        "iFrame_Half_ContainerH5",
        "iFrame_Half_ContainerP",
        "iFrame_SelectorTools_Container",
        "selectionSelectorPrev",
        "selectionSelectorNext",
        "selectionApplyButton",
        "selectionDoneButton",
        "iFrameiPhoneFrame",
        "iFramePopoverElement",
        "iFrame_Phone_Container",
        "iFrameNavigationWindow",
        "iFrameEditURLButton"
    ];

    if ($.inArray(cl, ignores) == -1 && typeof cl !== "undefined") {
        while (!$(element).hasClass("iFrameWindow")) {
            element = $(element).parent();
        }
        $(element).remove();
    }
}

//===========================================================================================//
//========================== Settings -> Navigation -> Bottom Bar Script STARTS ============//

//Function to handle Link Type change action.
function handleBottomBarLinkTypeChange(el){
		$=jQuery;
		var type = $(el).val();
		const section = $(el).parents('.navigationBottomBarItem');

		switch (type){
			case 'page':
			{
				section.find('select.bottomBarItemUrlInternal').removeClass('hide');
				section.find('input.bottomBarItemUrlExternal').addClass('hide');
				break;
			}

			case 'external':
			{
					section.find('select.bottomBarItemUrlInternal').addClass('hide');
					section.find('input.bottomBarItemUrlExternal').removeClass('hide');
					break;
			}
		}
}
function handleHamburgerMenuLinkTypeChange(el){
		$=jQuery;
		var type = $(el).val();
		const section = $(el).parents('.topNavPageIconItem');
		switch (type){
			case 'page':
			{
				section.find('select.topNavItemUrlInternal').removeClass('hide');
				section.find('input.topNavItemUrlExternal').addClass('hide');
				break;
			}

			case 'external':
			{
					section.find('select.topNavItemUrlInternal').addClass('hide');
					section.find('input.topNavItemUrlExternal').removeClass('hide');
					break;
			}
			case 'share':
			{
				section.find('select.topNavItemUrlInternal').addClass('hide');
				section.find('input.topNavItemUrlExternal').addClass('hide');
				break;
			}
		}
}



// When Page is slected from dropdown, copy the page name to Label input.
	$(document).on('change','select.bottomBarItemUrlInternal',function(){
		var pageName = $(this).find(":selected").text().trim();
		const section = $(this).parents('.navigationBottomBarItem');
		section.find('input.bottomBarItemText').val(pageName);

		// Update the Tab name in Top Nav Tab as well when Page Name Changes Here
		var name = $(this).attr('name');
		// console.log(name);
		var count = parseInt(name.replace(/[^0-9.]/g, ""));
		// console.log(count);
		var iconUrl = $(this).parents('.navigationBottomBarItem').find('input.w2a_img_url').val();
		// console.log(iconUrl);
		$('ul#topNavTabsControl li:nth-child('+count+') a').html('<img src="'+iconUrl+'" class="topNavPageIcon">'+pageName);
		updateTopNavNameIcon(count,iconUrl,pageName)
	});




function updateTopNavTabName(el){
	var pageName = $(el).val();
	var iconUrl = $(el).parents('.navigationBottomBarItem').find('input.w2a_img_url').val();
	var count = parseInt($(el).attr('data-itemcount'));
	// console.log(count)
	// console.log(iconUrl)
	// console.log(navTitle)
	updateTopNavNameIcon(count,iconUrl,pageName)
}
function updateTopNavNameIcon(count=1,iconUrl='',pageName='Home'){
	$('ul#topNavTabsControl li:nth-child('+count+') a').html('<img src="'+iconUrl+'" class="topNavPageIcon">'+pageName);
}
//===== Script to add new navigationIcon item in Navigation Tab STARTS===============//
/*
jQuery(document).ready(function($){
	topNavTabs = $('#topNavTabs').tabs();
	$('#addBottomNavigationIcon').on('click',function(){
		var count = document.querySelectorAll('.navigationBottomBarItem').length;
		// var count = parseInt(iconCount +1);
		if (count <= 4 ){
			var newIconHtml = $('#navigationBottomBarItemGeneric').html();
			newIconHtml = newIconHtml.replaceAll('{{iconcount}}',count+1);
			console.log(count);
			if(count >2){
				var removeIcon = '<span id="removeBottomBarNavigationIcon" class="button" onclick="javascript:removeBottomBarNavigationIcon();">Remove</span>';
			}else{
				var removeIcon = '';
			}


			$('span#removeBottomBarNavigationIcon').remove();
			$('.navigationBottomBarItem:nth(0)').parent().append('<div class="flex-column navigationBottomBarItem">'+newIconHtml+'</div>'+removeIcon);
			addTopNavTabsItem(topNavTabs,count);

			if(count == 4){
				$('#addBottomNavigationIcon').addClass('hide');
			}else{
				$('#addBottomNavigationIcon').removeClass('hide');
			}
		}
	});
});
*/



function showMaxItemAddedMessage(count){
	alert('Max items added already, will add html later!!')
}
function addBottomBarNavigationIcon(el){
		var section = $(el).parent().parent().find('.navigationBottomBarItems');
		// var count = document.querySelectorAll('.navigationBottomBarItem').length;
		var count = $(section).find('.navigationBottomBarItem').length;
		// var count = parseInt(iconCount +1);
		if (count <= 4 ){
			var newIconHtml = $('#navigationBottomBarItemGeneric').html();
			newIconHtml = newIconHtml.replaceAll('{{iconcount}}',count+1);
			// console.log(count);
			if(count >= 3 ){
				var removeIcon = '<span id="removeBottomBarNavigationIcon" class="button" onclick="removeBottomBarNavigationIcon(this);">Remove</span>';
			}else{
				var removeIcon = '';
			}


			$('span#removeBottomBarNavigationIcon').remove();

			$(section).append('<div class="flex-column navigationBottomBarItem">'+newIconHtml + removeIcon+'</div>');
            $('select#bottomBarEndFlowUrl_'+parseInt(count+1)).select2({placeholder: 'Select an option'});


			addTopNavTabsItem(count);

			if(count == 4){
				$('#addBottomNavigationIcon').addClass('hide');
			}else{
				$('#addBottomNavigationIcon').removeClass('hide');
			}
		}else{
			showMaxItemAddedMessage();
		}

		// Re-initialize the color picker for added pickers
		var pickerCount = parseInt(count+1);
		$('.color-picker'+pickerCount).wpColorPicker();

}
function removeBottomBarNavigationIcon(el){

	$=jQuery;
	var section = $(el).parents('.navigationBottomBarItems');
	var count = parseInt($(section).find('.navigationBottomBarItem').length -1);

	// console.log(count);
	if(count >= 1){
		if(confirm("Do you want to remove this?")){
			$(section).find('.navigationBottomBarItem:nth('+count+')').remove();
			removeTopNavTabsItem(count);
			$('#addBottomNavigationIcon').removeClass('hide');
			if(count > 3){
				$(section).find('.navigationBottomBarItem').last().append('<span id="removeBottomBarNavigationIcon" class="button" onclick="removeBottomBarNavigationIcon(this);">Remove</span>');
				// $('span#removeBottomBarNavigationIcon').remove();
			}
		}
	}
	if(count < 5){
			$('.addNewNavigationIcon').removeClass('hide');
		}else{
			$('.addNewNavigationIcon').addClass('hide');
		}
	}

function addTopNavTabsItem(count){

	var count = count+1;
	var topNavTabs = this.topNavTabs;
	// console.log(topNavTabs);
	var topNavTabs = $('#topNavTabs').tabs();
	// console.log(topNavTabs);

	var label = $('input.bottomBarItemText.item_'+count).val() || 'Page';
	var icon = $('input[name="bottomBarItemIcon_'+count+'_image_url"]').val();

	var tabTemplate = '<li class="topNavTabs"><a href="#{{topNavTabId}}"><span class="topNavPageIcon"></span>{{topNavTabLabel}}</li></a>';
	var tabContent = $('#topNavIndividualPageSetupGeneric').html();


		// var label = tabTitle.val() || "Tab " + tabCounter,
		id = "topNavPage_"+count;
		li = $( tabTemplate.replaceAll('{{topNavTabId}}',id).replaceAll('{{topNavTabLabel}}',label));
		tabContentHtml = tabContent.replaceAll('{{bottomBarpagecount}}', count);


	topNavTabs.find( ".ui-tabs-nav" ).append( li );



	// topNavTabs.append('<div id="topNavPage_'+count+'" data-pagecount="'+count+'" class="topNavPageSettings flex-column ui-tabs-panel ui-corner-bottom ui-widget-content">');
	// topNavTabs.find('div#'+id).removeAll();
	topNavTabs.append( '<div id="topNavPage_'+count+'" data-pagecount="'+count+'" class="topNavPageSettings flex-column ui-tabs-panel ui-corner-bottom ui-widget-content">'+tabContentHtml+'</div>' );
	// topNavTabs.append( "<div id='" + id + "' class='flex-column '>" + tabContentHtml + "</div>" );
	topNavTabs.tabs( "refresh" );
	this.topNavTabs = topNavTabs;

}

function removeTopNavTabsItem(tabIndex){
	var count = parseInt(tabIndex)+1;
	var topNavTabs =	this.topNavTabs;
	// var topNavTabs = $('#topNavTabs').tabs();
	$('li[aria-controls="topNavPage_'+count+'"]').remove();
	$('#topNavPage_'+count).remove();
  topNavTabs.tabs( "refresh" );
	this.topNavTabs = topNavTabs;
}

/*
$(document).on('change','.navigation_bottomBar_section input.bottomBarItemText',function(){
	var name = $(this).attr('name');

	var count = parseInt(name.replace(/[^0-9.]/g, ""));
	$('ul#topNavTabsControl li:nth-child('+count+') a').text($(this).val());

});
*/


//===== Script to add/remvoe navigationIcon item in Navigation for Bottom BarTab ENDS=============//

//===========================================================================================//
//========================== Settings -> Navigation -> Bottom Bar Script ENDS ==============//


//===========================================================================================//
//========================== Settings -> Navigation -> Hamburger Menu STARTS ============//
//Function to handle Link Type change action.
function handleHamburgerLinkTypeChange(el){
		$=jQuery;
		var type = $(el).val();
		const section = $(el).parents('.navigationHamburgerItem');

		switch (type){
			case 'page':
			{
				section.find('select.hamburgerItemUrlInternal').removeClass('hide');
				section.find('input.hamburgerItemUrlExternal').addClass('hide');
				break;
			}

			case 'external':
			{
					section.find('select.hamburgerItemUrlInternal').addClass('hide');
					section.find('input.hamburgerItemUrlExternal').removeClass('hide');
					break;
			}
		}
}
//===== Script to add/remove navigationIcon item in Hamburger Section of Navigation Tab STARTS===============//
jQuery(document).ready(function($){
	$('#addHamburgerNavigationIcon').on('click',function(){
		var count = document.querySelectorAll('.navigationHamburgerItem').length;
		// var count = parseInt(iconCount +1);
		if (count <= 4 ){
			var newIconHtml = $('#navigationHamburgerItemGeneric').html();
			newIconHtml = newIconHtml.replaceAll('{{iconcount}}',count+1);
			// console.log(count);
			if(count >2){
				var removeIcon = '<span id="removeHamburgerNavigationIcon" class="button" onclick="javascript:removeHamburgerNavigationIcon();">Remove</span>';
			}else{
				var removeIcon = '';
			}


			$('span#removeHamburgerNavigationIcon').remove();
			$('.navigationHamburgerItem:nth(0)').parent().append('<div class="flex-column navigationHamburgerItem">'+newIconHtml+'</div>'+removeIcon);

			if(count == 4){
				$('#addHamburgerNavigationIcon').addClass('hide');
			}else{
				$('#addHamburgerNavigationIcon').removeClass('hide');
			}
		}
	});
});

function removeHamburgerNavigationIcon(){
	$=jQuery;
	var count = parseInt(document.querySelectorAll('.navigationHamburgerItem').length) -1;
	// console.log(count);
	if(count >= 3){
		if(confirm("Do you want to remove this?")){
			$('.navigationHamburgerItem:nth('+count+')').remove();
			$('#addHamburgerNavigationIcon').removeClass('hide');
			if(count == 3){
				$('span#removeHamburgerNavigationIcon').remove();
			}
		}

	}
}
//===== Script to add/remove navigationIcon item in Hamburger Section of Navigation Tab ENDS===============//

$(document).ready(function() {
	/*
	$(".settingSelect input[type='radio']").on('change', function() {
		$(".topNav_optionParent").each(function() {
			$(this).find(".settingParent").addClass("hide");
		});
		var topNavOptionParent = findOptionParent(this, "topNav_optionParent");
		$(topNavOptionParent).find(".settingParent").removeClass("hide");
	});
	*/

/*
	$(".optionRadio input").on("change", function() {
		var optionParent = findOptionParent(this, 'optionParent');
		var selectedOptionNumber = $(optionParent).attr("data-id");
		$(optionParent).parent().find(".optionParent").each(function() {
			if ($(this).attr('data-id') != selectedOptionNumber) {
				$(this).find(".conditionalSettings").addClass("hide");
			}
		});
		$(optionParent).find('.conditionalSettings').removeClass("hide");
	});
	*/
/*
	function findOptionParent(el, name) {
		while (!$(el).hasClass(name)) {
			el = $(el).parent();
		}
		return el;
	}
	*/
});

$(document).on("change", ".settingSelect input[type='radio']",function(){
		var topNavTab = $(this).parents('.topNavPageSettings');
		$(topNavTab).find('.topNav_optionParent').each(function(){
				$(this).find(".settingParent").addClass("hide");
		});
		var topNavOptionParent = findOptionParent(this, "topNav_optionParent");
		$(topNavOptionParent).find(".settingParent").removeClass("hide");

});

$(document).on("change", ".optionRadio input", function() {
	var optionParent = findOptionParent(this, 'optionParent');
	var selectedOptionNumber = $(optionParent).attr("data-id");
	$(optionParent).parent().find(".optionParent").each(function() {
		if ($(this).attr('data-id') != selectedOptionNumber) {
			$(this).find(".conditionalSettings").addClass("hide");
		}
	});
	$(optionParent).find('.conditionalSettings').removeClass("hide");
});

function findOptionParent(el, name) {
	while (!$(el).hasClass(name)) {
		el = $(el).parent();
	}
	return el;
}



//======== Top Nav Tab Scripts =========
function handleTopNavLinkTypeChange(el){
	$=jQuery;
	var type = $(el).val();
	const section = $(el).parents('.topNavPageIconItem');
	// console.log(type);
	// console.log(section);
	switch (type){
		case 'page':
		{
			section.find('select.topNavItemUrlInternal').removeClass('hide');
			section.find('input.topNavItemUrlExternal').addClass('hide');
			break;
		}

		case 'external':
		{
				section.find('select.topNavItemUrlInternal').addClass('hide');
				section.find('input.topNavItemUrlExternal').removeClass('hide');
				break;
		}
		case 'share':
		{
			section.find('select.topNavItemUrlInternal').addClass('hide');
			section.find('input.topNavItemUrlExternal').addClass('hide');
			break;
		}
	}
}

function addTopNavNavigationIcon(el,designType = 'logoLeftNavRight'){

			var section = $(el).parents('section.navStructureRow');
			var pagecount = $(el).parents('.topNavPageSettings').attr('data-pagecount');
			var structureCount = $(el).parents('.navStructureRow').attr('data-structure');
			var navItemsCount = parseInt($(section).find('.topNavPageIconItem').length);


			// var count = document.querySelectorAll('navigation_bottomBar_section .navigationBottomBarItem').length;
			// var count = parseInt(iconCount +1);
			if (navItemsCount <= 2 ){
				var newIconHtml = $('#topNavNaviagionIconGeneric').html();
				newIconHtml = newIconHtml.replaceAll('{{iconCount}}',navItemsCount+1).replaceAll('{{topNavTabCount}}',pagecount).replaceAll('{{structureCount}}',structureCount).replaceAll('{{designType}}',designType);
				if(navItemsCount >=1){
					var removeIcon = '<span class="button removeNavigationIconRow" onclick="removeTopNavigationIconForPage(this);">Remove</span>';
				}else{
					var removeIcon = '';
				}


				$(section).find('span.removeNavigationIconRow').remove();

				$(el).parent().before('<div class="flex-column topNavPageIconItem">'+newIconHtml+'</div>'+removeIcon);

				if(navItemsCount == 2){
					$(section).find('.addNewNavigationIcon').addClass('hide');
				}else{
					$(section).find('.addNewNavigationIcon').removeClass('hide');
				}
			}else{
				showMaxItemAddedMessage();
				// console.log('Max item added!');
			}



}
function removeTopNavigationIconForPage(el){
	$=jQuery;
	var section = $(el).parents('section.navStructureRow');

	var count = parseInt($(section).find('.topNavPageIconItem').length);
	// console.log(count);
	// if(count >= 1){
		if(confirm("Do you want to remove this?")){
			$(section).find('.topNavPageIconItem:nth('+(count-1)+')').remove()
			// $(removeel).remove();
			$(section).find('.addNewNavigationIcon').removeClass('hide');
			// console.log(count);
			if(count == 2){
					$(section).find('span.removeNavigationIconRow').remove();
			}
		}

	// }
}


'use strict';

class W2A_Color {
  constructor(r, g, b) {
    this.set(r, g, b);
  }
  
  toString() {
    return `rgb(${Math.round(this.r)}, ${Math.round(this.g)}, ${Math.round(this.b)})`;
  }

  set(r, g, b) {
    this.r = this.clamp(r);
    this.g = this.clamp(g);
    this.b = this.clamp(b);
  }

  hueRotate(angle = 0) {
    angle = angle / 180 * Math.PI;
    const sin = Math.sin(angle);
    const cos = Math.cos(angle);

    this.multiply([
      0.213 + cos * 0.787 - sin * 0.213,
      0.715 - cos * 0.715 - sin * 0.715,
      0.072 - cos * 0.072 + sin * 0.928,
      0.213 - cos * 0.213 + sin * 0.143,
      0.715 + cos * 0.285 + sin * 0.140,
      0.072 - cos * 0.072 - sin * 0.283,
      0.213 - cos * 0.213 - sin * 0.787,
      0.715 - cos * 0.715 + sin * 0.715,
      0.072 + cos * 0.928 + sin * 0.072,
    ]);
  }

  grayscale(value = 1) {
    this.multiply([
      0.2126 + 0.7874 * (1 - value),
      0.7152 - 0.7152 * (1 - value),
      0.0722 - 0.0722 * (1 - value),
      0.2126 - 0.2126 * (1 - value),
      0.7152 + 0.2848 * (1 - value),
      0.0722 - 0.0722 * (1 - value),
      0.2126 - 0.2126 * (1 - value),
      0.7152 - 0.7152 * (1 - value),
      0.0722 + 0.9278 * (1 - value),
    ]);
  }

  sepia(value = 1) {
    this.multiply([
      0.393 + 0.607 * (1 - value),
      0.769 - 0.769 * (1 - value),
      0.189 - 0.189 * (1 - value),
      0.349 - 0.349 * (1 - value),
      0.686 + 0.314 * (1 - value),
      0.168 - 0.168 * (1 - value),
      0.272 - 0.272 * (1 - value),
      0.534 - 0.534 * (1 - value),
      0.131 + 0.869 * (1 - value),
    ]);
  }

  saturate(value = 1) {
    this.multiply([
      0.213 + 0.787 * value,
      0.715 - 0.715 * value,
      0.072 - 0.072 * value,
      0.213 - 0.213 * value,
      0.715 + 0.285 * value,
      0.072 - 0.072 * value,
      0.213 - 0.213 * value,
      0.715 - 0.715 * value,
      0.072 + 0.928 * value,
    ]);
  }

  multiply(matrix) {
    const newR = this.clamp(this.r * matrix[0] + this.g * matrix[1] + this.b * matrix[2]);
    const newG = this.clamp(this.r * matrix[3] + this.g * matrix[4] + this.b * matrix[5]);
    const newB = this.clamp(this.r * matrix[6] + this.g * matrix[7] + this.b * matrix[8]);
    this.r = newR;
    this.g = newG;
    this.b = newB;
  }

  brightness(value = 1) {
    this.linear(value);
  }
  contrast(value = 1) {
    this.linear(value, -(0.5 * value) + 0.5);
  }

  linear(slope = 1, intercept = 0) {
    this.r = this.clamp(this.r * slope + intercept * 255);
    this.g = this.clamp(this.g * slope + intercept * 255);
    this.b = this.clamp(this.b * slope + intercept * 255);
  }

  invert(value = 1) {
    this.r = this.clamp((value + this.r / 255 * (1 - 2 * value)) * 255);
    this.g = this.clamp((value + this.g / 255 * (1 - 2 * value)) * 255);
    this.b = this.clamp((value + this.b / 255 * (1 - 2 * value)) * 255);
  }

  hsl() {
    // Code taken from https://stackoverflow.com/a/9493060/2688027, licensed under CC BY-SA.
    const r = this.r / 255;
    const g = this.g / 255;
    const b = this.b / 255;
    const max = Math.max(r, g, b);
    const min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;

    if (max === min) {
      h = s = 0;
    } else {
      const d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
      switch (max) {
        case r:
          h = (g - b) / d + (g < b ? 6 : 0);
          break;

        case g:
          h = (b - r) / d + 2;
          break;

        case b:
          h = (r - g) / d + 4;
          break;
      }
      h /= 6;
    }

    return {
      h: h * 100,
      s: s * 100,
      l: l * 100,
    };
  }

  clamp(value) {
    if (value > 255) {
      value = 255;
    } else if (value < 0) {
      value = 0;
    }
    return value;
  }
}

class W2A_Solver {
  constructor(target, baseColor) {
    this.target = target;
    this.targetHSL = target.hsl();
    this.reusedColor = new W2A_Color(0, 0, 0);
  }

  solve() {
    const result = this.solveNarrow(this.solveWide());
    return {
      values: result.values,
      loss: result.loss,
      filter: this.css(result.values),
    };
  }

  solveWide() {
    const A = 5;
    const c = 15;
    const a = [60, 180, 18000, 600, 1.2, 1.2];

    let best = { loss: Infinity };
    for (let i = 0; best.loss > 25 && i < 3; i++) {
      const initial = [50, 20, 3750, 50, 100, 100];
      const result = this.spsa(A, a, c, initial, 1000);
      if (result.loss < best.loss) {
        best = result;
      }
    }
    return best;
  }

  solveNarrow(wide) {
    const A = wide.loss;
    const c = 2;
    const A1 = A + 1;
    const a = [0.25 * A1, 0.25 * A1, A1, 0.25 * A1, 0.2 * A1, 0.2 * A1];
    return this.spsa(A, a, c, wide.values, 500);
  }

  spsa(A, a, c, values, iters) {
    const alpha = 1;
    const gamma = 0.16666666666666666;

    let best = null;
    let bestLoss = Infinity;
    const deltas = new Array(6);
    const highArgs = new Array(6);
    const lowArgs = new Array(6);

    for (let k = 0; k < iters; k++) {
      const ck = c / Math.pow(k + 1, gamma);
      for (let i = 0; i < 6; i++) {
        deltas[i] = Math.random() > 0.5 ? 1 : -1;
        highArgs[i] = values[i] + ck * deltas[i];
        lowArgs[i] = values[i] - ck * deltas[i];
      }

      const lossDiff = this.loss(highArgs) - this.loss(lowArgs);
      for (let i = 0; i < 6; i++) {
        const g = lossDiff / (2 * ck) * deltas[i];
        const ak = a[i] / Math.pow(A + k + 1, alpha);
        values[i] = fix(values[i] - ak * g, i);
      }

      const loss = this.loss(values);
      if (loss < bestLoss) {
        best = values.slice(0);
        bestLoss = loss;
      }
    }
    return { values: best, loss: bestLoss };

    function fix(value, idx) {
      let max = 100;
      if (idx === 2 /* saturate */) {
        max = 7500;
      } else if (idx === 4 /* brightness */ || idx === 5 /* contrast */) {
        max = 200;
      }

      if (idx === 3 /* hue-rotate */) {
        if (value > max) {
          value %= max;
        } else if (value < 0) {
          value = max + value % max;
        }
      } else if (value < 0) {
        value = 0;
      } else if (value > max) {
        value = max;
      }
      return value;
    }
  }

  loss(filters) {
    // Argument is array of percentages.
    const color = this.reusedColor;
    color.set(0, 0, 0);

    color.invert(filters[0] / 100);
    color.sepia(filters[1] / 100);
    color.saturate(filters[2] / 100);
    color.hueRotate(filters[3] * 3.6);
    color.brightness(filters[4] / 100);
    color.contrast(filters[5] / 100);

    const colorHSL = color.hsl();
    return (
      Math.abs(color.r - this.target.r) +
      Math.abs(color.g - this.target.g) +
      Math.abs(color.b - this.target.b) +
      Math.abs(colorHSL.h - this.targetHSL.h) +
      Math.abs(colorHSL.s - this.targetHSL.s) +
      Math.abs(colorHSL.l - this.targetHSL.l)
    );
  }

  css(filters) {
    function fmt(idx, multiplier = 1) {
      return Math.round(filters[idx] * multiplier);
    }
    return `filter: invert(${fmt(0)}%) sepia(${fmt(1)}%) saturate(${fmt(2)}%) hue-rotate(${fmt(3, 3.6)}deg) brightness(${fmt(4)}%) contrast(${fmt(5)}%);`;
  }
}

function hexToRgb(hex) {
  // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
//   console.log(hex);
  const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
  hex = hex.replace(shorthandRegex, (m, r, g, b) => {
    return r + r + g + g + b + b;
  });

  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result
    ? [
      parseInt(result[1], 16),
      parseInt(result[2], 16),
      parseInt(result[3], 16),
    ]
    : null;
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
  }
  
  function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
  }
  
//   alert(rgbToHex(0, 51, 255)); // #0033ff


// Script to show/hide the end of journey page selector 
$(document).on('change', '.hasEndJourneyPage',function(){
    if($(this).val() == 'yes'){
        $(this).parents('fieldset').find('div.endFlowUrl').removeClass('hide');
    }else{
        $(this).parents('fieldset').find('div.endFlowUrl').addClass('hide');
    }
});

$(document).ready(function() {
    $('.select2').select2({placeholder: 'Select an option'});
});