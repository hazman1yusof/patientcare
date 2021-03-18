//ui.js

/** Copyright (c) 2020 Mesibo
 * https://mesibo.com
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the terms and condition mentioned
 * on https://mesibo.com as well as following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions, the following disclaimer and links to documentation and
 * source code repository.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * Neither the name of Mesibo nor the names of its contributors may be used to
 * endorse or promote products derived from this software without specific prior
 * written permission.
 *
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Documentation
 * https://mesibo.com/documentation/
 *
 * Source Code Repository
 * https://github.com/mesibo/messenger-javascript
 *
 *
 */

const MESIBO_FILETYPE_IMAGE = 1;
const MESIBO_FILETYPE_VIDEO = 2;
const MESIBO_FILETYPE_AUDIO = 3;
const MESIBO_FILETYPE_LOCATION = 4;

// Get the matching status tick icon
let getStatusClass = (status) => {
        // MesiboLog("getStatusClass", status);
        var statusTick = "";
        switch (status) {

                case MESIBO_MSGSTATUS_SENT:
                        statusTick = "far fa-check-circle";
                        break;

                case MESIBO_MSGSTATUS_DELIVERED:
                        statusTick = "fas fa-check-circle";
                        break;


                case MESIBO_MSGSTATUS_READ:
                        statusTick = "fas fa-check-circle";
                        break;

                default:
                        statusTick = "far fa-clock";
        }

        //MESIBO_MSGSTATUS_FAIL is 0x80
        if(status > 127) 
            statusTick = "fas fa-exclamation-circle";

        return statusTick;
};


// If the status value is read type, color it blue. Default color of status icon is gray
let getStatusColor = (status) => {
        var statusColor = "";
        switch (status) {
                case MESIBO_MSGSTATUS_READ:
                        statusColor = "#34b7f1";
                        break;

                default:
                        statusColor = "grey";
        }
        //MESIBO_MSGSTATUS_FAIL is 0x80
        if(status > 127) 
            statusColor = "red";

        return statusColor;
};

let getFileIcon = (f) =>{

    if(!isValid(f))
	return;

    var type = f.filetype;
    if(undefined == type)
        return "";


    var fileIcon = "fas fa-paperclip";
    switch (type) {

            //Image
            case MESIBO_FILETYPE_IMAGE:
                    fileIcon = "fas fa-image";
                    break;

            //Video
            case MESIBO_FILETYPE_VIDEO:
                    fileIcon = "fas fa-video";
                    break;

            //Audio
            case MESIBO_FILETYPE_AUDIO:
                    fileIcon = "fas fa-music";
                    break;

            //Location
            case MESIBO_FILETYPE_LOCATION:
                    fileIcon = "fas fa-map-marker-alt";
    }

    return fileIcon;

}

let getFileTypeDescription = (f) =>{

    var type = f.filetype;
    if(!isValid(type))
        return "";

    var fileType = "Attachment";
    switch (type) {

            //Image
            case MESIBO_FILETYPE_IMAGE:
                    fileType = "Image";
                    break;

            //Video
            case MESIBO_FILETYPE_VIDEO:
                    fileType = "Video";
                    break;

            //Audio
            case MESIBO_FILETYPE_AUDIO:
                    fileType = "Audio";
                    break;

            //Location
            case MESIBO_FILETYPE_LOCATION:
                    fileType = "Location";
    }

    //xxTODOxx: For link preview
    // if(isValidString(f.launchurl))
    //     filetype = "Link"

    return fileType;

}

let isSentMessage = (status) =>{
        if(status == MESIBO_MSGSTATUS_RECEIVEDREAD  || status == MESIBO_MSGSTATUS_RECEIVEDNEW)
            return false;
        else
            return true;
};


let imgError = (image) => {
    MesiboLog("imgError");
    image.onerror = "";
    image.src = "data:image/png;base64,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";
    return true;
}

/*** For debugging purposes only **/
let getScope = () =>{
    return angular.element(document.getElementById('mesibowebapp')).scope();
}

/** For testing link preview **/ 
let getSampleLinkPreview = () =>{
    var linkPreview = {};
    linkPreview.title = "Chat API and SDK for Messaging, Voice and Video Call | Android, iOS and Website | mesibo";
    linkPreview.image = "https://mesibo.com/assets/images/mesibo-favicon.png";
    linkPreview.description = "mesibo is a real-time communication platform, provides chat API and messaging SDK to add messaging, voice and video calls in Android & iOS apps and websites. It is Free to start."; 
    linkPreview.hostname = "mesibo.com";
    linkPreview.url = "https://mesibo.com/";
    
    return linkPreview;
}


let scrollToEnd = (animate) =>{
    var objDiv = document.getElementById("messages");
    if(!objDiv)
        return;

    // MesiboLog("Scroll to last", objDiv, objDiv.scrollTop);
    if(animate)        
        $("#messages").animate({ scrollTop: objDiv.scrollHeight}, 800);
    else
        objDiv.scrollTop = objDiv.scrollHeight;


}



let adjustImageDims = (e)=>{

    // MesiboLog("adjustImageDims", e);
    if(!e)
        return;


    var w = e.width;
    var h = e.height;


    if(!(w && h))
        return;

    var ar = w/h;

    if(ar < 1){
        // MesiboLog("adjustImageDims", e.style.maxWidth);
        e.style.objectFit = "cover";
    }

}


let adjustVideoDims = (e)=>{
    
    // MesiboLog("adjustVideoDims", e);
    if(!e)
        return;

    var w = e.videoWidth;
    var h = e.videoHeight;

    if(!(w && h))
        return;


    var ar = w/h;

    if(ar < 1){
        // MesiboLog("adjustImageDims", e.style.maxWidth);
        e.style.objectFit = "cover";
    }
}

