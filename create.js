function enableEdit() {
  richTextArea.document.designMode = 'On';
}

function execCmd(command) {
  richTextArea.document.execCommand(command, false, null);
}

function execCommandArg(command, arg) {
  if(arg === ""){
    
  } else if(arg) {
    richTextArea.document.execCommand(command, false, arg);
  }
}

function getContent() {
  var frameObj = document.getElementById("richTextArea");
  var frameContent = frameObj.contentWindow.document.body.innerHTML;
  createCookie(frameContent);
}

function createCookie(value) { 
  var date = new Date(); 
  date.setTime(date.getTime() + 30000); 
  expires = "; expires=" + date.toGMTString();
    
  document.cookie = encodeURI("tempNote") + "=" +  
      encodeURI(value) + expires + "; path=/"; 
} 