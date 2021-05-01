#include "cg_Canvas.h"
#include <QRect>
#include <QColor>
#include <QPainter>
#include <stdio.h>

//--------------------------------------------------------------------
cg_Canvas::cg_Canvas(QWidget *parent) : QWidget(parent)
{
	image = new QImage(width(), height(), QImage::Format_RGB32);
	uint c = QColor(255, 255, 255).rgb();
	image->fill(c);
}
//--------------------------------------------------------------------
cg_Canvas::~cg_Canvas()
{
	delete image;
}
//--------------------------------------------------------------------
void cg_Canvas::putPixel(int x, int y, RGB_Color color)
{
	QColor c = QColor(color.r*255, color.g*255, color.b*255);

	int half_w = width() / 2;
	int half_h = height() / 2;
	
	int Xpos = x + half_w;
	int Ypos = -y + half_h;
	
	if(Xpos > 0 && Ypos > 0 && Xpos < width() && Ypos < height())
	{
		image->setPixel(Xpos, Ypos, c.rgb());
	}
}
//--------------------------------------------------------------------
void cg_Canvas::paintEvent(QPaintEvent *e)
{
	QPainter painter(this);
	QRect r = image->rect();
    painter.drawImage(r, *image);
}
//--------------------------------------------------------------------
void cg_Canvas::resizeEvent(QResizeEvent *e)
{
	QWidget::resizeEvent(e);
	
	int w = width() > image->width() ? width() : image->width();
	int h = height() > image->height() ? height() : image->height();
	
	delete image;
	image = new QImage(w, h, QImage::Format_RGB32);
	uint c = QColor(255, 255, 255).rgb();
	image->fill(c);
}
//--------------------------------------------------------------------
void cg_Canvas::slotSaveImage()
{
	if(image->save("Image.bmp", "BMP"))
		printf("Image saved as \"Image.bmp\"\n");
	else
		printf("an error occured while writing to \"Image.bmp\"\n");
}
//--------------------------------------------------------------------
void cg_Canvas::clear()
{
	uint c = QColor(255, 255, 255).rgb();
	image->fill(c);
}
//--------------------------------------------------------------------