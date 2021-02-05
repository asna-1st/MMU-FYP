const editor = document.getElementsByClassName('editor')[0];
const toolbar = editor.getElementsByClassName('toolbar')[0];
const buttons = toolbar.querySelectorAll('.btn:not(.has-submenu)');
for(let i = 0; i < buttons.length; i++) {
  let button = buttons[i];
  
  button.addEventListener('click', function(e) {
    let action = this.dataset.action;
    
    switch(action) {
      case 'code':
        execCodeAction(this, editor);
        break;
      case 'createLink':
        execLinkAction();
        break;
      default:
        execDefaultAction(action);
    }
    
  });
}
function execCodeAction(button, editor) {
  const contentArea = editor.getElementsByClassName('content-area')[0];
  const visuellView = contentArea.getElementsByClassName('visuell-view')[0];
  const htmlView = contentArea.getElementsByClassName('html-view')[0];
  if(button.classList.contains('active')) { // show visuell view
    visuellView.innerHTML = htmlView.value;
    htmlView.style.display = 'none';
    visuellView.style.display = 'block';
    button.classList.remove('active');     
  } else {  // show html view
    htmlView.innerText = visuellView.innerHTML;
    visuellView.style.display = 'none';
    htmlView.style.display = 'block';
    button.classList.add('active'); 
  }
}
function execLinkAction() {
  let linkValue = prompt('Link (e.g. https://webdeasy.de/)');
  document.execCommand('createLink', false, linkValue);
}
function execDefaultAction(action) {
  document.execCommand(action, false);
}