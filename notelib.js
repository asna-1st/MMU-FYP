var submitStatus = false;
var checkEditedContent = false;
var editContent;

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

function insertLink(link) {
  if(link) {
    var textSel = richTextArea.document.getSelection();
    richTextArea.document.execCommand('insertHTML', false, '<a href="' + link +  '" target="_blank">' + textSel + '</a>');
  }
}

/* function getContent() {
  var frameObj = document.getElementById("richTextArea");
  var frameContent = frameObj.contentWindow.document.body.innerHTML;
  createCookie(frameContent);
} */

function getContent() {
  var frameObj = document.getElementById("richTextArea");
  var frameContent = frameObj.contentWindow.document.body.innerHTML;
  document.getElementById("noteContent").value = frameContent;
}

window.addEventListener('beforeunload', (event) => {
  var frameObj = document.getElementById("richTextArea");
  var frameContent = frameObj.contentWindow.document.body.innerHTML;

  if (frameContent.length != 0 && !submitStatus && !checkEditedContent) {
    event.preventDefault();
    event.returnValue = '';
  } else if (editContent != frameContent && !submitStatus && checkEditedContent){
    event.preventDefault();
    event.returnValue = '';
  }
  // event.returnValue = (frameContent);
});

function emptyTitle(event) {
  var titleContent = document.getElementById("titleText").value;

  if (titleContent == "") {
    event.preventDefault();
    $("#titleError").modal("show");
    return false;
  } else {
    submitStatus = true;
  }
}