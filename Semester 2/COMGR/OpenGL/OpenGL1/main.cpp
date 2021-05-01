#include <QApplication>
#include "planets.h"

int main(int argc, char *argv[])
{
	QApplication app(argc, argv);
	PlanetsApp planets;
	app.setActiveWindow(&planets);
	planets.show();
	return app.exec();
}
