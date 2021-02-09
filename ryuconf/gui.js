const { app,BrowserView, BrowserWindow, Menu} = require('electron')

function createWindow()
{
	const win = new BrowserWindow({
		width:800,
		height:600,
		resizeable:true,
		maximizable:true
	});

	const view = new BrowserView();

	Menu.setApplicationMenu(null);
	win.setBrowserView(view);
	 view.setBounds({x:0 ,y:0 , width:800,height:600})
  	view.webContents.loadURL('http://localhost:6969')
}

app.whenReady().then(createWindow)

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit()
  }
})

app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    createWindow()
  }
})