#include "cg_MainWindow.h"
#include <QPainter>

//--------------------------------------------------------------------
cg_MainWindow::cg_MainWindow()
{
	ui = new Ui_CG_Window();
	ui->setupUi(this);

	draw_tool = new CG1_DrawTool();
	draw_tool->setCanvasRef(ui->drawCanvas);

	connect(ui->pushButton_Save, SIGNAL(clicked()), ui->drawCanvas, SLOT(slotSaveImage()));
	connect(ui->pushButton_ClipUp, SIGNAL(clicked()), this, SLOT(slotButtonClipUp()));
	connect(ui->pushButton_ClipDown, SIGNAL(clicked()), this, SLOT(slotButtonClipDown()));
}
//--------------------------------------------------------------------
cg_MainWindow::~cg_MainWindow()
{
	delete draw_tool;
	delete ui;
}
//--------------------------------------------------------------------
void cg_MainWindow::slotButtonClipUp()
{
	draw_tool->ClipUp();
}
//--------------------------------------------------------------------
void cg_MainWindow::slotButtonClipDown()
{
	draw_tool->ClipDown();
}
//--------------------------------------------------------------------
void cg_MainWindow::paintEvent(QPaintEvent *e)
{
	if(draw_tool)
		draw_tool->DrawData();

	ui->drawCanvas->update();
}
//--------------------------------------------------------------------
void cg_MainWindow::resizeEvent(QResizeEvent *e)
{
	//...
}