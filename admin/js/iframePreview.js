
function changeiFrameURL() {
    var $ = jQuery;
    var url = prompt("Enter the URL you'd like to navigate to...", window.location.protocol + "//" + window.location.hostname + "/");
    if (url !== null) {
        $(".iFramePopoverElement").attr("src", url);
        $(".iFrameURL").html(url + '<div class="iFrameEditURLButton" onclick="changeiFrameURL();"></div>');
    }
}

function toggleSelectedElement(id, type) {
    var $ = jQuery;
    var iFrame = $("#" + id).get(0);
    var iDoc = iFrame.contentWindow || iFrame.contentDocument;
    var toggleSelectedPath = "";
    if (iDoc.document) {
        iDoc = iDoc.document;
        if (type == "header") {
            toggleSelectedPath = selectedHeader;
        } else if (type == "footer") {
            toggleSelectedPath = selectedFooter;
        } else {
            toggleSelectedPath = selectedElement;
        }
        $(iDoc.body).find(toggleSelectedPath).each(function () {
            if ($(this).is(":visible")) {
                $(this).fadeOut();
                $(".selectionApplyButton").text("Undo");
            } else {
                $(".selectionApplyButton").text("Apply");
                $(this).fadeIn();
            }
        });
    }
}