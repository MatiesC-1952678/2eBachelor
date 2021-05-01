#ifndef CG_CANVAS_H
#define CG_CANVAS_H

#include <QWidget>
#include "RGB_Color.h"


class cg_Canvas: public QWidget  
{
	Q_OBJECT

public:
	cg_Canvas(QWidget *parent = 0);
	virtual ~cg_Canvas();

	void putPixel(int x, int y, RGB_Color c);
	void clear();

protected:
	void paintEvent(QPaintEvent *e);
	void resizeEvent(QResizeEvent *e);

public slots:
	void slotSaveImage();

private:	
	QImage* image;


};

#endif
