#include "planets.h"

PlanetsApp::PlanetsApp()
{
	setWindowTitle("CG1 Planets");
	resize(640, 480);
	initView();
}

void PlanetsApp::initView()
{
	setCentralWidget(&view);
}
