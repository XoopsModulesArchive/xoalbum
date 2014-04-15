$(document).ready(function(){
    $("ul[class=li-menu-nav] > li").bind("mouseover", jsddm_open);
    $("ul[class=li-menu-nav] > li").bind("mouseout",  jsddm_timer);
    
    $("ul[id=albumlist] > li").hover(
      function () {
        $(this).addClass("hover");
        $("#" + $(this).attr("id") +" > address").css("visibility", "visible");
      },
      function () {
        $(this).removeClass("hover");
        $("#" + $(this).attr("id") +" > address").css("visibility", "hidden")
      }
    );
    $('#tabs').tabs();
    $("#album-left").accordion({ header: "h3",autoHeight: false });
    
    $("#dialogbox").dialog({
        bgiframe: true,
    	height: "auto",
    	modal: true,
    	autoOpen: false,
    	width: 450
    });
    
    $("a[class^=dialog]").bind("click",linkdialog);
	$("input[name=album_cover]").click(ajaxCoverFrm);
})

var ajaxCoverFrm = function()
{
    var options = {
        success:       showResponse,  // post-submit callback 
        dataType:	   "json"
    }; 
    $("#coverfrm").ajaxSubmit(options);
}
var showResponse = function(jsonData,status,jqForm)
{
    if ( jsonData.status == "200" ) {
        $("img[id=album-cover-image]").attr("src",jsonData.image);
    } 
}

var linkdialog = function()
{
    $.ajax({
        type: "GET",
        url: $(this).attr("href"),
        success: function(html){
            $("#dialogbox").html(html)
        }
    });
    $("#dialogbox").dialog(
        "option", 
        "buttons",{ "Submit": submitform , "Cancel": closedialog }
    );
    $("#dialogbox").dialog("option","title",$(this).text());
    $("#dialogbox").dialog("open");
	return false;
}
    var closedialog = function()
    {
        $(this).dialog("close").empty(); 
    }
    
    var submitform = function()
    {
        var options = {
            success:       response,  // post-submit callback 
            dataType:	   "json"
        };
        if ( !$("div[id=dialogbox] > form").length ) {
            $(this).dialog("close").empty(); 
        }
        $("div[id=dialogbox] > form").ajaxSubmit(options); 
    }
    
    var response = function(jsonData,status,jqForm) 
    {
        if ( jsonData.status == "200" ) {
            if ( jsonData.picid ) {
                $("#picturebox_" + jsonData.picid).remove();
            }
            if ( jsonData.albumid ) {
                $("#albumbox_" + jsonData.albumid).remove();
            } 
            if ( !jsonData.albumid && !jsonData.picid ) {
                alert(jsonData.message);
                window.location.reload();
            }
        } else {
            alert(jsonData.message);
        }
        $("#dialogbox").dialog("close");
    }

var historyfunc = function()
{
    window.history.go(-1);
}




