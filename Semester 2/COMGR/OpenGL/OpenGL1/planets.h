
#ifndef PLANETS_H
#define PLANETS_H

// include files for QT
#include <QMainWindow>

// application specific includes
#include "planetsview.h"

class PlanetsApp : public QMainWindow
{
	Q_OBJECT

public:
	PlanetsApp();

	void initView();

private:
	PlanetsView view;
};
#endif 

