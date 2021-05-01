#ifndef CG_MAINWINDOW_H
#define CG_MAINWINDOW_H

#include <QMainWindow>
#include <QKeyEvent>
#include "ui_cg_window.h"
#include "CG1_DrawTool.h"

class cg_MainWindow: public QMainWindow
{
	Q_OBJECT

public:
	cg_MainWindow();
	virtual ~cg_MainWindow();

private:
	Ui_CG_Window* ui;
	CG1_DrawTool* draw_tool;

public slots:
	void slotButtonClipUp();
	void slotButtonClipDown();

protected:
	void paintEvent(QPaintEvent *e);
	void resizeEvent(QResizeEvent *e);
	void keyPressEvent(QKeyEvent* event);
};

#endif 
