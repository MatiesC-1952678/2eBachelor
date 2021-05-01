#include "planetsview.h"
#include "util.h"

PlanetsView::PlanetsView(QWidget *parent) : QOpenGLWidget(parent)
{
	timer = new QTimer();
	connect( timer, SIGNAL(timeout()), this, SLOT(update()) );

	setFocusPolicy(Qt::StrongFocus);

	camPosx = 3.0,  camPosy = 5.0,    camPosz = 25.0;
	camViewx = 0.0, camViewy = 0.0, camViewz = 0.0;
	camUpx = 0.0,   camUpy = 1.0,   camUpz = 0.0;
}

void PlanetsView::initializeGL ()
{
	this->dayOfYear = 0;
	this->hourOfDay = 0;

	// Initialize QGLWidget (parent)
	QOpenGLWidget::initializeGL();

	glShadeModel(GL_SMOOTH);

	// Black canvas
	glClearColor(0.0f,0.0f,0.0f,0.0f);

	// Place light
	glEnable( GL_LIGHTING );
	glEnable( GL_LIGHT0 );
	glEnable(GL_DEPTH_TEST);

	GLfloat light0_position [] = {0.1f, 0.1f, 0.1f, 0.1f};
	GLfloat light_diffuse []={ 1.0, 1.0, 1.0, 1.0 };
	glLightfv ( GL_LIGHT0, GL_POSITION, light0_position );
	glLightfv ( GL_LIGHT0, GL_DIFFUSE, light_diffuse );

	timer->start(50);
}

void PlanetsView::resizeGL ( int width, int height )
{
	if ((width<=0) || (height<=0))
		return;

	//set viewport
	glViewport(0,0,width,height);

	glMatrixMode(GL_PROJECTION);
	glLoadIdentity();

	//set persepective
	//change the next line order to have a different perspective
	GLdouble aspect_ratio=(GLdouble)width/(GLdouble)height;
	gluPerspective(40.0, aspect_ratio, 1.0, 100.0);

	glMatrixMode(GL_MODELVIEW);
	glLoadIdentity();
}

void PlanetsView::paintGL()
{
	this->dayOfYear = (this->dayOfYear+1);
	this->hourOfDay = (this->hourOfDay+1) % 24;

	glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);

	glLoadIdentity();

	// store current matrix
	glMatrixMode( GL_MODELVIEW );
	glPushMatrix( );

	gluLookAt(camPosx ,camPosy ,camPosz,
	          camViewx,camViewy,camViewz,
			  camUpx, camUpy, camUpz );

	//Draw Axes
	glDisable( GL_LIGHTING );
	glBegin(GL_LINES);
	glColor3f(1.0, 0.0, 0.0);
	glVertex3f(0.0, 0.0, 0.0);
	glVertex3f(10.0, 0.0, 0.0);
	glColor3f(0.0, 1.0, 0.0);
	glVertex3f(0.0, 0.0, 0.0);
	glVertex3f(0.0, 10.0, 0.0);
	glColor3f(0.0, 0.0, 1.0);
	glVertex3f(0.0, 0.0, 0.0);
	glVertex3f(0.0, 0.0, 10.0);
	glEnd();
	glEnable( GL_LIGHTING );

	// rotate the plane of the elliptic
	glRotated ( 5.0, 1.0, 0.0, 0.0 );

	// draw the sun
	GLfloat diff [] = { 0.7f , 0.5f , 0.0f };
	glMaterialfv ( GL_FRONT, GL_DIFFUSE, diff );

	//glutSolidSphere( 3.0, 25, 25 );
        Util::drawSolidSphere(3.0, 25, 25);

	// rotate the earth around the sun
	glRotated( (GLdouble)(360.0 * dayOfYear /365.0), 0.0, 1.0, 0.0 );
	glTranslated ( 4.0, 0.0, 0.0 );
	// rotate the earth around its axis

	glRotated( (GLdouble)(360.0 * hourOfDay/24.0), 0.0, 1.0, 0.0 );
	// draw the earth
	GLfloat diff2 [] = { 0.2f , 0.2f , 0.8f };
	glMaterialfv ( GL_FRONT, GL_DIFFUSE, diff2 );
	//glutSolidSphere( 0.3,  25, 25 );
        Util::drawSolidSphere(0.3, 25, 25);

	// restore current matrix
	glMatrixMode( GL_MODELVIEW );
	glPopMatrix( );		
}

void PlanetsView::keyPressEvent( QKeyEvent * e )
{
	if(e->key() == Qt::Key_Up)
		this->camPosy += 0.5;
	if(e->key() == Qt::Key_Down)
		this->camPosy -= 0.5;
}
