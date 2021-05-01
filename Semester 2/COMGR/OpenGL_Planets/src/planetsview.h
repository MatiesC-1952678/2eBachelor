
#ifndef PLANETSVIEW_H
#define PLANETSVIEW_H

// include files for QT
#include <QOpenGLWidget>
#include <QTimer>
#include <QKeyEvent>

class PlanetsView : public QOpenGLWidget
{
	Q_OBJECT
public:
	PlanetsView(QWidget *parent=0);

protected:
	void initializeGL ();
	void resizeGL ( int width, int height );
	void paintGL ();

	void keyPressEvent(QKeyEvent * e);

private:
	int dayOfYear, hourOfDay;
	double camPosx,camPosy,camPosz;
	double camUpx,camUpy,camUpz;
	double camViewx,camViewy,camViewz;
	QTimer* timer;
};

#endif
