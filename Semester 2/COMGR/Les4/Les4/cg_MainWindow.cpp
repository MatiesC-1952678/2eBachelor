#include "cg_MainWindow.h"
#include <QPainter>
#include <stdio.h>

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
//--------------------------------------------------------------------
void cg_MainWindow::keyPressEvent(QKeyEvent* event)
{
	if(draw_tool)
	{
		switch(event->key())
		{
		case Qt::Key_Left:	// left-button
			draw_tool->ModifyView('x', -2);
			break;
		case Qt::Key_Up:	// up-button
			draw_tool->ModifyView('y', +2);
			break;
		case Qt::Key_Right:	// right-button
			draw_tool->ModifyView('x', +2);
			break;	
		case Qt::Key_Down:	// down-button
			draw_tool->ModifyView('y', -2);
			break;
		case Qt::Key_PageUp:	// back-button
			draw_tool->ModifyView('z', -2);
			printf("Z-\n");
			break;	
		case Qt::Key_PageDown:	// front-button
			draw_tool->ModifyView('z', +2);
			break;
		case Qt::Key_Y: // y-key
			draw_tool->ModifyView('r', +2);
			break;
		}
	}
	ui->drawCanvas->update();
}
