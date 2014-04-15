/**
* upload files javascript 
* run on swfupload and jquery 1.3.2
* @version 1.0.0
* @author Xiaohui
*/

var fileSelectedEventHandler = function(selected_num,queued_num) {
    try {
        if ( selected_num > this.settings.file_upload_limit  ) {
            $("#swfu_upload_list").prepend("<div>超过限定的文件数目</div>");
        }
        if ( this.getStats().files_queued > this.settings.file_upload_limit ) {
            alert("错误!上传文件大于" + this.settings.file_upload_limit );
        }
    } catch (ex) {alert(this.debug(ex));}
}

var fileQueuedEventHandler = function(file_obj) {
     try {
        if ( this.getStats().files_queued ) {
            var obj = $("#swfu_upload_list_box");
            var html = "";
            var size = Math.ceil((file_obj.size/1024) * 100) /100;
            $("#swfu_upload_box_head").html("共选择" + (this.getStats().files_queued) + "个文件");
            html = obj.html() + "<li id='" + file_obj.id + "' ><em onclick=\"javascript:cancelUploadFile('"+file_obj.id+"')\">删除</em> <span>大小: " + size +  "Kb ; 进度: 0% </span> " + file_obj.name + "</li>";
            obj.html(html);
            $("#swfu_upload_list").show();
        }
    } catch(ex) {}
}

var uploadStartEventHandler = function(file_obj) {
    var continue_with_upload = true; 
    try {
        if ( this.getStats().files_queued == 0 ) {
            this.stopUpload();
            alert("没有可上传的文件!");
        }
        return continue_with_upload;
    } catch(ex) {}
}

var uploadProgressEventHandler = function(file_obj, upload_size, file_size) {
    try {
        var percent = Math.ceil((file_size / upload_size) * 100);
        var str = "大小: " + ( Math.ceil((file_size/1024) * 100)/100 )+ " Kb ; 进度: " + percent + "%" ;
        $("#swfu_upload_box_head").html( "还有" + (this.getStats().files_queued) + "个文件未完成, " + " 正在上传 " + file_obj.name + " " + percent + "%");
        $("#"+file_obj.id + " > span").text(str);
        $("#"+file_obj.id + " > em").remove();
    } catch(ex) {}
}

var uploadCompleteEventHandler = function ( file_obj ) {
    try {
        if (this.getStats().files_queued > 0) {
            this.startUpload();
        } else {
            $("#swfu_upload_box_head").html("上传完成! <a href=\"album.php?albumId=" +this.settings.post_params.albumId + "\">返回相册</a> ");
        }
    } catch(ex) {}
}

var uploadSuccessEventHandler = function(file_obj, server_data) {
    var json = eval('(' + server_data + ')');
    var c ;
    try {
        if ( json.status == "200") {
            c = "success";
        } else {
            c = "error"
        }
        $("#"+file_obj.id ).prepend("<strong>" + json.message + "</strong>").addClass(c);
    } catch(ex) {}
}

var uploadErrorEventHandler = function(file_obj, error_code, message) {
    try {
        switch(error_code) {
            case SWFUpload.ERROR_CODE_QUEUE_LIMIT_EXCEEDED:
                message = "You have attempted to queue too many files.";
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                message = "文件大小为0";
                break;
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                message = "文件太大";
                break;
            default:
                message = message;
        }
        $("#"+file_obj.id ).prepend("<strong>" + message + "</strong>").addClass("error");
    } catch(ex) {}
}

var cancelUploadFile = function(file_id) {
    if ( !$("#"+file_id).length ) {
        return;
    }
    $("#"+file_id).remove();
    swfu.cancelUpload(file_id);
    return;
}

var write_swfu_button = function(){}