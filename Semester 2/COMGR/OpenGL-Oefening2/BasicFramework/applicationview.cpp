#include "applicationview.h"
#include "util.h"

ApplicationView::ApplicationView(QWidget *parent) : QOpenGLWidget(parent)
{
    isPlayable = false;
    timer = new QTimer();
    connect(timer, SIGNAL(timeout()), this, SLOT(update()));

    setFocusPolicy(Qt::StrongFocus);

    camPosx = 10.0,  camPosy = 0.0, camPosz = 0.0;
    camViewx = 0.0, camViewy = 0.0, camViewz = 0.0;
    camUpx = 0.0,   camUpy = 1.0,   camUpz = 0.0;
}

void ApplicationView::changeCam(float posX, float posY, float posZ, float lookAtX, float lookAtY, float lookAtZ, float upX, float upY, float upZ)
{
    camPosx = posX;
    camPosy = posY;
    camPosz = posZ;

    camViewx = lookAtX;
    camViewy = lookAtY;
    camViewz = lookAtZ;

    camUpx = upX;
    camUpy = upY;
    camUpz = upZ;
}

void ApplicationView::togglePlayable()
{
    isPlayable = isPlayable ? false : true;
    if (isPlayable)
        camViewx = camPosx;
        camViewy = camPosy;
        camViewz = camPosz - 1;
}

bool ApplicationView::getPlayable()
{
    return isPlayable;
}

void ApplicationView::initializeGL()
{
    secondsPassed = 0;

    // Initialize QGLWidget (parent)
    QOpenGLWidget::initializeGL();

    glEnable(GL_DEPTH_TEST);

    // Black canvas
    glClearColor(0.0f,0.0f,0.0f,0.0f);

    timer->start(50);
}

void ApplicationView::resizeGL(int width, int height)
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

void ApplicationView::paintGL()
{
    secondsPassed++;

    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);

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


    glPopMatrix();
}

void ApplicationView::keyPressEvent( QKeyEvent * e )
{
    if (isPlayable)
        movePlayer(e);
    else
        moveCamera(e);
}

void ApplicationView::moveCamera( QKeyEvent * e)
{
    if(e->key() == Qt::Key_Up)
        this->camPosy += 0.5;
    if(e->key() == Qt::Key_Down)
        this->camPosy -= 0.5;
}

void ApplicationView::movePlayer( QKeyEvent * e )
{
    switch (e->key()) {
    case (Qt::Key_Up):
        updateLookingDirection(-1);
        break;
    case (Qt::Key_Down):
        updateLookingDirection(+1);
        break;
    case (Qt::Key_Right):
        turnRight();
        break;
    case (Qt::Key_Left):
        turnLeft();
        break;
    }
}

void ApplicationView::updateLookingDirection(int incr)
{
    switch(currentDirection) {
    case DIRECTION::NORTH:
        camPosz += incr;
        camViewz += incr;
        break;
    case DIRECTION::EAST:
        camPosx -= incr;
        camViewx -= incr;
        break;
    case DIRECTION::SOUTH:
        camPosz -= incr;
        camViewz -= incr;
        break;
    case DIRECTION::WEST:
        camPosx += incr;
        camViewx += incr;
        break;
    }
}

void ApplicationView::turnLeft()
{
    switch(currentDirection) {
    case DIRECTION::NORTH:
        camViewx = camPosx-1;
        camViewz = camPosz;
        currentDirection = DIRECTION::WEST;
        break;
    case DIRECTION::WEST:
        camViewx = camPosx;
        camViewz = camPosz+1;
        currentDirection = DIRECTION::SOUTH;
        break;
    case DIRECTION::SOUTH:
        camViewx = camPosx+1;
        camViewz = camPosz;
        currentDirection = DIRECTION::EAST;
        break;
    case DIRECTION::EAST:
        camViewx = camPosx;
        camViewz = camPosz-1;
        currentDirection = DIRECTION::NORTH;
        break;
    }
}


void ApplicationView::turnRight()
{
    switch(currentDirection) {
    case DIRECTION::NORTH:
        camViewx = camPosx+1;
        camViewz = camPosz;
        currentDirection = DIRECTION::EAST;
        break;
    case DIRECTION::EAST:
        camViewx = camPosx;
        camViewz = camPosz+1;
        currentDirection = DIRECTION::SOUTH;
        break;
    case DIRECTION::SOUTH:
        camViewx = camPosx-1;
        camViewz = camPosz;
        currentDirection = DIRECTION::WEST;
        break;
    case DIRECTION::WEST:
        camViewx = camPosx;
        camViewz = camPosz-1;
        currentDirection = DIRECTION::NORTH;
        break;
    }
}


